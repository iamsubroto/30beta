from bs4 import BeautifulSoup

with open("fetched.html", "r", encoding="utf-8") as f:
    html = f.read()

soup = BeautifulSoup(html, "html.parser")
next_div = soup.find("div", id="__next")

print("Length of #__next html:", len(str(next_div)))
# Save the rendered HTML inside #__next
with open("next_div.html", "w", encoding="utf-8") as f:
    f.write(soup.prettify())

# Let's inspect what elements are inside #__next
classes = set()
for tag in next_div.find_all(True):
    if tag.get("class"):
        classes.update(tag.get("class"))
print("Some classes:", list(classes)[:20])
