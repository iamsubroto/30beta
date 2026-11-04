/**
 * Immunotec She+ / She-Join Standalone Interactive Scripts
 * Pure vanilla JavaScript without external framework dependencies.
 *
 * Implements:
 * 1. Smooth Navigation & Scroll Positioning (#why and #packages)
 * 2. Mobile Section Scroll Reveal Animation (IntersectionObserver)
 * 3. Interactive Perimenopause Symptoms Conversation Thread
 * 4. Free Survival Guide Download Form Lead Capture
 * 5. Interactive Clinical Study Results SVG Chart (Vitamins/Hormones Timeline)
 * 6. Creator & Consultant Testimonial Video Slider (Vimeo Embed on Demand)
 * 7. Starter Pack Selection & Cart Flow Routing
 */

document.addEventListener('DOMContentLoaded', function () {
  console.log('Immunotec She+ Standalone Page Initialized');
});


/* === Feature Block CC 0 (builder-23e34338ff9c4c60b657054a9a8b9993) === */
(function(){
  if (window.__sjNav) return; window.__sjNav = 1;
  /* "#why" and "#packages" targets. Smooth scroll, then re-check once the page has settled,
     because the pinned conversation and lazy images change the page height mid-scroll. */
  function target(id){ return document.querySelector(id === "why" ? ".sj-why" : ".sj-packages"); }
  document.addEventListener("click", function(e){
    var a = e.target && e.target.closest ? e.target.closest('a[href="#why"],a[href="#packages"]') : null;
    if (!a) return;
    var t = target(a.getAttribute("href").slice(1)); if (!t) return;
    e.preventDefault();
    var reduce = window.matchMedia && matchMedia("(prefers-reduced-motion: reduce)").matches;
    t.scrollIntoView({ behavior: reduce ? "auto" : "smooth", block: "start" });
    [900, 1800, 3000].forEach(function(ms){ setTimeout(function(){
      if (Math.abs(t.getBoundingClientRect().top - 72) > 40) t.scrollIntoView({ behavior: "auto", block: "start" });
    }, ms); });
    if (window.dataLayer) window.dataLayer.push({ event: "see_packages_click", label: (a.textContent || "").trim().slice(0, 40) });
  });
})();
(function(){
  if (window.__sjRevTag) return; window.__sjRevTag = 1;
  /* Mobile scroll reveal, page wide (same as live): every section heading rises in with the
     eyebrow above it and the intro below it. This only tags them with sj-rv1; the reveal
     itself is the "Section helpers" block in The market, which skips anything already on screen. */
  function tag(){
    var page = document.querySelector(".sj-page"); if (!page) return;
    function isText(x){ return x && x.classList && x.classList.contains("builder-block") && x.querySelector(".builder-text") && !x.querySelector(".builder-block,img,form,iframe"); }
    Array.prototype.forEach.call(page.querySelectorAll("h2"), function(h){
      var b = h.closest(".builder-block"); if (!b || b.closest(".sj-rv,.sj-rv1")) return;
      [b.previousElementSibling, b, b.nextElementSibling].forEach(function(x){ if (isText(x)) x.classList.add("sj-rv1"); });
    });
  }
  setTimeout(tag, 250);
})();

/* === Feature Block CC 2 (builder-1d89264965f14867b0641396d6f28186) === */
(function(){var thread=document.getElementById("convoThread");if(!thread||thread.getAttribute("data-ready"))return;thread.setAttribute("data-ready","1");var EXCHANGES=[["Estoy agotada para las dos de la tarde.","Es solo tu edad."],["Me despierto a las 3 de la mañana todas las noches.","Intenta acostarte más temprano."],["Me quemo de calor y después me muero de frío.","A todas les dan bochornos."],["No encuentro la palabra que quiero.","Nos pasa a todas."],["Me duelen las articulaciones al levantarme.","Desgaste. Pasa."],["Ya no me siento yo misma.","Es una etapa."],["Solo estoy envejeciendo, ¿verdad?","Sí. Así es."]];function q(s){return "“"+s+"”";}var html="";for(var i=0;i<EXCHANGES.length;i++){var key=(i===EXCHANGES.length-1)?" key":"";html+="<div class=\"turn her"+key+"\"><span class=\"bub\">"+q(EXCHANGES[i][0])+"</span></div>";html+="<div class=\"turn them"+key+"\"><span class=\"bub\">"+q(EXCHANGES[i][1])+"</span></div>";}thread.innerHTML=html;var targets=Array.prototype.slice.call(thread.querySelectorAll(".turn"));var queue=[],busy=false;function pump(){if(busy)return;var el=queue.shift();if(!el)return;busy=true;el.classList.add("on");setTimeout(function(){busy=false;pump();},170);}function reveal(el){if(!el||el.__q||el.classList.contains("on"))return;el.__q=1;queue.push(el);pump();}if("IntersectionObserver" in window){var io=new IntersectionObserver(function(es){es.forEach(function(e){if(e.isIntersecting){reveal(e.target);io.unobserve(e.target);}});},{threshold:.08,rootMargin:"0px 0px -8% 0px"});targets.forEach(function(el){io.observe(el);});}else{targets.forEach(reveal);}var WIN=0.70,CAP=580,PACE=1.5,TOP=40;var convo=thread.closest?thread.closest(".convo"):null;if(!convo)return;var mq=window.matchMedia("(max-width: 900px)");var rail=null,inner=null,screen=null,started=false,raf=0,maxScroll=0;function build(){if(started||!mq.matches)return;var turns=thread.querySelectorAll(".turn");if(turns.length<4)return;started=true;inner=document.createElement("div");inner.className="thr-in";while(thread.firstChild)inner.appendChild(thread.firstChild);screen=document.createElement("div");screen.className="ph-screen";screen.appendChild(inner);var veilT=document.createElement("div");veilT.className="ph-veil";var veilB=document.createElement("div");veilB.className="ph-veil bot";screen.appendChild(veilT);screen.appendChild(veilB);var chassis=document.createElement("div");chassis.className="ph-chassis";chassis.appendChild(screen);thread.appendChild(chassis);document.documentElement.classList.add("pin-on");if(/[?&]phone=static/.test(location.search)){document.documentElement.classList.add("pin-static");return;}rail=document.createElement("div");rail.className="pin-rail";thread.parentNode.insertBefore(rail,thread);rail.appendChild(thread);measure();window.addEventListener("scroll",tick,{passive:true});window.addEventListener("resize",function(){measure();tick();});tick();}function measure(){var scrH=Math.round(Math.min(window.innerHeight*WIN,CAP));screen.style.setProperty("--scr-h",scrH+"px");TOP=Math.max(16,Math.round((window.innerHeight-thread.offsetHeight)/2));thread.style.top=TOP+"px";maxScroll=Math.max(0,inner.scrollHeight-scrH);rail.style.height=Math.round(thread.offsetHeight+maxScroll*PACE)+"px";}function tick(){if(raf)return;raf=requestAnimationFrame(function(){raf=0;if(!started)return;var r=rail.getBoundingClientRect();var travel=rail.offsetHeight-thread.offsetHeight;if(travel<=0)return;var p=(TOP-r.top)/travel;p=p<0?0:(p>1?1:p);inner.style.transform="translate3d(0,"+(-p*maxScroll).toFixed(1)+"px,0)";});}if(mq.addEventListener)mq.addEventListener("change",build);else if(mq.addListener)mq.addListener(build);window.addEventListener("orientationchange",function(){setTimeout(function(){if(started){measure();tick();}else{build();}},140);});if(document.fonts&&document.fonts.ready){document.fonts.ready.then(function(){setTimeout(build,60);});}setTimeout(build,700);})();

/* === Feature Block CC 3 (builder-075e98a448d446b2b862f5370ece8fa2) === */
(function(){if(window.__sjGuide)return;window.__sjGuide=1;var ENDPOINT="https://back.immunotec.com/customer/customer-lead",FORM_NAME="sheplus-opportunity";var seg=location.pathname.split("/").filter(Boolean);var isLoc=seg[0]&&/^[a-z]{2}-[a-z]{2}$/i.test(seg[0]);var CULTURE=isLoc?seg[0]:"en-US";var al=isLoc?seg[1]:seg[0];var WEBALIAS=(al&&["page","blog","products"].indexOf(al.toLowerCase())===-1)?al:"visitor";var RX=/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;document.addEventListener("submit",function(e){var form=e.target;if(!form||!form.classList||!form.classList.contains("sj-gform"))return;e.preventDefault();var box=form.parentNode,email=form.querySelector("input[type=email]")||form.querySelector("input"),err=box.querySelector(".sj-gerr"),ok=box.querySelector(".sj-gok");var v=(email.value||"").trim();err.style.display="none";if(!RX.test(v)){err.textContent="Ese correo no parece correcto. Revísalo otra vez.";err.style.display="block";email.focus();return;}var PDF=form.getAttribute("data-pdf");try{if(PDF)window.open(PDF,"_blank","noopener");}catch(x){}form.hidden=true;ok.hidden=false;try{if(window.dataLayer)window.dataLayer.push({event:"generate_lead",form_name:FORM_NAME,where:box.closest(".sj-gclose")?"close":"strip"});if(window.fbq)fbq("track","Lead");}catch(x){}try{fetch(ENDPOINT,{method:"POST",keepalive:true,headers:{"Content-Type":"application/json"},body:JSON.stringify({email:v,culture:CULTURE,webalias:WEBALIAS,formName:FORM_NAME})}).catch(function(){});}catch(x){}});})();

/* === Feature Block CC 4 (builder-3b7ac3029830454fb32ea1a1d65d8e44) === */
(function(){
  if (window.__sjRev) return; window.__sjRev = 1;
  if (!("IntersectionObserver" in window)) return;
  /* Mobile only (as on the live page). Anything already on screen at load is skipped,
     and the hiding CSS only applies once this script has run, so it fails safe. */
  var mq = window.matchMedia("(max-width: 991px)"), started = false;
  function boot(){ if (started || !mq.matches) return; started = true; init(); }
  if (mq.addEventListener) mq.addEventListener("change", boot); else if (mq.addListener) mq.addListener(boot);
  setTimeout(boot, 600);
  function init(){
    var vh = window.innerHeight || 800, list = [];
    document.querySelectorAll(".sj-rv").forEach(function(c){ Array.prototype.forEach.call(c.children, function(k){ list.push(k); }); });
    document.querySelectorAll(".sj-rv1").forEach(function(k){ list.push(k); });
    var els = list.filter(function(el){ return el.offsetHeight > 0 && el.getBoundingClientRect().top > vh * 0.95; });
    if (!els.length) return;
    document.documentElement.classList.add("sj-rev-on");
    els.forEach(function(el){ el.setAttribute("data-sjrev", ""); });
    var q = [], busy = false;
    function pump(){ if (busy) return; var e = q.shift(); if (!e) return; busy = true; e.classList.add("sj-in"); setTimeout(function(){ busy = false; pump(); }, 105); }
    function show(el){ if (!el || el.__sjr) return; el.__sjr = 1; q.push(el); pump(); }
    var io = new IntersectionObserver(function(es){ es.forEach(function(e){ if (e.isIntersecting){ show(e.target); io.unobserve(e.target); } }); }, { threshold: .05, rootMargin: "0px 0px -8% 0px" });
    els.forEach(function(el){ io.observe(el); });
    function sweep(){ els.forEach(function(el){ if (el.__sjr) return; var b = el.getBoundingClientRect(); if (b.top < (window.innerHeight || vh) * 0.95 && b.bottom > 0) show(el); }); }
    window.addEventListener("scroll", sweep, { passive: true });
    setTimeout(sweep, 1400);
  }
})();

/* === Feature Block CC 6 (builder-36d0f71d22c84bf9879a1b1ff9499caf) === */
(function(){
  var fig = document.getElementById("sjbChart");
  if (!fig || fig.getAttribute("data-ready")) return;
  fig.setAttribute("data-ready", "1");
  if (!("IntersectionObserver" in window)) return;
  if (window.matchMedia && window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;
  /* The chart draws itself the first time it scrolls into view: the 35 to 55 band fades in,
     then the three lines draw left to right, then the end dots appear. If this script never
     runs, the finished chart simply shows. */
  var lines = fig.querySelectorAll(".ln"), dots = fig.querySelectorAll(".dot");
  var ok = true;
  Array.prototype.forEach.call(lines, function(l){
    try { var n = l.getTotalLength(); l.style.strokeDasharray = n; l.style.strokeDashoffset = n; } catch (e) { ok = false; }
  });
  if (!ok) { Array.prototype.forEach.call(lines, function(l){ l.style.strokeDashoffset = 0; }); return; }
  document.documentElement.classList.add("sjb-anim");
  function draw(){
    fig.classList.add("on");
    Array.prototype.forEach.call(lines, function(l, i){
      setTimeout(function(){
        l.style.transition = "stroke-dashoffset 1.5s cubic-bezier(.25,.6,.3,1)";
        l.style.strokeDashoffset = 0;
        setTimeout(function(){ if (dots[i]) dots[i].classList.add("on"); }, 1350);
      }, i * 260);
    });
  }
  var io = new IntersectionObserver(function(es){
    es.forEach(function(e){ if (e.isIntersecting){ draw(); io.disconnect(); } });
  }, { threshold: .08 });
  io.observe(fig);
})();

/* === Feature Block CC 7 (builder-f97bc05d07294e8d9ad3331444b02684) === */
/* TESTIMONIAL VIDEOS - the only place to edit.
   One entry per video, in running order. vimeo = the video number and h = the privacy hash
   (both from the share link vimeo.com/<vimeo>/<h>). poster = Builder image asset id for the
   still. name and line are the caption; every line is an income claim, so it carries **. */
var VSL = [
  {"src": "https://vioniko.s3.us-west-2.amazonaws.com/sheplus/V1_video-katie-w_b44dff6a-Spanish_(Mexico)_with_captions.mp4", "name": "Katie W", "line": "Trabaja desde casa mientras educa a sus hijos.", "poster": "d8b90bceb6464755b0b477f0f91b4580"},
  {"src": "https://vioniko.s3.us-west-2.amazonaws.com/sheplus/V2_video-andre-p_16bf3296-Spanish_(Mexico)_with_captions.mp4", "name": "Andre P", "line": "Emprendedor en serie que viaja por el mundo.", "poster": "3a52181f6ca245c69f9a56d19be682c6"},
  {"src": "https://vioniko.s3.us-west-2.amazonaws.com/sheplus/V3_video-brooke-t_d708ed6b-Spanish_(Mexico)_with_captions.mp4", "name": "Brooke T", "line": "Ganó seis cifras en su primer año, mientras trabajaba tiempo completo.", "poster": "4f2e697f49cd4180a01f29d263226507"},
  {"src": "https://vioniko.s3.us-west-2.amazonaws.com/sheplus/V4_video-chris-r_6c572608-Spanish_(Mexico)_with_captions.mp4", "name": "Chris R", "line": "Agricultor que usa el negocio para invertir en el campo.", "poster": "e3f918189fea40b48e61cac195399cbc"},
  {"src": "https://vioniko.s3.us-west-2.amazonaws.com/sheplus/V5_video-denise-w_ee2e8a5b-Spanish_(Mexico)_with_captions.mp4", "name": "Denise W", "line": "Psicóloga gana más de 5 cifras en su primer mes.", "poster": "7b9aecfcc1ee41218be95c269f5fe8c9"},
  {"src": "https://vioniko.s3.us-west-2.amazonaws.com/sheplus/V6_video-briana-m_91e0e6b8-Spanish_(Mexico)_with_captions.mp4", "name": "Briana M", "line": "Pudo cubrir su hipoteca en los primeros 30 días.", "poster": "e16a970adf0e4440ba3ee2d51b0be9d1"},
  {"src": "https://vioniko.s3.us-west-2.amazonaws.com/sheplus/V7_video-zamara-s_86f83c1c-Spanish_(Mexico)_with_captions.mp4", "name": "Zamara S", "line": "Construye en su tiempo libre para darse los gustos.", "poster": "88531704c2a54eadbd7946f3db315b16"},
  {"src": "https://vioniko.s3.us-west-2.amazonaws.com/sheplus/V8_video-judy-s_15475d5e-Spanish_(Mexico)_with_captions.mp4", "name": "Judy S", "line": "Dejó su empleo y logró libertad financiera.", "poster": "6807dd0f90e64b5db594d9b7baec715c"}
];
(function(){
  var VIMEO = "https://player.vimeo.com/video/";
  var VIMEO_THUMB = {
    "1240003820": "https://i.vimeocdn.com/video/2217704383-32f73ce95aa00c183717bf3dc8d2daa9cf83bfc14d1c7e0e07388fa5bbc875c7-d_960?region=us",
    "1240003796": "https://i.vimeocdn.com/video/2217704392-9628e51f1dd585eb987947e6a417464d7737948711f57f0b6079fa00952a4221-d_960?region=us",
    "1240003832": "https://i.vimeocdn.com/video/2217704403-4d9f19bb63f13678dcad181a5d7c3ab4f9b7c84fd808e6ba8e9926b8f14bf309-d_960?region=us",
    "1240003813": "https://i.vimeocdn.com/video/2217704386-a9d2b74ebc6f249175952e898dfac222eb0edace39ded4cbcb5ad837bae66ae5-d_960?region=us",
    "1240003789": "https://i.vimeocdn.com/video/2217704370-4d77772ae88edc4dd2c6deefadf0712bbbfe8aa240b35d1902969e419c854e91-d_960?region=us",
    "1240003831": "https://i.vimeocdn.com/video/2217704401-8a0912fa60641b87d01c91e01d148a62029291912c3bac65c4f78f4df61d705d-d_960?region=us",
    "1240003798": "https://i.vimeocdn.com/video/2217704367-0081dd04c7926965b0a5f4166b40eb04970c10143b57455c393d05b36570ac5a-d_960?region=us",
    "1240003791": "https://i.vimeocdn.com/video/2217704363-ac4e9b907fcd1a958c1eb969d08301ce9d4b267f275bc1c25643b3803140438c-d_960?region=us"
  };
  var POSTER_MAP = {
    "d8b90bceb6464755b0b477f0f91b4580": "./assets/images/vsl-katie-w.jpg",
    "3a52181f6ca245c69f9a56d19be682c6": "./assets/images/vsl-andre-p.jpg",
    "4f2e697f49cd4180a01f29d263226507": "./assets/images/vsl-brooke-t.jpg",
    "e3f918189fea40b48e61cac195399cbc": "./assets/images/vsl-chris-r.jpg",
    "7b9aecfcc1ee41218be95c269f5fe8c9": "./assets/images/vsl-denise-w.jpg",
    "e16a970adf0e4440ba3ee2d51b0be9d1": "./assets/images/vsl-briana-m.jpg",
    "88531704c2a54eadbd7946f3db315b16": "./assets/images/vsl-zamara-s.jpg",
    "6807dd0f90e64b5db594d9b7baec715c": "./assets/images/vsl-judy-s.jpg"
  };
  function esc(t){ var A = String.fromCharCode(38); return String(t).replace(/[&<>"]/g, function(c){ return A + ({"&":"amp","<":"lt",">":"gt","\"":"quot"})[c] + ";"; }); }
  function card(v){
    var src = v.src || (v.vimeo ? (VIMEO + v.vimeo + "?h=" + v.h + "&autoplay=1&title=0&byline=0&portrait=0&dnt=1") : "");
    var cap = v.name ? "<figcaption><b>" + esc(v.name) + "</b>" + (v.line ? "<span>" + esc(v.line) + "<sup>**</sup></span>" : "") + "</figcaption>" : "";
    var posterUrl = v.poster ? (POSTER_MAP[v.poster] || ("./assets/images/" + v.poster + ".webp")) : "";
    var img = posterUrl ? '<img src="' + esc(posterUrl) + '" alt="' + esc(v.name || "") + '" decoding="async" loading="lazy">' : '';
    return '<figure class="vsl-card"><div class="vsl-thumb" data-src="' + esc(src) + '">' + img + '<button class="vsl-play" type="button" aria-label="Reproducir ' + esc(v.name || "video") + '"></button></div>' + cap + '</figure>';
  }
  /* A poster and a button, not a player: the Vimeo iframe is created on click, one at a time. */
  function openVideo(thumb){
    var src = thumb.getAttribute("data-src");
    if (!src || thumb.querySelector("iframe") || thumb.querySelector("video")) return;
    Array.prototype.forEach.call(document.querySelectorAll(".sjv .vsl-thumb[data-open]"), function(o){
      if (o !== thumb) { o.innerHTML = o.getAttribute("data-open"); o.removeAttribute("data-open"); }
    });
    thumb.setAttribute("data-open", thumb.innerHTML);
    if (/\.mp4($|\?)/i.test(src)) {
      var v = document.createElement("video");
      v.src = src;
      v.controls = true;
      v.autoplay = true;
      v.playsInline = true;
      v.setAttribute("playsinline", "");
      v.setAttribute("controlslist", "nodownload");
      v.style.position = "absolute";
      v.style.inset = "0";
      v.style.width = "100%";
      v.style.height = "100%";
      v.style.objectFit = "cover";
      v.style.border = "0";
      v.style.display = "block";
      v.style.background = "#000";
      thumb.innerHTML = "";
      thumb.appendChild(v);
      if (v.play) { v.play().catch(function(){}); }
      return;
    }
    var f = document.createElement("iframe");
    f.src = src; f.allow = "autoplay; fullscreen; picture-in-picture"; f.setAttribute("allowfullscreen", ""); f.setAttribute("frameborder", "0"); f.title = "Video";
    thumb.innerHTML = ""; thumb.appendChild(f);
  }
  Array.prototype.forEach.call(document.querySelectorAll(".sjv"), function(slider){
    if (slider.getAttribute("data-ready")) return; slider.setAttribute("data-ready", "1");
    var track = slider.querySelector(".vsl-track"); if (!track) return;
    if (!track.children.length) {
      track.innerHTML = VSL.filter(function(v){ return v && (v.vimeo || v.src); }).map(card).join("");
    }
    track.addEventListener("click", function(e){
      var t = e.target.closest ? e.target.closest(".vsl-play") : null;
      if (t) openVideo(t.parentNode);
    });
    function step(dir){ var c = track.querySelector(".vsl-card"); var w = c ? c.offsetWidth + 16 : 252; track.scrollBy({ left: dir * w * 2, behavior: "smooth" }); }
    var prev = slider.querySelector(".vsl-btn.prev"), next = slider.querySelector(".vsl-btn.next");
    if (prev) prev.addEventListener("click", function(){ step(-1); });
    if (next) next.addEventListener("click", function(){ step(1); });
  });
})();

/* === Feature Block CC 11 (builder-29df6fe5b3c546d8951b97a619a9d5c4) === */
/* PACKAGE BUTTONS. The buttons are native Builder buttons whose link is a token:
     #pack-<SKU>    consultant kit  -> /{culture}/{webalias}/page/pack/{SKU}?source=imm   (same as live)
     #buy-sheplus   one box         -> /{culture}/{webalias}/products/sheplus             (same as live)
     #cart-<SKU>    customer pack   -> written into the site cart on subscription, then /{culture}/checkout
   To add a kit button anywhere on the page, give a button the link #pack-<SKU>. Same origin on any
   Immunotec host (QA and production), production domain anywhere else. */
(function(){
  if (window.__sjPk) return; window.__sjPk = 1;
  var host = location.hostname;
  var IMM = /(^|\.)immunotec\.com$/i.test(host) || /(^|\.)immunotecdev\.com$/i.test(host);
  var SITE = IMM ? "" : "https://www.immunotec.com";
  var seg = location.pathname.split("/").filter(Boolean);
  var isLoc = seg[0] && /^[a-z]{2}(-[a-zA-Z]{2})?$/.test(seg[0]);
  var CULTURE = isLoc ? seg[0] : "es-US";
  var al = isLoc ? seg[1] : seg[0];
  var WEBALIAS = (al && ["page","blog","products"].indexOf(al.toLowerCase()) === -1) ? al : "";
  /* the cart step keeps the live page's own culture rule */
  var CCULT = (seg[0] && seg[0].length === 5 && seg[0].charAt(2) === "-") ? seg[0] : "es-US";
  var FALLBACK = SITE + "/" + CCULT + "/products/sheplus";
  var PACK = { SKU:"0009713", NAME:"CUSTOMER HEALTH PACK SHE+SUNRAY", PRICE:146, PRICE_SUB:99, TYPE:"AutoOrder",
    IMAGE:"https://cdn.builder.io/api/v1/image/assets%2Ffdb4d79bfbfd478d89398007f8c29424%2F8f5356db8407494db598720848ff1427?format=webp&width=620&quality=86" };

  function siteHref(slug){ var p = [SITE, CULTURE]; if (WEBALIAS) p.push(encodeURIComponent(WEBALIAS)); p.push(slug); return p.join("/"); }
  function packHref(sku){ var p = [SITE, CULTURE]; if (WEBALIAS) p.push(encodeURIComponent(WEBALIAS)); p.push("page/pack", encodeURIComponent(sku)); return p.join("/") + "?source=imm"; }
  function act(a){
    var k = a.getAttribute("data-sj-act"); if (k) return k;
    var m = (a.getAttribute("href") || "").match(/^#(pack|buy|cart)-([A-Za-z0-9_-]+)$/);
    return m ? m[1] + ":" + m[2] : "";
  }
  function dest(k){
    var t = k.split(":");
    if (t[0] === "pack") return packHref(t[1]);
    if (t[0] === "buy") return siteHref("products/sheplus");
    return FALLBACK;
  }
  function addPack(){
    try{
      var raw = sessionStorage.getItem("app-storage");
      var app = raw ? JSON.parse(raw) : { state:{} };
      app.state = app.state || {}; app.state.checkout = app.state.checkout || {};
      var body = app.state.checkout.checkoutBody = app.state.checkout.checkoutBody || { cartItems:[] };
      body.cartItems = (body.cartItems || []).filter(function(i){ return i && i.sku !== PACK.SKU; });
      body.cartItems.push({ allow:"1", quantity:1, sku:PACK.SKU, type:PACK.TYPE, description:"", price:PACK.PRICE,
        pricePreferred25:PACK.PRICE_SUB, discountPrice:PACK.PRICE_SUB, imageUrl:PACK.IMAGE, name:PACK.NAME,
        reference1:null, commissionableVolume:0, businessVolume:0, endDate:null,
        orderDetailId:(window.crypto && crypto.randomUUID) ? crypto.randomUUID() : String(Date.now()) + Math.random().toString(16).slice(2) });
      body.discountType = "Subscription";
      body.countryCode = "US"; body.cultureCode = CCULT;
      sessionStorage.setItem("app-storage", JSON.stringify(app));
      var items = JSON.parse(sessionStorage.getItem("app-storage")).state.checkout.checkoutBody.cartItems;
      for (var k = 0; k < items.length; k++) if (items[k].sku === PACK.SKU && items[k].type === PACK.TYPE) return true;
    }catch(e){}
    return false;
  }
  var SEL = 'a[data-sj-act],a[href^="#pack-"],a[href^="#buy-"],a[href^="#cart-"]';
  function wire(){
    Array.prototype.forEach.call(document.querySelectorAll(SEL), function(a){
      var k = act(a); if (!k) return;
      a.setAttribute("data-sj-act", k);
      a.setAttribute("href", dest(k));
    });
  }
  wire(); setTimeout(wire, 700); setTimeout(wire, 2500);
  document.addEventListener("click", function(e){
    var a = e.target && e.target.closest ? e.target.closest(SEL) : null; if (!a) return;
    var k = act(a); if (!k) return;
    if (k.indexOf("cart:") === 0){
      if (!IMM){ if ((a.getAttribute("href") || "").charAt(0) === "#"){ e.preventDefault(); location.href = FALLBACK; } return; }
      e.preventDefault();
      var ok = addPack();
      if (window.dataLayer) window.dataLayer.push({ event: ok ? "add_to_cart" : "add_to_cart_fallback", item_id:PACK.SKU, item_category:"Subscription" });
      location.href = ok ? SITE + "/" + CCULT + "/checkout" : FALLBACK;
      return;
    }
    if ((a.getAttribute("href") || "").charAt(0) === "#"){ e.preventDefault(); location.href = dest(k); }
  }, true);
  /* a link that arrives with #packages lands on the packages */
  if (location.hash === "#packages") setTimeout(function(){ var t = document.querySelector(".sj-packages"); if (t) t.scrollIntoView({ block:"start" }); }, 900);
})();


/* ==========================================================================
   Anti-Download Protection for Top Intro Video
   ========================================================================== */
(function() {
  function initVideoProtection() {
    var video = document.getElementById("top-main-video");
    var wrapper = document.querySelector(".top-video-wrapper");
    if (!video) return;

    function blockEvent(e) {
      if (e.preventDefault) e.preventDefault();
      if (e.stopPropagation) e.stopPropagation();
      e.returnValue = false;
      return false;
    }

    // Disable context menu on video & wrapper
    video.addEventListener("contextmenu", blockEvent);
    if (wrapper) {
      wrapper.addEventListener("contextmenu", blockEvent);
      wrapper.addEventListener("dragstart", blockEvent);
    }
    video.addEventListener("dragstart", blockEvent);

    // Disable save keyboard shortcuts (Ctrl+S, Cmd+S, Ctrl+U)
    video.addEventListener("keydown", function(e) {
      if ((e.ctrlKey || e.metaKey) && (e.key === "s" || e.key === "S" || e.key === "u" || e.key === "U")) {
        blockEvent(e);
      }
    });

    // Programmatically enforce nodownload and disable PiP
    try {
      if (video.controlsList) {
        video.controlsList.add("nodownload");
        video.controlsList.add("noplaybackrate");
      }
      video.disablePictureInPicture = true;
      video.disableRemotePlayback = true;
    } catch(err) {}
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initVideoProtection);
  } else {
    initVideoProtection();
  }
})();
