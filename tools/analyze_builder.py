import json

with open("next_data.json", "r", encoding="utf-8") as f:
    props = json.load(f)

landing = props.get("landing", {})
data = landing.get("data", {})

print("ID:", landing.get("id"))
print("Name:", landing.get("name"))
print("Title:", data.get("title"))
print("Description:", data.get("description"))

# Let's see custom fonts or CSS in data
print("Custom CSS in data:", data.get("customCss"))
print("Custom JS in data:", data.get("customJs"))
print("Inputs:", data.get("inputs"))
print("Styles:", data.get("styles"))
print("Theme:", data.get("theme"))

# Let's count elements and types
element_types = {}
def count_elements(node):
    t = node.get("component", {}).get("name") or node.get("tagName") or "div"
    element_types[t] = element_types.get(t, 0) + 1
    for child in node.get("children", []):
        count_elements(child)

for b in data.get("blocks", []):
    count_elements(b)

print("Element type counts:", element_types)
