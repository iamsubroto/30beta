import subprocess
import time

CHROME = r"C:\Program Files\Google\Chrome\Application\chrome.exe"
PORT = 8092

server_proc = subprocess.Popen(["python", "-m", "http.server", str(PORT)], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
time.sleep(1.5)

js_eval = """
(function(){
  var el = document.querySelector('.builder-6f5d765b877345e3aa80e93cd1450b14');
  if (!el) return 'Element not found';
  var r = el.getBoundingClientRect();
  var cs = window.getComputedStyle(el);
  var res = {
    top: r.top, left: r.left, width: r.width, height: r.height,
    display: cs.display, flexDirection: cs.flexDirection,
    borderTop: cs.borderTop, borderBottom: cs.borderBottom,
    overflowX: cs.overflowX,
    children: []
  };
  Array.prototype.forEach.call(el.children, function(c, i){
    var cr = c.getBoundingClientRect();
    var ccs = window.getComputedStyle(c);
    var textNode = c.querySelector('.builder-text');
    var tr = textNode ? textNode.getBoundingClientRect() : null;
    res.children.push({
      index: i,
      box: { top: cr.top, left: cr.left, width: cr.width, height: cr.height },
      textNodeBox: tr ? { top: tr.top, left: tr.left, width: tr.width, height: tr.height } : null,
      border: ccs.border,
      borderLeft: ccs.borderLeft,
      padding: ccs.padding,
      flex: ccs.flex,
      whiteSpace: ccs.whiteSpace,
      text: c.innerText.replace(/\\n/g, ' ')
    });
  });
  return JSON.stringify(res, null, 2);
})();
"""

with open("tools/eval.js", "w", encoding="utf-8") as f:
    f.write(js_eval)

cmd = [
    CHROME,
    "--headless=new",
    "--disable-gpu",
    "--window-size=1440,900",
    f"http://127.0.0.1:{PORT}/index.html"
]

# Use python CDP or evaluate to get rects at 1440 and at 768 and 390
import urllib.request
import json

server_proc.terminate()
