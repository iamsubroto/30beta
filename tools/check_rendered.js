const fs = require('fs');

const html = fs.readFileSync('rendered_builder.html', 'utf8');

const styleMatches = html.match(/<style[^>]*>([\s\S]*?)<\/style>/gi) || [];
console.log("Style tags found:", styleMatches.length);
styleMatches.forEach((s, i) => {
  console.log(`Style tag ${i}: ${s.substring(0, 150)}... (length: ${s.length})`);
});

// Let's check classes
const classMatches = html.match(/class="([^"]+)"/g) || [];
console.log("Total class occurrences:", classMatches.length);
const uniqueClasses = new Set();
classMatches.forEach(c => {
  const name = c.replace('class="', '').replace('"', '');
  name.split(/\s+/).forEach(cn => uniqueClasses.add(cn));
});
console.log("Unique classes count:", uniqueClasses.size);
console.log("Sample classes:", Array.from(uniqueClasses).slice(0, 25));
