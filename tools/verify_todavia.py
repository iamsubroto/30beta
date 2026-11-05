import re
import subprocess
import time
import json
import urllib.request
import websockets
import asyncio
import os
import base64

# 1. Create preview HTML from 30beta/index_beta.php
with open("30beta/index_beta.php", "r", encoding="utf-8") as f:
    content = f.read()

# Replace PHP tags with mock values for visual verification
content = re.sub(r'<\?php.*?\?>', '', content, flags=re.DOTALL)
content = re.sub(r'<\?=.*?\?>', '', content)
# Fix asset paths for tools/ directory
content = content.replace('href="style.css?v=1.0.5"', 'href="../30beta/style.css"')
content = content.replace('src="script.js?v=1.0.5"', 'src="../30beta/script.js"')
content = content.replace('src="./assets/', 'src="../30beta/assets/')
content = content.replace('srcset="./assets/', 'srcset="../30beta/assets/')

with open("tools/preview_index.html", "w", encoding="utf-8") as f:
    f.write(content)

print("Created tools/preview_index.html")

CHROME = r"C:\Program Files\Google\Chrome\Application\chrome.exe"
PORT = 8092

server_proc = subprocess.Popen(["python", "-m", "http.server", str(PORT)], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
time.sleep(1.5)

chrome_proc = subprocess.Popen([
    CHROME,
    "--headless=new",
    "--remote-debugging-port=9238",
    "--user-data-dir=C:\\tmp\\chrome_verify_todavia",
    "--disable-gpu",
    "--allow-file-access-from-files",
    "about:blank"
], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
time.sleep(2)

try:
    async def capture():
        req = urllib.request.urlopen("http://127.0.0.1:9238/json")
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
            
            for width, height, name in [(1440, 900, "todavia_desktop_1440.png"), (768, 1024, "todavia_tablet_768.png"), (390, 844, "todavia_mobile_390.png")]:
                await call("Emulation.setDeviceMetricsOverride", {
                    "width": width,
                    "height": height,
                    "deviceScaleFactor": 1,
                    "mobile": width < 600
                })
                await call("Page.navigate", {"url": f"http://127.0.0.1:{PORT}/tools/preview_index.html"})
                await asyncio.sleep(2)
                
                # Get bounding box of .todavia-section
                rect_res = await call("Runtime.evaluate", {
                    "expression": """
                    (function(){
                        var el = document.querySelector('.todavia-section');
                        if (!el) return null;
                        var r = el.getBoundingClientRect();
                        return JSON.stringify({
                            x: Math.max(0, Math.round(r.left)),
                            y: Math.max(0, Math.round(r.top) + window.scrollY),
                            width: Math.round(r.width),
                            height: Math.round(r.height),
                            scale: 1
                        });
                    })()
                    """
                })
                
                rect_str = rect_res.get("result", {}).get("value")
                if not rect_str:
                    print(f"Could not find .todavia-section for {name}")
                    continue
                
                clip = json.loads(rect_str)
                # Scroll element into view
                await call("Runtime.evaluate", {
                    "expression": f"window.scrollTo(0, {clip['y'] - 50});"
                })
                await asyncio.sleep(0.5)
                
                # Re-measure in viewport
                rect_res2 = await call("Runtime.evaluate", {
                    "expression": """
                    (function(){
                        var el = document.querySelector('.todavia-section');
                        var r = el.getBoundingClientRect();
                        return JSON.stringify({
                            x: Math.max(0, Math.round(r.left)),
                            y: Math.max(0, Math.round(r.top)),
                            width: Math.round(r.width),
                            height: Math.round(r.height),
                            scale: 1
                        });
                    })()
                    """
                })
                clip2 = json.loads(rect_res2.get("result", {}).get("value"))
                
                shot = await call("Page.captureScreenshot", {
                    "format": "png",
                    "clip": clip2
                })
                
                os.makedirs("verification_screenshots", exist_ok=True)
                with open(f"verification_screenshots/{name}", "wb") as sf:
                    sf.write(base64.b64decode(shot["data"]))
                print(f"Saved verification_screenshots/{name}")

    asyncio.run(capture())
finally:
    chrome_proc.terminate()
    server_proc.terminate()
