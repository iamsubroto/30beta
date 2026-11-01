import asyncio
import json
import urllib.request
import websockets
import subprocess
import time
import base64

CHROME = r"C:\Program Files\Google\Chrome\Application\chrome.exe"
proc = subprocess.Popen([
    CHROME,
    "--headless=new",
    "--remote-debugging-port=9244",
    "--user-data-dir=C:\\tmp\\chrome_vertical_shot_9244",
    "--disable-gpu",
    "--allow-file-access-from-files",
    "about:blank"
], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
time.sleep(2)

try:
    async def capture():
        req = urllib.request.urlopen("http://127.0.0.1:9244/json")
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
            # We want to capture the hero section including the 3 vertical proof cards and the button below
            await call("Emulation.setDeviceMetricsOverride", {"width": 390, "height": 1400, "deviceScaleFactor": 1, "mobile": True})
            await call("Page.navigate", {"url": "file:///C:/bakcup/30beta/index.html"})
            await asyncio.sleep(2)
            
            # Capture from top of the image (around y=300) down to the button
            shot = await call("Page.captureScreenshot", {
                "format": "png",
                "clip": {"x": 0, "y": 300, "width": 390, "height": 950, "scale": 1}
            })
            data = base64.b64decode(shot.get("data", ""))
            with open("verification_screenshots/hero_mobile_vertical_proof.png", "wb") as f:
                f.write(data)
            print("Saved verification_screenshots/hero_mobile_vertical_proof.png")

    asyncio.run(capture())
finally:
    proc.terminate()
