from bs4 import BeautifulSoup
import re

with open("rendered_builder.html", "r", encoding="utf-8") as f:
    html = f.read()

soup = BeautifulSoup(html, "html.parser")

imgs = soup.find_all("img")
print(f"Total img tags: {len(imgs)}")
for i, img in enumerate(imgs[:10]):
    print(f"Img {i}: src={img.get('src')}, srcset={img.get('srcset')}, class={img.get('class')}")

pictures = soup.find_all("picture")
print(f"Total picture tags: {len(pictures)}")
for i, pic in enumerate(pictures[:5]):
    sources = pic.find_all("source")
    img = pic.find("img")
    print(f"Picture {i}: sources count={len(sources)}, img src={img.get('src') if img else None}")

# Check srcset regex
srcsets = re.findall(r'srcset="([^"]+)"', html)
print(f"Total srcset occurrences: {len(srcsets)}")
