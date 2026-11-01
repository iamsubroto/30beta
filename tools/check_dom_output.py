import subprocess
import time

CHROME = r"C:\Program Files\Google\Chrome\Application\chrome.exe"
PORT = 8088

server_proc = subprocess.Popen(["python", "-m", "http.server", str(PORT)], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
time.sleep(1.5)

cmd = [
    CHROME,
    "--headless=new",
    "--disable-gpu",
    "--dump-dom",
    f"http://127.0.0.1:{PORT}/index.html"
]

res = subprocess.run(cmd, capture_output=True, encoding="utf-8", errors="replace", timeout=15)
server_proc.terminate()

dom = res.stdout
print("Total length of rendered DOM:", len(dom))
print("vsl-card count:", dom.count("vsl-card"))
print("convo turn count:", dom.count("turn"))
print("sjbChart present:", "sjbChart" in dom)
print("sjb-chart line count:", dom.count("<path") + dom.count("<line"))
