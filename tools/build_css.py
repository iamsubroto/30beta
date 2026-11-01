import re
import json

with open("rendered_builder.html", "r", encoding="utf-8") as f:
    html = f.read()

# Extract all <style> contents
style_tags = re.findall(r'<style[^>]*>([\s\S]*?)<\/style>', html)
print(f"Total style tags in rendered_builder.html: {len(style_tags)}")

# Read image_map.json
with open("image_map.json", "r", encoding="utf-8") as f:
    img_map = json.load(f)

# Base CSS with @font-face and base builder reset
base_css = """/* ==========================================================================
   IMMUNOTEC SHE+ / SHE-JOIN STANDALONE REPLICATION
   Pixel-Accurate Standalone Stylesheet
   ========================================================================== */

/* Typography: Akzidenz Grotesk BQ */
@font-face {
  font-family: '__akzidenzGroteskBQ_ca8b24';
  src: url('./assets/fonts/803c464be3d2b727-s.p.woff2') format('woff2');
  font-weight: 400;
  font-style: normal;
  font-display: swap;
}

@font-face {
  font-family: '__akzidenzGroteskBQ_ca8b24';
  src: url('./assets/fonts/a78f026cb920db78-s.p.woff2') format('woff2');
  font-weight: 500;
  font-style: normal;
  font-display: swap;
}

@font-face {
  font-family: '__akzidenzGroteskBQ_ca8b24';
  src: url('./assets/fonts/10e68fcded945cbf-s.p.woff2') format('woff2');
  font-weight: 700;
  font-style: normal;
  font-display: swap;
}

:root {
  --font-family-base: '__akzidenzGroteskBQ_ca8b24', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
  --color-text-main: #000000;
  --color-bg-main: #FFFFFF;
  --color-red: #D4232B;
}

*, *::before, *::after {
  box-sizing: border-box;
}

html {
  -webkit-text-size-adjust: 100%;
  font-family: var(--font-family-base);
  color: var(--color-text-main);
  background-color: var(--color-bg-main);
  scroll-behavior: smooth;
  margin: 0;
  padding: 0;
}

body {
  margin: 0;
  padding: 0;
  font-family: var(--font-family-base);
  color: var(--color-text-main);
  background-color: var(--color-bg-main);
  line-height: 1.5;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

/* Builder.io Base Framework Rules */
.builder-component {
  display: flex;
  flex-direction: column;
  position: relative;
  box-sizing: border-box;
  width: 100%;
}

.builder-block {
  display: flex;
  flex-direction: column;
  position: relative;
  flex-shrink: 0;
  box-sizing: border-box;
}

.builder-text {
  outline: none;
  box-sizing: border-box;
}

.builder-text p {
  margin: 0;
}

.builder-text p:first-of-type {
  margin: 0;
}

.builder-image {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
  opacity: 1;
}

.builder-image-sizer {
  width: 100%;
  pointer-events: none;
  font-size: 0;
}

picture {
  display: block;
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
}

picture > img {
  display: block;
  width: 100%;
  height: 100%;
}

/* ==========================================================================
   Extracted Emotion & Custom CSS Rules
   ========================================================================== */
"""

seen_rules = set()
collected_rules = []

for s in style_tags:
    clean_s = s.strip()
    if not clean_s:
        continue
    # Replace CDN images with local image paths
    for remote_url, local_path in img_map.items():
        # normalized local path for css
        norm_local = local_path.replace("\\", "/")
        clean_s = clean_s.replace(remote_url, f"./{norm_local}")
    
    if clean_s not in seen_rules:
        seen_rules.add(clean_s)
        collected_rules.append(clean_s)

full_css = base_css + "\n\n" + "\n\n".join(collected_rules)

with open("style.css", "w", encoding="utf-8") as f:
    f.write(full_css)

print(f"Successfully generated style.css ({len(full_css)} bytes, {len(collected_rules)} style blocks)")
