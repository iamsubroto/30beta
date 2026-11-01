import asyncio
import json
import urllib.request
import websockets
import subprocess
import time
from PIL import Image

CHROME = r"C:\Program Files\Google\Chrome\Application\chrome.exe"
proc = subprocess.Popen([
    CHROME,
    "--headless=new",
    "--remote-debugging-port=9228",
    "--user-data-dir=C:\\tmp\\chrome_rv1_crop_9228",
    "--disable-gpu",
    "--allow-file-access-from-files",
    "about:blank"
], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
time.sleep(2)

try:
    async def capture_card(width, out_name):
        req = urllib.request.urlopen("http://127.0.0.1:9228/json")
        targets = json.loads(req.read().decode())
        target = [t for t in targets if t.get("type") == "page"][0]
        async with websockets.connect(target["webSocketDebuggerUrl"]) as ws:
            mid = 1
            async def call(m, p={}):
                nonlocal mid; cur = mid; mid += 1
                await ws.send(json.dumps({"id": cur, "method": m, "params": p}))
                while True:
                    resp = json.loads(await ws.recv())
                    if resp.get("id") == cur: return resp.get("result", {})
            await call("Page.enable")
            await call("Emulation.setDeviceMetricsOverride", {"width": width, "height": 1000, "deviceScaleFactor": 1, "mobile": width < 768})
            await call("Page.navigate", {"url": "file:///C:/bakcup/30beta/index.html"})
            await asyncio.sleep(1.5)
            
            # get rect of the card
            js = """
            (function(){
                var el = document.querySelector('[builder-id="builder-f17307f9ac1f491cbf82626333b7666a"]');
                var r = el.getBoundingClientRect();
                return JSON.stringify({
                    x: Math.round(r.left),
                    y: Math.round(r.top),
                    width: Math.round(r.width),
                    height: Math.round(r.height)
                });
            })()
            """
            res = await call("Runtime.evaluate", {"expression": js, "returnByValue": True})
            rect = json.loads(res.get("result", {}).get("value", "{}"))
            
            # Scroll element into view so it's captured cleanly
            scroll_js = """
            (function(){
                var el = document.querySelector('[builder-id="builder-f17307f9ac1f491cbf82626333b7666a"]');
                el.scrollIntoView({ block: 'center' });
            })()
            """
            await call("Runtime.evaluate", {"expression": scroll_js})
            await asyncio.sleep(0.5)
            
            # take screenshot of the element viewport area
            js2 = """
            (function(){
                var el = document.querySelector('[builder-id="builder-f17307f9ac1f491cbf82626333b7666a"]');
                var r = el.getBoundingClientRect();
                return JSON.stringify({
                    x: Math.max(0, Math.round(r.left) - 20),
                    y: Math.max(0, Math.round(r.top) - 20),
                    width: Math.round(r.width) + 40,
                    height: Math.round(r.height) + 40,
                    scale: 1
                });
            })()
            """
            res2 = await call("Runtime.evaluate", {"expression": js2, "returnByValue": True})
            clip = json.loads(res2.get("result", {}).get("value", "{}"))
            
            shot = await call("Page.captureScreenshot", {
                "format": "png",
                "clip": clip
            })
            import base64
            img_data = base64.b64decode(shot.get("data", ""))
            with open(f"verification_screenshots/{out_name}", "wb") as f:
                f.write(img_data)
            print(f"Saved verification_screenshots/{out_name}")

    asyncio.run(capture_card(1440, "botanicos_desktop_1440.png"))
    asyncio.run(capture_card(390, "botanicos_mobile_390.png"))

finally:
    proc.terminate()
