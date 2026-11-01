import subprocess
import time
import asyncio
import json
import base64
import urllib.request
import websockets
import os

PORT = 8086
CHROME = r"C:\Program Files\Google\Chrome\Application\chrome.exe"

async def cdp_call(ws, method, params=None, msg_id=[1]):
    mid = msg_id[0]
    msg_id[0] += 1
    await ws.send(json.dumps({"id": mid, "method": method, "params": params or {}}))
    while True:
        resp = json.loads(await ws.recv())
        if resp.get("id") == mid:
            return resp.get("result", {})

async def capture_full(width, out_name):
    req = urllib.request.urlopen("http://127.0.0.1:9222/json")
    targets = json.loads(req.read().decode())
    target = targets[0]
    ws_url = target["webSocketDebuggerUrl"]
    
    async with websockets.connect(ws_url, max_size=50*1024*1024) as ws:
        msg_id = [1]
        await cdp_call(ws, "Page.enable", {}, msg_id)
        await cdp_call(ws, "Emulation.setDeviceMetricsOverride", {
            "width": width,
            "height": 900,
            "deviceScaleFactor": 1,
            "mobile": width < 768
        }, msg_id)
        
        await cdp_call(ws, "Page.navigate", {"url": f"http://127.0.0.1:{PORT}/index.html"}, msg_id)
        await asyncio.sleep(2)
        
        # Get layout metrics
        metrics = await cdp_call(ws, "Page.getLayoutMetrics", {}, msg_id)
        content_size = metrics.get("contentSize", {})
        h = int(content_size.get("height", 10000))
        print(f"Viewport {width} content height: {h}px")
        
        # Override height to capture full page
        await cdp_call(ws, "Emulation.setDeviceMetricsOverride", {
            "width": width,
            "height": h,
            "deviceScaleFactor": 1,
            "mobile": width < 768
        }, msg_id)
        await asyncio.sleep(0.5)
        
        shot = await cdp_call(ws, "Page.captureScreenshot", {"format": "jpeg", "quality": 85}, msg_id)
        data = base64.b64decode(shot["data"])
        with open(out_name, "wb") as f:
            f.write(data)
        print(f"Saved full page screenshot: {out_name} ({len(data)} bytes)")

def main():
    server_proc = subprocess.Popen(["python", "-m", "http.server", str(PORT)], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
    chrome_proc = subprocess.Popen([
        CHROME,
        "--headless=new",
        "--remote-debugging-port=9222",
        "--user-data-dir=C:\\tmp\\chrome_shot_profile",
        "--disable-gpu",
        "--hide-scrollbars",
        "about:blank"
    ], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
    time.sleep(2)
    
    try:
        os.makedirs("verification_screenshots", exist_ok=True)
        asyncio.run(capture_full(1440, "verification_screenshots/full_1440.jpg"))
        asyncio.run(capture_full(390, "verification_screenshots/full_390.jpg"))
    finally:
        chrome_proc.terminate()
        server_proc.terminate()
        print("Done capturing full page screenshots.")

if __name__ == "__main__":
    main()
