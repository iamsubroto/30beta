from PIL import Image
import os

# Let's inspect verification_screenshots/proof_1440.png, proof_768.png, proof_390.png
for name in ["proof_1440.png", "proof_768.png", "proof_390.png"]:
    p = os.path.join("verification_screenshots", name)
    if os.path.exists(p):
        im = Image.open(p)
        print(f"Loaded {name}: {im.size}")
        # Crop the bottom area of the viewport where the proof cards are
        # Let's find where they are
