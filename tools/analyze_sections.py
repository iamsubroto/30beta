from PIL import Image
import os

for name in sorted(os.listdir("verification_screenshots/sections")):
    p = os.path.join("verification_screenshots/sections", name)
    im = Image.open(p)
    # Check bounding box of non-white pixels
    # convert to grayscale
    gray = im.convert("L")
    # find min and max
    extrema = gray.getextrema()
    # count non-white pixels
    pixels = list(gray.getdata())
    non_white = sum(1 for px in pixels if px < 250)
    print(f"{name}: size={im.size}, non-white pixel ratio={non_white / len(pixels):.3f}, brightness range={extrema}")
