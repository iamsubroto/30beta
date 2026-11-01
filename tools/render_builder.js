const fs = require('fs');
const React = require('react');
const ReactDOMServer = require('react-dom/server');
const { BuilderComponent, builder } = require('@builder.io/react');

const nextData = JSON.parse(fs.readFileSync('next_data.json', 'utf8'));
const landing = nextData.landing;

console.log("Rendering Builder content...");
try {
  const html = ReactDOMServer.renderToString(
    React.createElement(BuilderComponent, {
      content: landing,
      model: "page"
    })
  );
  console.log("Rendered HTML length:", html.length);
  fs.writeFileSync('rendered_builder.html', html, 'utf8');
  console.log("Successfully saved rendered_builder.html!");
} catch (e) {
  console.error("Error rendering:", e);
}
