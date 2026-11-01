import json

with open("next_data.json", "r", encoding="utf-8") as f:
    props = json.load(f)

landing_data = props.get("landing", {}).get("data", {})

def inspect_styles(node, limit=10, count=[0]):
    if count[0] >= limit:
        return
    st = node.get("responsiveStyles")
    if st:
        count[0] += 1
        print(f"Node {node.get('id')} ({node.get('component', {}).get('name') or node.get('tagName')}):")
        for bp, rules in st.items():
            print(f"  [{bp}]: {rules}")
    for child in node.get("children", []):
        inspect_styles(child, limit, count)

inspect_styles(landing_data.get("blocks", [])[0])
