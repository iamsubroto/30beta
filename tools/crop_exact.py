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
    "--remote-debugging-port=9226",
    "--user-data-dir=C:\\tmp\\chrome_crop_9226",
    "--disable-gpu",
    "--allow-file-access-from-files",
    "about:blank"
], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
time.sleep(2)

try:
    async def get_box(width):
        req = urllib.request.urlopen("http://127.0.0.1:9226/json")
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
            js = """
            (function(){
                var el = document.querySelector('.sj-proof');
                var r = el.getBoundingClientRect();
                return JSON.stringify({
                    top: Math.round(window.scrollY + r.top),
                    bottom: Math.round(window.scrollY + r.bottom),
                    height: Math.round(r.height),
                    left: Math.round(r.left),
                    width: Math.round(r.width)
                });
            })()
            """
            res = await call("Runtime.evaluate", {"expression": js, "returnByValue": True})
            return json.loads(res.get("result", {}).get("value", "{}"))
    
    # 1440
    box_1440 = asyncio.run(get_box(1440))
    print("Proof box 1440:", box_1440)
    im = Image.open("verification_screenshots/tall_1440.png")
    y_start = max(0, int(box_1440["top"]) - 40)
    y_end = min(im.height, int(box_1440["bottom"]) + 40)
    crop = im.crop((0, y_start, 1440, y_end))
    crop.save("verification_screenshots/proof_desktop_exact.png")
    print("Saved proof_desktop_exact.png")

    # 390
    box_390 = asyncio.run(get_box(390))
    print("Proof box 390:", box_390)
    im_m = Image.open("verification_screenshots/tall_390.png")
    y_start_m = max(0, int(box_390["top"]) - 40)
    y_end_m = min(im_m.height, int(box_390["bottom"]) + 40)
    crop_m = im_m.crop((0, y_start_m, 390, y_end_m))
    crop_m.save("verification_screenshots/proof_mobile_exact.png")
    print("Saved proof_mobile_exact.png")

finally:
    proc.terminate()
