import json
import re
import os
from bs4 import BeautifulSoup

# 1. Load data
with open("rendered_builder.html", "r", encoding="utf-8") as f:
    raw_html = f.read()

with open("next_data.json", "r", encoding="utf-8") as f:
    next_data = json.load(f)

with open("image_map.json", "r", encoding="utf-8") as f:
    img_map = json.load(f)

soup = BeautifulSoup(raw_html, "html.parser")

# 2. Extract .sj-page (which is the entire main page content without header/footer/tracking pixel)
sj_page = soup.find("div", class_="sj-page")
if not sj_page:
    print("Error: sj-page not found!")
    exit(1)

# 3. Remove all <style> and <script> tags inside sj_page since they are extracted
for s in sj_page.find_all(["style", "script"]):
    s.decompose()

# 4. Collect image node options from next_data AST
image_nodes_info = {}
def collect_image_info(node):
    comp = node.get("component", {})
    if comp and comp.get("name") == "Image":
        nid = node.get("id")
        opts = comp.get("options", {})
        raw_img = opts.get("image", "")
        local_p = img_map.get(raw_img, "")
        if not local_p:
            base_url = raw_img.split("?")[0]
            for u, p in img_map.items():
                if u.split("?")[0] == base_url:
                    local_p = p
                    break
        image_nodes_info[nid] = {
            "image": raw_img,
            "local_path": local_p.replace("\\", "/"),
            "aspectRatio": opts.get("aspectRatio"),
            "altText": opts.get("altText", ""),
            "fit": opts.get("backgroundSize") or opts.get("fit") or "cover",
            "position": opts.get("backgroundPosition") or opts.get("position") or "center"
        }
    for child in node.get("children", []):
        collect_image_info(child)

for b in next_data.get("landing", {}).get("data", {}).get("blocks", []):
    collect_image_info(b)

# 5. Populate <picture> tags with <img> tags and local src
for block_id, info in image_nodes_info.items():
    container = sj_page.find("div", class_=lambda c: c and block_id in c)
    if not container:
        continue
    pic = container.find("picture")
    if pic:
        local_img_path = "./" + info["local_path"]
        source = pic.find("source")
        if source:
            source["srcset"] = local_img_path
        
        existing_img = pic.find("img")
        if not existing_img:
            img_tag = soup.new_tag("img")
            img_tag["src"] = local_img_path
            img_tag["alt"] = info["altText"]
            img_tag["loading"] = "lazy"
            img_tag["decoding"] = "async"
            img_tag["class"] = "builder-image"
            img_tag["style"] = f"object-fit: {info['fit']}; object-position: {info['position']}; position: absolute; height: 100%; width: 100%; top: 0; left: 0;"
            pic.append(img_tag)
        else:
            existing_img["src"] = local_img_path
            existing_img["alt"] = info["altText"]
            existing_img["class"] = "builder-image"
            existing_img["style"] = f"object-fit: {info['fit']}; object-position: {info['position']}; position: absolute; height: 100%; width: 100%; top: 0; left: 0;"

# Replace any remote builder cdn images across all elements
html_str = str(sj_page)
for remote, local in img_map.items():
    norm_local = "./" + local.replace("\\", "/")
    html_str = html_str.replace(remote, norm_local)

index_html = f"""<!DOCTYPE html>
<html lang="es-US">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>¡Entra en tu nueva etapa! - She+ | Immunotec</title>
  <meta name="description" content="La perimenopausia acaba de volverse… ¿rentable? Descubre She+, el suplemento diario en jelly stick para la perimenopausia y menopausia.">
  <link rel="preload" href="./assets/fonts/803c464be3d2b727-s.p.woff2" as="font" type="font/woff2" crossorigin="anonymous">
  <link rel="preload" href="./assets/fonts/a78f026cb920db78-s.p.woff2" as="font" type="font/woff2" crossorigin="anonymous">
  <link rel="preload" href="./assets/fonts/10e68fcded945cbf-s.p.woff2" as="font" type="font/woff2" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main class="builder-component builder-component-2f98e06acd2c486697712d602aad4f66">
    <div class="builder-content" data-builder-content-id="2f98e06acd2c486697712d602aad4f66">
      <div class="builder-blocks" data-builder-blocks="true">
        {html_str}
      </div>
    </div>
  </main>
  <script src="script.js"></script>
</body>
</html>
"""

with open("index.html", "w", encoding="utf-8") as f:
    f.write(index_html)

print(f"Generated index.html ({len(index_html)} bytes)")
