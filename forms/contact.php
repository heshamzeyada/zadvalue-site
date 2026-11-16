<?php
// ZadValue contact form handler. Plain PHP, no dependencies.
declare(strict_types=1);
const MAILBOX = [
    'general'  => 'info@zadvalue.com',
    'meeting'  => 'meeting@zadvalue.com',
    'feedback' => 'wecare@zadvalue.com',
];
const FROM = 'info@zadvalue.com';          // must be a mailbox on this domain
const RATE_DIR = __DIR__ . '/_rate';        // blocked from the web by forms/.htaccess
const MAX_PER_HOUR = 5;

function back(string $q): void { header('Location: /contact/?' . $q, true, 303); exit; }
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') { back(''); }

// Spam traps: honeypot filled, form posted too fast (<4s) or stale (>2h)
$ts = (int)($_POST['ts'] ?? 0);
if (!empty($_POST['website']) || $ts < 1 || time() - $ts < 4 || time() - $ts > 7200) { back('sent=1'); } // look successful to bots

$clean = static fn(string $v, int $max): string => mb_substr(trim(preg_replace('/[\r\n\t]+/', ' ', $v) ?? ''), 0, $max);
$name    = $clean((string)($_POST['name'] ?? ''), 120);
$company = $clean((string)($_POST['company'] ?? ''), 160);
$email   = $clean((string)($_POST['email'] ?? ''), 160);
$topic   = (string)($_POST['topic'] ?? 'general');
$message = trim(mb_substr((string)($_POST['message'] ?? ''), 0, 4000));
if (!isset(MAILBOX[$topic])) { $topic = 'general'; }
if ($name === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) { back('err=1'); }

// Simple per-IP rate limit
$ip = hash('sha256', ($_SERVER['REMOTE_ADDR'] ?? '') . 'zv');
if (!is_dir(RATE_DIR)) { @mkdir(RATE_DIR, 0750, true); }
$f = RATE_DIR . '/' . $ip; $now = time();
$hits = is_file($f) ? array_filter(array_map('intval', file($f, FILE_IGNORE_NEW_LINES) ?: []), fn($t) => $now - $t < 3600) : [];
if (count($hits) >= MAX_PER_HOUR) { back('err=1'); }
$hits[] = $now; @file_put_contents($f, implode("\n", $hits), LOCK_EX);

$subject = 'Website enquiry (' . $topic . ') from ' . $name;
$body = "Name: $name\nCompany: $company\nEmail: $email\nTopic: $topic\n\n$message\n";
$headers = ['From' => 'ZadValue website <' . FROM . '>', 'Reply-To' => $email, 'Content-Type' => 'text/plain; charset=UTF-8', 'X-Mailer' => 'zadvalue-form'];
$ok = mail(MAILBOX[$topic], '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, $headers);
back($ok ? 'sent=1' : 'err=1');
