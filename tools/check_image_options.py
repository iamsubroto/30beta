import json

with open("next_data.json", "r", encoding="utf-8") as f:
    props = json.load(f)

landing_data = props.get("landing", {}).get("data", {})

def inspect_image_nodes(node):
    comp = node.get("component", {})
    if comp and comp.get("name") == "Image":
        opts = comp.get("options", {})
        print(f"Node id: {node.get('id')}")
        print(f"  image: {opts.get('image')}")
        print(f"  aspectRatio: {opts.get('aspectRatio')}")
        print(f"  altText: {opts.get('altText')}")
        print(f"  fit: {opts.get('backgroundSize') or opts.get('fit')}")
        print(f"  position: {opts.get('backgroundPosition') or opts.get('position')}")
    for child in node.get("children", []):
        inspect_image_nodes(child)

for b in landing_data.get("blocks", []):
    inspect_image_nodes(b)
