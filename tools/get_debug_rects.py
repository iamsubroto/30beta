import subprocess
import time

CHROME = r"C:\Program Files\Google\Chrome\Application\chrome.exe"
PORT = 8093

server_proc = subprocess.Popen(["python", "-m", "http.server", str(PORT)], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
time.sleep(1.5)

js_script = """
const el = document.querySelector('.builder-6f5d765b877345e3aa80e93cd1450b14');
const r = el.getBoundingClientRect();
console.log('SJ_PROOF_RECT:' + JSON.stringify({
  top: r.top, bottom: r.bottom, left: r.left, right: r.right, width: r.width, height: r.height
}));
const children = Array.from(el.children).map((c, i) => {
  const cr = c.getBoundingClientRect();
  const txt = c.querySelector('.builder-text');
  const tr = txt ? txt.getBoundingClientRect() : null;
  return {
    i,
    c_rect: { top: cr.top, bottom: cr.bottom, left: cr.left, right: cr.right, width: cr.width, height: cr.height },
    t_rect: tr ? { top: tr.top, bottom: tr.bottom, left: tr.left, right: tr.right, width: tr.width, height: tr.height } : null,
    text: c.innerText
  };
});
console.log('SJ_PROOF_CHILDREN:' + JSON.stringify(children));
"""

with open("tools/debug_proof.js", "w", encoding="utf-8") as f:
    f.write(js_script)

for w in [1440, 768, 390]:
    cmd = [
        CHROME,
        "--headless=new",
        "--disable-gpu",
        f"--window-size={w},1200",
        f"http://127.0.0.1:{PORT}/index.html"
    ]
    # We can evaluate js by modifying index.html temporarily or running with CDP
server_proc.terminate()
