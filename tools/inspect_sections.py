from bs4 import BeautifulSoup
import re

with open("rendered_builder.html", "r", encoding="utf-8") as f:
    soup = BeautifulSoup(f.read(), "html.parser")

root = soup.find("div", class_="builder-component")
print("Found root:", root is not None)

# Find top level children
blocks_wrapper = root.find("div", class_="builder-blocks")
if blocks_wrapper:
    print("Direct children of builder-blocks:", len(blocks_wrapper.find_all(recursive=False)))
    for i, child in enumerate(blocks_wrapper.find_all(recursive=False)):
        cls = child.get("class", [])
        text = child.get_text()[:60].replace("\n", " ")
        print(f"Child {i}: tag={child.name}, class={cls}, text='{text}'")
