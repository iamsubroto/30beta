import asyncio
import json
import base64
import urllib.request
import websockets

async def cdp_command(ws, method, params=None, msg_id=[1]):
    mid = msg_id[0]
    msg_id[0] += 1
    msg = {"id": mid, "method": method, "params": params or {}}
    await ws.send(json.dumps(msg))
    while True:
        resp = json.loads(await ws.recv())
        if resp.get("id") == mid:
            return resp.get("result", {})

async def main():
    # Get browser targets
    req = urllib.request.urlopen("http://127.0.0.1:9222/json")
    targets = json.loads(req.read().decode())
    target = targets[0]
    ws_url = target["webSocketDebuggerUrl"]
    print("Connecting to:", ws_url)
    
    async with websockets.connect(ws_url, max_size=50*1024*1024) as ws:
        msg_id = [1]
        
        # Enable Page and Runtime
        await cdp_command(ws, "Page.enable", {}, msg_id)
        await cdp_command(ws, "Runtime.enable", {}, msg_id)
        
        print("Navigating to https://www.immunotec.com/es-US/momentum/page/she-join ...")
        await cdp_command(ws, "Page.navigate", {"url": "https://www.immunotec.com/es-US/momentum/page/she-join"}, msg_id)
        
        # Wait for page to load
        for i in range(12):
            await asyncio.sleep(1)
            title = await cdp_command(ws, "Runtime.evaluate", {"expression": "document.title"}, msg_id)
            val = title.get("result", {}).get("value", "")
            print(f"[{i+1}s] Title: {val}")
            if "Just a moment" not in val and val != "":
                break
        
        # Check if we have builder blocks rendered
        res = await cdp_command(ws, "Runtime.evaluate", {
            "expression": "document.querySelectorAll('[class*=\"builder\"]').length"
        }, msg_id)
        print("Builder elements count:", res.get("result", {}).get("value"))
        
        # Get full rendered outerHTML
        html_res = await cdp_command(ws, "Runtime.evaluate", {
            "expression": "document.documentElement.outerHTML"
        }, msg_id)
        rendered_html = html_res.get("result", {}).get("value", "")
        with open("rendered_live.html", "w", encoding="utf-8") as f:
            f.write(rendered_html)
        print("Saved rendered_live.html (bytes:", len(rendered_html), ")")

if __name__ == "__main__":
    asyncio.run(main())
