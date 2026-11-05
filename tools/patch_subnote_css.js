const fs = require('fs');
let s = fs.readFileSync('30beta/style.css', 'utf8');

const target = '.todavia-btn-arrow svg {\n  width: 20px;\n  height: 20px;\n}';
const targetCRLF = '.todavia-btn-arrow svg {\r\n  width: 20px;\r\n  height: 20px;\r\n}';

let p = s.indexOf(target);
let len = target.length;
if (p === -1) {
  p = s.indexOf(targetCRLF);
  len = targetCRLF.length;
}

if (p === -1) {
  console.error("Target not found in style.css!");
  process.exit(1);
}

const snippet = `

.todavia-subnote {
  margin: 14px 0 0 0 !important;
  font-size: 15px !important;
  line-height: 1.45 !important;
  color: #F0DDE4 !important;
  text-align: center !important;
  width: 100% !important;
  font-weight: 400 !important;
}

.todavia-subnote strong {
  color: #FF2E74 !important;
  font-weight: 700 !important;
}`;

s = s.substring(0, p + len) + snippet + s.substring(p + len);

// Also add mobile adjustment in 640px media query
const mobMarker = '.todavia-badge {\n    font-size: 11.5px;\n    padding: 6px 18px;\n  }';
const mobMarkerCRLF = '.todavia-badge {\r\n    font-size: 11.5px;\r\n    padding: 6px 18px;\r\n  }';
let mp = s.indexOf(mobMarker);
let mlen = mobMarker.length;
if (mp === -1) {
  mp = s.indexOf(mobMarkerCRLF);
  mlen = mobMarkerCRLF.length;
}

if (mp !== -1) {
  const mobSnippet = `\n\n  .todavia-subnote {\n    font-size: 13.5px !important;\n    margin-top: 12px !important;\n  }`;
  s = s.substring(0, mp + mlen) + mobSnippet + s.substring(mp + mlen);
}

fs.writeFileSync('30beta/style.css', s, 'utf8');
console.log('Successfully added subnote styles to style.css!');
