import json

with open("next_data.json", "r", encoding="utf-8") as f:
    props = json.load(f)

landing_data = props.get("landing", {}).get("data", {})

def dump_node(node, depth=0):
    indent = "  " * depth
    tag = node.get("tagName", node.get("@type", "unknown"))
    comp = node.get("component", {})
    comp_name = comp.get("name") if comp else ""
    text = ""
    if comp and comp.get("options", {}).get("text"):
        # strip html tags for preview
        import re
        text = re.sub(r'<[^>]+>', '', comp["options"]["text"]).strip()
        text = f" [TEXT: {text[:40]}]"
    
    # check for image
    img = ""
    if comp and comp.get("options", {}).get("image"):
        img = f" [IMAGE: {comp['options']['image'][:50]}]"
    
    id_str = node.get("id", "")
    print(f"{indent}<{tag}{(' ' + comp_name) if comp_name else ''}{id_str and f' #{id_str}'}>{text}{img}")
    
    children = node.get("children", [])
    for child in children:
        dump_node(child, depth + 1)

print("Title:", landing_data.get("title"))
print("Description:", landing_data.get("description"))

for i, block in enumerate(landing_data.get("blocks", [])):
    print(f"\n--- BLOCK {i} ---")
    dump_node(block)
