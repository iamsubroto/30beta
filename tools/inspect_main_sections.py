import sys
from bs4 import BeautifulSoup

sys.stdout.reconfigure(encoding='utf-8')

with open("rendered_builder.html", "r", encoding="utf-8") as f:
    soup = BeautifulSoup(f.read(), "html.parser")

main_block = soup.find("div", class_="builder-9053e3deafef46f6a0ee9c9281b1df08")
print("Found main_block:", main_block is not None)

children = main_block.find_all(recursive=False)
print("Main block direct children count:", len(children))
for i, c in enumerate(children):
    cls = c.get("class", [])
    text = c.get_text()[:80].strip().replace("\n", " ")
    print(f"Section {i}: tag={c.name}, class={cls}, text='{text}'")
