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
    "--remote-debugging-port=9229",
    "--user-data-dir=C:\\tmp\\chrome_rv1_crop2_9229",
    "--disable-gpu",
    "--allow-file-access-from-files",
    "about:blank"
], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
time.sleep(2)

try:
    async def get_box(width):
        req = urllib.request.urlopen("http://127.0.0.1:9229/json")
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
            await call("Emulation.setDeviceMetricsOverride", {"width": width, "height": 1000, "deviceScaleFactor": 1, "mobile": width < 768})
            await call("Page.navigate", {"url": "file:///C:/bakcup/30beta/index.html"})
            await asyncio.sleep(1.5)
            js = """
            (function(){
                var el = document.querySelector('[builder-id="builder-f17307f9ac1f491cbf82626333b7666a"]');
                var r = el.getBoundingClientRect();
                return JSON.stringify({
                    top: Math.round(window.scrollY + r.top),
                    bottom: Math.round(window.scrollY + r.bottom),
                    left: Math.round(r.left),
                    right: Math.round(r.right),
                    height: Math.round(r.height),
                    width: Math.round(r.width)
                });
            })()
            """
            res = await call("Runtime.evaluate", {"expression": js, "returnByValue": True})
            return json.loads(res.get("result", {}).get("value", "{}"))

    box_1440 = asyncio.run(get_box(1440))
    print("Box 1440:", box_1440)
    box_390 = asyncio.run(get_box(390))
    print("Box 390:", box_390)
finally:
    proc.terminate()

# Now re-generate tall screenshots with the updated style.css
print("Re-capturing tall screenshots...")
subprocess.run(["python", "tools/capture_tall.py"], check=True)

# Crop 1440
im_1440 = Image.open("verification_screenshots/tall_1440.png")
y1 = max(0, box_1440["top"] - 40)
y2 = min(im_1440.height, box_1440["bottom"] + 40)
crop_1440 = im_1440.crop((0, y1, 1440, y2))
crop_1440.save("verification_screenshots/botanicos_desktop_exact.png")
print("Saved botanicos_desktop_exact.png with y range:", y1, y2)

# Crop 390
im_390 = Image.open("verification_screenshots/tall_390.png")
y1_m = max(0, box_390["top"] - 40)
y2_m = min(im_390.height, box_390["bottom"] + 40)
crop_390 = im_390.crop((0, y1_m, 390, y2_m))
crop_390.save("verification_screenshots/botanicos_mobile_exact.png")
print("Saved botanicos_mobile_exact.png with y range:", y1_m, y2_m)
