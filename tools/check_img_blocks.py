from bs4 import BeautifulSoup

with open("rendered_builder.html", "r", encoding="utf-8") as f:
    soup = BeautifulSoup(f.read(), "html.parser")

img_blocks = soup.find_all(lambda tag: tag.has_attr('class') and any('builder-image' in c for c in tag['class']))
print("Builder image blocks count:", len(img_blocks))

if img_blocks:
    print("Sample img_block 0:")
    print(img_blocks[0].prettify())
    print("Children:", [c.name for c in img_blocks[0].children if c.name])
