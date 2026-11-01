from PIL import Image
import os

shots = [
    "screenshot_1440.png",
    "screenshot_1920.png",
    "screenshot_768.png",
    "screenshot_390.png",
    "screenshot_430.png"
]

print("Verifying viewport screenshots:")
for s in shots:
    p = os.path.join("verification_screenshots", s)
    if os.path.exists(p):
        im = Image.open(p)
        print(f"  {s}: size={im.size}, mode={im.mode}")
    else:
        print(f"  {s}: MISSING!")
