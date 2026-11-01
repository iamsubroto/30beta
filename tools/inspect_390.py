import asyncio
import json
import urllib.request
import websockets
import subprocess
import time

CHROME = r"C:\Program Files\Google\Chrome\Application\chrome.exe"
proc = subprocess.Popen([
    CHROME,
    "--headless=new",
    "--remote-debugging-port=9240",
    "--user-data-dir=C:\\tmp\\chrome_layout_9240",
    "--disable-gpu",
    "--allow-file-access-from-files",
    "about:blank"
], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
time.sleep(2)

try:
    async def run():
        req = urllib.request.urlopen("http://127.0.0.1:9240/json")
        target = [t for t in json.loads(req.read().decode()) if t.get("type") == "page"][0]
        async with websockets.connect(target["webSocketDebuggerUrl"]) as ws:
            mid = 1
            async def call(m, p={}):
                nonlocal mid; cur = mid; mid += 1
                await ws.send(json.dumps({"id": cur, "method": m, "params": p}))
                while True:
                    resp = json.loads(await ws.recv())
                    if resp.get("id") == cur: return resp.get("result", {})
            await call("Page.enable")
            await call("Emulation.setDeviceMetricsOverride", {"width": 390, "height": 844, "deviceScaleFactor": 1, "mobile": True})
            await call("Page.navigate", {"url": "file:///C:/bakcup/30beta/index.html"})
            await asyncio.sleep(2)
            
            js = """
            (function(){
                var winW = window.innerWidth;
                var docW = document.documentElement.offsetWidth;
                var bodyW = document.body.offsetWidth;
                var scrollW = document.documentElement.scrollWidth;
                
                var hero = document.querySelector('[builder-id="builder-deb41953516c42e8bd48970f018fe1c6"]');
                var hero_r = hero ? hero.getBoundingClientRect() : null;
                
                var h1 = document.querySelector('h1');
                var h1_r = h1 ? h1.getBoundingClientRect() : null;
                
                var imgContainer = document.querySelector('[builder-id="builder-e973791a6ecb430eb0901d32280e3c5e"]');
                var img_r = imgContainer ? imgContainer.getBoundingClientRect() : null;
                
                var whiteCard = document.querySelector('[builder-id="builder-308135d28d9947a2a5bf0e015e425765"]');
                var wc_r = whiteCard ? whiteCard.getBoundingClientRect() : null;
                
                var proof = document.querySelector('.sj-proof');
                var pr_r = proof ? proof.getBoundingClientRect() : null;
                
                var btn = document.querySelector('[builder-id="builder-93051ccd2cfb49838fa0fcab29f0f781"]');
                var btn_r = btn ? btn.getBoundingClientRect() : null;
                
                return {
                    winW: winW,
                    docW: docW,
                    bodyW: bodyW,
                    scrollW: scrollW,
                    hero: hero_r ? {left: Math.round(hero_r.left), right: Math.round(hero_r.right), width: Math.round(hero_r.width)} : null,
                    h1: h1_r ? {left: Math.round(h1_r.left), right: Math.round(h1_r.right), width: Math.round(h1_r.width)} : null,
                    imgContainer: img_r ? {left: Math.round(img_r.left), right: Math.round(img_r.right), width: Math.round(img_r.width)} : null,
                    whiteCard: wc_r ? {left: Math.round(wc_r.left), right: Math.round(wc_r.right), width: Math.round(wc_r.width)} : null,
                    proof: pr_r ? {left: Math.round(pr_r.left), right: Math.round(pr_r.right), width: Math.round(pr_r.width)} : null,
                    btn: btn_r ? {left: Math.round(btn_r.left), right: Math.round(btn_r.right), width: Math.round(btn_r.width)} : null
                };
            })()
            """
            res = await call("Runtime.evaluate", {"expression": js, "returnByValue": True})
            print(json.dumps(res.get("result", {}).get("value", {}), indent=2))
    asyncio.run(run())
finally:
    proc.terminate()
