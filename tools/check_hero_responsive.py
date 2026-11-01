from PIL import Image
import os

viewports = ["1440", "1920", "768", "390", "430"]

os.makedirs("verification_screenshots/hero_crops", exist_ok=True)

for vp in viewports:
    p = f"verification_screenshots/screenshot_{vp}.png"
    im = Image.open(p)
    w, h = im.size
    # crop top 600px of hero
    crop_h = min(h, 600)
    cropped = im.crop((0, 0, w, crop_h))
    out_f = f"verification_screenshots/hero_crops/hero_{vp}.png"
    cropped.save(out_f)
    print(f"Hero crop {vp}: size={cropped.size}, saved to {out_f}")
