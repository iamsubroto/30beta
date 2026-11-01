import json
import os
import hashlib
from curl_cffi import requests

os.makedirs("assets/images", exist_ok=True)

with open("next_data.json", "r", encoding="utf-8") as f:
    props = json.load(f)

landing_data = props.get("landing", {}).get("data", {})

images = set()

def find_images(node):
    comp = node.get("component", {})
    if comp and comp.get("name") == "Image":
        img = comp.get("options", {}).get("image")
        if img:
            images.add(img)
    # also check background image in responsiveStyles
    st = node.get("responsiveStyles", {})
    for bp, rules in st.items():
        bg = rules.get("backgroundImage")
        if bg and "url(" in bg:
            # extract url
            import re
            m = re.search(r'url\([\'"]?([^\'")]+)[\'"]?\)', bg)
            if m:
                images.add(m.group(1))
    for child in node.get("children", []):
        find_images(child)

for b in landing_data.get("blocks", []):
    find_images(b)

print(f"Total unique images to download: {len(images)}")

# Map each URL to a clean filename in assets/images
url_to_file = {}
for i, url in enumerate(sorted(images)):
    # extract uuid or hash
    parsed = url.split("?")[0]
    filename = parsed.split("%2F")[-1].split("/")[-1]
    if not filename.endswith(('.png', '.jpg', '.jpeg', '.webp', '.svg', '.gif')):
        # add .webp as default or check format param
        if "format=webp" in url:
            filename += ".webp"
        else:
            filename += ".png"
    
    local_path = os.path.join("assets/images", filename)
    url_to_file[url] = local_path
    
    if not os.path.exists(local_path):
        try:
            print(f"Downloading [{i+1}/{len(images)}]: {filename}")
            r = requests.get(url, impersonate="chrome124", timeout=20)
            if r.status_code == 200:
                with open(local_path, "wb") as f:
                    f.write(r.content)
            else:
                print(f"Failed {r.status_code} for {url}")
        except Exception as e:
            print(f"Error {url}: {e}")

print("Done! Downloaded images.")
with open("image_map.json", "w", encoding="utf-8") as f:
    json.dump(url_to_file, f, indent=2)
