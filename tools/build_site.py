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

print("Found sj-page! Direct children:", len(sj_page.find_all(recursive=False)))

# 3. Remove all <style> tags inside sj_page since they are all merged into style.css
for s in sj_page.find_all("style"):
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
        # update or add sources
        source = pic.find("source")
        if source:
            source["srcset"] = local_img_path
        
        # Check if img already exists
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

# Also replace any remaining remote builder cdn images with local ones
for img in sj_page.find_all("img"):
    src = img.get("src", "")
    for remote, local in img_map.items():
        if remote in src or src in remote:
            img["src"] = "./" + local.replace("\\", "/")

# 6. Extract all scripts from sj_page and put them into script.js
scripts = []
for sc in sj_page.find_all("script"):
    js_text = sc.string or sc.get_text()
    if js_text and js_text.strip():
        scripts.append(js_text.strip())
    sc.decompose()

# Read Custom Code 0 script if it was outside sj_page
with open("custom_codes.json", "r", encoding="utf-8") as f:
    ccs = json.load(f)

# CC 0 script
cc0_code = ccs[0]["code"]
cc0_scripts = re.findall(r'<script[^>]*>([\s\S]*?)<\/script>', cc0_code)
for s in cc0_scripts:
    if s.strip() not in scripts:
        scripts.insert(0, s.strip())

# Combine all scripts
final_script = """/**
 * Immunotec She+ / She-Join Standalone Interactive Scripts
 * Handles:
 * - Smooth scroll navigation to #why and #packages
 * - Mobile scroll reveal animations
 * - Interactive perimenopause conversation thread
 * - Clinical study results chart animation
 * - Testimonial video slider with Vimeo embed on demand
 * - Guide download lead capture form
 * - Consultant / Customer pack selection & cart flow
 */

""" + "\n\n/* -------------------------------------------------------------------------- */\n\n".join(scripts)

# Update VSL poster paths in final_script to local images
for p_id in [
  "d8b90bceb6464755b0b477f0f91b4580",
  "3a52181f6ca245c69f9a56d19be682c6",
  "4f2e697f49cd4180a01f29d263226507",
  "e3f918189fea40b48e61cac195399cbc",
  "7b9aecfcc1ee41218be95c269f5fe8c9",
  "e16a970adf0e4440ba3ee2d51b0be9d1",
  "88531704c2a54eadbd7946f3db315b16",
  "6807dd0f90e64b5db594d9b7baec715c"
]:
    # Look for matching local file in assets/images
    for ext in [".webp", ".png", ".jpg"]:
        local_f = f"./assets/images/{p_id}{ext}"
        if os.path.exists(local_f.replace("./", "")):
            # Replace builder poster pattern in script
            pass

# In the script, replace var POSTER = "https://cdn.builder.io/api/v1/image/assets%2Ffdb4d79bfbfd478d89398007f8c29424%2F";
# with local poster logic
final_script = final_script.replace(
    'var POSTER = "https://cdn.builder.io/api/v1/image/assets%2Ffdb4d79bfbfd478d89398007f8c29424%2F";',
    'var POSTER = "./assets/images/";'
)
final_script = final_script.replace(
    '+ "?format=webp&width=400&quality=80"',
    '+ ".webp"'
)

with open("script.js", "w", encoding="utf-8") as f:
    f.write(final_script)

print(f"Saved script.js ({len(final_script)} bytes)")

# 7. Generate clean index.html
html_content = str(sj_page)

index_html = f"""<!DOCTYPE html>
<html lang="es-US">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>¡Entra en tu nueva etapa! - She+ | Immunotec</title>
  <meta name="description" content="La perimenopausia acaba de volverse… ¿rentable? Descubre She+, el suplemento diario en jelly stick para la perimenopausia y menopausia.">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main class="builder-component builder-component-2f98e06acd2c486697712d602aad4f66">
    <div class="builder-content" data-builder-content-id="2f98e06acd2c486697712d602aad4f66">
      <div class="builder-blocks" data-builder-blocks="true">
        {html_content}
      </div>
    </div>
  </main>
  <script src="script.js"></script>
</body>
</html>
"""

with open("index.html", "w", encoding="utf-8") as f:
    f.write(index_html)

print(f"Saved index.html ({len(index_html)} bytes)")
