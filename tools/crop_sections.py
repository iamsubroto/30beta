from PIL import Image
import os

im = Image.open("verification_screenshots/tall_1440.png")
w, h = im.size
print(f"Tall image size: {w}x{h}")

os.makedirs("verification_screenshots/sections", exist_ok=True)

sections = [
    ("01_hero", 0, 1100),
    ("02_marquee_and_why", 1000, 2200),
    ("03_chat_thread", 2100, 3400),
    ("04_guide_download", 3300, 4400),
    ("05_market_dark", 4300, 5600),
    ("06_product_sheplus", 5500, 7000),
    ("07_trial_chart", 6900, 8300),
    ("08_video_creators", 8200, 9600),
    ("09_how_it_works", 9500, 10800),
    ("10_packages_pricing", 10700, 12500),
    ("11_sources_footer", 12400, min(h, 14000))
]

for name, y1, y2 in sections:
    box = (0, y1, w, min(y2, h))
    cropped = im.crop(box)
    out_p = f"verification_screenshots/sections/{name}.png"
    cropped.save(out_p)
    print(f"Saved {name}: {cropped.size} ({os.path.getsize(out_p)} bytes)")
