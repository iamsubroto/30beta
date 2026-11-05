const fs = require('fs');
const http = require('http');
const path = require('path');
const { spawn } = require('child_process');

const mimeTypes = {
  '.html': 'text/html',
  '.css': 'text/css',
  '.js': 'application/javascript',
  '.png': 'image/png',
  '.jpg': 'image/jpeg',
  '.svg': 'image/svg+xml',
  '.woff2': 'font/woff2'
};

const server = http.createServer((req, res) => {
  let reqPath = decodeURI(req.url.split('?')[0]);
  if (reqPath === '/') reqPath = '/tools/preview_index.html';
  const filePath = path.join(process.cwd(), reqPath.replace(/^\//, ''));

  if (!fs.existsSync(filePath)) {
    res.writeHead(404);
    res.end('Not found');
    return;
  }

  const ext = path.extname(filePath).toLowerCase();
  res.writeHead(200, { 'Content-Type': mimeTypes[ext] || 'application/octet-stream' });
  fs.createReadStream(filePath).pipe(res);
});

server.listen(8095, async () => {
  const CHROME = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const proc = spawn(CHROME, ['--headless=new', '--remote-debugging-port=9242', '--user-data-dir=C:\\tmp\\chrome_mob_test3', '--disable-gpu', 'about:blank']);
  await new Promise(r => setTimeout(r, 2000));
  try {
    const list = await (await fetch('http://127.0.0.1:9242/json')).json();
    const ws = new WebSocket(list[0].webSocketDebuggerUrl);
    await new Promise(r => ws.onopen = r);
    let id = 1;
    function call(m, p={}) {
      return new Promise(r => {
        const cur = id++;
        const h = e => {
          const d = JSON.parse(e.data);
          if (d.id === cur) { ws.removeEventListener('message', h); r(d.result); }
        };
        ws.addEventListener('message', h);
        ws.send(JSON.stringify({ id: cur, method: m, params: p }));
      });
    }
    await call('Page.enable');
    await call('Emulation.setDeviceMetricsOverride', { width: 390, height: 1200, deviceScaleFactor: 1, mobile: true });
    await call('Page.navigate', { url: 'http://127.0.0.1:8095/tools/preview_index.html' });
    await new Promise(r => setTimeout(r, 2500));
    
    const evalRes = await call('Runtime.evaluate', {
      expression: `
        (function(){
          var el = document.querySelector(".todavia-section");
          var r = el.getBoundingClientRect();
          return JSON.stringify({
            x: Math.max(0, Math.round(r.left + window.pageXOffset)),
            y: Math.max(0, Math.round(r.top + window.pageYOffset)),
            width: Math.round(r.width),
            height: Math.round(r.height),
            scale: 1
          });
        })()
      `
    });
    const clip = JSON.parse(evalRes.result.value);
    console.log('Mobile clip:', clip);

    // Scroll into view
    await call('Runtime.evaluate', {
      expression: `window.scrollTo(0, ${clip.y});`
    });
    await new Promise(r => setTimeout(r, 1000));

    const shot = await call('Page.captureScreenshot', {
      format: 'png',
      clip: clip,
      captureBeyondViewport: true
    });
    fs.writeFileSync('verification_screenshots/todavia_mobile_full.png', Buffer.from(shot.data, 'base64'));
    console.log('Saved todavia_mobile_full.png');
    ws.close();
  } catch (err) {
    console.error(err);
  } finally {
    proc.kill();
    server.close();
    process.exit(0);
  }
});
