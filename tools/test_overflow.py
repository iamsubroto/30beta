import subprocess
import time

CHROME = r"C:\Program Files\Google\Chrome\Application\chrome.exe"
PORT = 8094

server_proc = subprocess.Popen(["python", "-m", "http.server", str(PORT)], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
time.sleep(1.5)

# Temporary html test to get element details
test_html = """<!DOCTYPE html>
<html>
<body>
<script>
fetch('http://127.0.0.1:8094/index.html')
  .then(r => r.text())
  .then(html => {
    // we can parse it
  });
</script>
</body>
</html>
"""

# Let's inspect index.html by injecting a small script into index.html temporarily that logs computed styles to console
with open("index.html", "r", encoding="utf-8") as f:
    orig_html = f.read()

debug_script = """
<script>
window.addEventListener('DOMContentLoaded', function(){
  var el = document.querySelector('.builder-6f5d765b877345e3aa80e93cd1450b14');
  if (!el) { console.log('DEBUG: NOT FOUND'); return; }
  var r = el.getBoundingClientRect();
  console.log('DEBUG: PROOF_BOX: top=' + r.top + ' bottom=' + r.bottom + ' h=' + r.height + ' w=' + r.width);
  Array.prototype.forEach.call(el.children, function(c, i){
    var cr = c.getBoundingClientRect();
    var p = c.querySelector('p');
    var pr = p ? p.getBoundingClientRect() : null;
    console.log('DEBUG: CARD_' + i + ': top=' + cr.top + ' bottom=' + cr.bottom + ' h=' + cr.height + ' w=' + cr.width);
    if (pr) {
      console.log('DEBUG: P_' + i + ': top=' + pr.top + ' bottom=' + pr.bottom + ' h=' + pr.height + ' w=' + pr.width);
      if (pr.bottom > cr.bottom) {
        console.log('DEBUG: OVERFLOW_DETECTED in card ' + i + '! Text bottom (' + pr.bottom + ') > card bottom (' + cr.bottom + ')');
      }
      if (pr.right > cr.right) {
        console.log('DEBUG: OVERFLOW_HORIZONTAL in card ' + i + '! Text right (' + pr.right + ') > card right (' + cr.right + ')');
      }
    }
  });
});
</script>
"""

with open("index.html", "w", encoding="utf-8") as f:
    f.write(orig_html.replace("</body>", debug_script + "</body>"))

for w in [1440, 1024, 768, 640, 390]:
    cmd = [
        CHROME,
        "--headless=new",
        "--disable-gpu",
        f"--window-size={w},1000",
        f"http://127.0.0.1:{PORT}/index.html"
    ]
    res = subprocess.run(cmd, capture_output=True, encoding="utf-8", errors="replace", timeout=10)
    print(f"\n=== Viewport {w}px ===")
    for line in (res.stdout + res.stderr).splitlines():
        if "DEBUG:" in line:
            print(" ", line)

with open("index.html", "w", encoding="utf-8") as f:
    f.write(orig_html)

server_proc.terminate()
