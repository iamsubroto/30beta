const fs = require('fs');
const http = require('http');
const path = require('path');
const { spawn } = require('child_process');

// 1. Create preview HTML from 30beta/index_beta.php
let content = fs.readFileSync('30beta/index_beta.php', 'utf8');

// Replace PHP tags with mock values for visual preview
content = content.replace(/<\?php[\s\S]*?\?>/g, '');
content = content.replace(/<\?=[\s\S]*?\?>/g, '');
content = content.replace(/href="style\.css[^"]*"/, 'href="/30beta/style.css"');
content = content.replace(/src="script\.js[^"]*"/, 'src="/30beta/script.js"');
content = content.replace(/src="\.\/assets\//g, 'src="/30beta/assets/');
content = content.replace(/srcset="\.\/assets\//g, 'srcset="/30beta/assets/');

fs.writeFileSync('tools/preview_index.html', content, 'utf8');
console.log('Created tools/preview_index.html');

// 2. Start HTTP server
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
    console.error('File not found:', filePath);
    res.writeHead(404);
    res.end('Not found');
    return;
  }

  const ext = path.extname(filePath).toLowerCase();
  res.writeHead(200, { 'Content-Type': mimeTypes[ext] || 'application/octet-stream' });
  fs.createReadStream(filePath).pipe(res);
});

const PORT = 8096;
server.listen(PORT, async () => {
  console.log(`Server listening on port ${PORT}`);

  const CHROME = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const chromeProc = spawn(CHROME, [
    '--headless=new',
    '--remote-debugging-port=9245',
    '--user-data-dir=C:\\tmp\\chrome_node_verify_full',
    '--disable-gpu',
    'about:blank'
  ]);

  await new Promise(r => setTimeout(r, 2000));

  try {
    const listRes = await fetch('http://127.0.0.1:9245/json');
    const targets = await listRes.json();
    const pageTarget = targets.find(t => t.type === 'page');

    const ws = new WebSocket(pageTarget.webSocketDebuggerUrl);

    await new Promise(res => ws.onopen = res);

    let msgId = 1;
    const callbacks = new Map();
    ws.onmessage = (event) => {
      const data = JSON.parse(event.data);
      if (data.id && callbacks.has(data.id)) {
        callbacks.get(data.id)(data.result);
        callbacks.delete(data.id);
      }
    };

    function send(method, params = {}) {
      return new Promise((res) => {
        const id = msgId++;
        callbacks.set(id, res);
        ws.send(JSON.stringify({ id, method, params }));
      });
    }

    await send('Page.enable');

    const viewports = [
      { width: 1440, height: 900, name: 'todavia_desktop_1440.png', mobile: false },
      { width: 768, height: 1024, name: 'todavia_tablet_768.png', mobile: false },
      { width: 390, height: 844, name: 'todavia_mobile_390.png', mobile: true }
    ];

    for (const vp of viewports) {
      await send('Emulation.setDeviceMetricsOverride', {
        width: vp.width,
        height: vp.height,
        deviceScaleFactor: 1,
        mobile: vp.mobile
      });

      await send('Page.navigate', { url: `http://127.0.0.1:${PORT}/tools/preview_index.html` });
      await new Promise(r => setTimeout(r, 2500));

      const rectRes = await send('Runtime.evaluate', {
        expression: `
          (function(){
            var el = document.querySelector('.todavia-section');
            if (!el) return null;
            var r = el.getBoundingClientRect();
            var docY = r.top + window.pageYOffset;
            var docX = r.left + window.pageXOffset;
            return JSON.stringify({
              x: Math.max(0, Math.round(docX)),
              y: Math.max(0, Math.round(docY)),
              width: Math.round(r.width),
              height: Math.round(r.height),
              scale: 1
            });
          })()
        `
      });

      const rectStr = rectRes && rectRes.result && rectRes.result.value;
      if (!rectStr) {
        console.error(`Could not find .todavia-section for ${vp.name}`);
        continue;
      }

      const clip = JSON.parse(rectStr);
      console.log(`${vp.name} clip:`, clip);

      // Scroll element into view so lazy images load
      await send('Runtime.evaluate', {
        expression: `window.scrollTo(0, ${clip.y - 20});`
      });
      await new Promise(r => setTimeout(r, 1000));

      const shot = await send('Page.captureScreenshot', {
        format: 'png',
        clip: clip,
        captureBeyondViewport: true
      });

      if (!fs.existsSync('verification_screenshots')) {
        fs.mkdirSync('verification_screenshots');
      }

      fs.writeFileSync(`verification_screenshots/${vp.name}`, Buffer.from(shot.data, 'base64'));
      console.log(`Saved verification_screenshots/${vp.name}`);
    }

    ws.close();
  } catch (e) {
    console.error('Error during capture:', e);
  } finally {
    chromeProc.kill();
    server.close();
    process.exit(0);
  }
});
