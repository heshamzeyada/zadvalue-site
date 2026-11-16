# ZadValue static site: deployment and rollback

This folder is a complete, ready-to-upload website (HTML, CSS, a little JavaScript, one PHP form script). Nothing here has been uploaded to zadvalue.com.

## 1. Before anything else (owner, in Bluehost)
1. In Bluehost, make a full backup of the current site and download it (files and database).
2. Create a staging location: a subdomain such as staging.zadvalue.com (Bluehost > Websites > Settings > Subdomains, or cPanel > Subdomains) with its own folder.

## 2. Test on staging
1. Upload the contents of this folder into the staging folder (File Manager > Upload, or FTP).
2. Rename `.htaccess.zadvalue` to `.htaccess` in the staging folder only after checking the staging host name. Remove the HTTPS/www redirect lines if testing on a subdomain.
3. Check every page on desktop and phone, submit the contact form once per topic and confirm each mailbox receives it (info@, meeting@, wecare@).
4. Review the copy, the portrait placeholder, and the figures (as of January 2026).

## 3. Go live (after the owner's written approval)
1. Keep the WordPress files: move them into a folder named `wp-old` (do not delete) and keep a copy of the existing `.htaccess` as `.htaccess.wordpress`.
2. Upload this folder's contents to the site root and rename `.htaccess.zadvalue` to `.htaccess`.
3. Test https://zadvalue.com/, all 12 existing page URLs, the contact form, /sitemap.xml and /robots.txt.
4. Submit /sitemap.xml in Google Search Console. Update titles and descriptions later in the HTML if needed.

## 4. Rollback (about 5 minutes)
Delete or rename the new files, restore `.htaccess.wordpress` to `.htaccess`, and move the WordPress files back from `wp-old`. If anything is damaged, restore the Bluehost backup from step 1.

## Notes
- URLs preserved: /, /about/, /meet-our-ceo/, /core-values/, /services/, /pharmaceutical-consulting/, /biotech-consulting/, /medtech-consulting/, /medical-nutrition-consulting/, /experience/, /contact/, /privacy-policy/. New: /industries/, /markets/.
- Email is unaffected: no DNS change is needed.
- Placeholders to finish: CEO portrait (add `images/hesham-zeyada.webp` and replace the placeholder block in `meet-our-ceo/index.html`), and legal review of the privacy policy.
- WordPress is not running after cutover, so Rank Math, WPForms, Jetpack and MonsterInsights stop working. Google Analytics would need a small tag added to every page if you want it back.
