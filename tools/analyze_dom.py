import json
from bs4 import BeautifulSoup

with open("fetched.html", "r", encoding="utf-8") as f:
    html = f.read()

soup = BeautifulSoup(html, "html.parser")
next_div = soup.find("div", id="__next")

print("Found #__next:", next_div is not None)
if next_div:
    # Print direct children of #__next
    children = [child.name for child in next_div.children if child.name]
    print("Children of #__next:", children)
    
    # Check for main or section or article
    main = next_div.find("main")
    print("Found <main>:", main is not None)
    
    sections = next_div.find_all("section")
    print("Count of <section>:", len(sections))

with open("next_data.json", "r", encoding="utf-8") as f:
    props = json.load(f)

blocks = props.get("landing", {}).get("data", {}).get("blocks", [])
print(f"Total blocks in data: {len(blocks)}")
for i, b in enumerate(blocks):
    print(f"Block {i}: component = {b.get('component')}, name = {b.get('name')}, type = {b.get('_template') or b.get('type')}")
    # print keys of block
    print(f"   keys: {list(b.keys())}")
