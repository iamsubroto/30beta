import sys
from bs4 import BeautifulSoup

sys.stdout.reconfigure(encoding='utf-8')

with open("rendered_builder.html", "r", encoding="utf-8") as f:
    soup = BeautifulSoup(f.read(), "html.parser")

sj_page = soup.find("div", class_="sj-page")
print("Found sj-page:", sj_page is not None)

children = sj_page.find_all(recursive=False)
print("sj-page direct children count:", len(children))
for i, c in enumerate(children):
    cls = c.get("class", [])
    text = c.get_text()[:80].strip().replace("\n", " ")
    print(f"Child {i}: tag={c.name}, class={cls}, text='{text}'")
