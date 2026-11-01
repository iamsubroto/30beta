import json
from bs4 import BeautifulSoup

with open("next_data.json", "r", encoding="utf-8") as f:
    props = json.load(f)

landing_data = props.get("landing", {}).get("data", {})

with open("image_map.json", "r", encoding="utf-8") as f:
    img_map = json.load(f)

image_nodes_info = {}

def collect_image_info(node):
    comp = node.get("component", {})
    if comp and comp.get("name") == "Image":
        nid = node.get("id")
        opts = comp.get("options", {})
        raw_img = opts.get("image", "")
        local_p = img_map.get(raw_img, "")
        if not local_p:
            # check if raw_img without query params is in map
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

for b in landing_data.get("blocks", []):
    collect_image_info(b)

print(f"Total image nodes collected from AST: {len(image_nodes_info)}")
missing_local = [k for k, v in image_nodes_info.items() if not v["local_path"]]
print(f"Missing local path: {len(missing_local)}")
if missing_local:
    for m in missing_local:
        print("  Missing:", m, image_nodes_info[m])
