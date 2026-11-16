(function(){
var burger=document.getElementById('burger'),drawer=document.getElementById('drawer');
if(burger&&drawer){burger.addEventListener('click',function(){var o=drawer.hidden;drawer.hidden=!o;burger.setAttribute('aria-expanded',String(o));});}
var dd=document.querySelectorAll('.zv-dropdown');
dd.forEach(function(d){var b=d.querySelector('button'),p=d.querySelector('.zv-dropdown__panel'),tm=null,pin=false;
function set(o){p.hidden=!o;b.setAttribute('aria-expanded',String(o));if(!o)pin=false;}
function closeSoon(){clearTimeout(tm);tm=setTimeout(function(){if(!pin)set(false);},350);}
b.addEventListener('click',function(e){e.stopPropagation();if(!p.hidden&&pin){set(false);}else{pin=true;set(true);}});
d.addEventListener('mouseenter',function(){clearTimeout(tm);set(true);});d.addEventListener('mouseleave',closeSoon);
d.addEventListener('focusin',function(){clearTimeout(tm);});
document.addEventListener('click',function(e){if(!d.contains(e.target))set(false);});
d.addEventListener('keydown',function(e){if(e.key==='Escape'){set(false);b.focus();}});});
var t=document.getElementById('ts');if(t){t.value=String(Math.floor(Date.now()/1000));}
var q=new URLSearchParams(location.search),sel=document.getElementById('topic');
if(sel&&q.get('topic')){sel.value=q.get('topic');}
if(q.get('sent')==='1'){var a=document.getElementById('sent');if(a)a.hidden=false;}
if(q.get('err')){var e2=document.getElementById('err');if(e2)e2.hidden=false;}
})();