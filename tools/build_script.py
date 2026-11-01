import json
import re

with open("custom_codes.json", "r", encoding="utf-8") as f:
    ccs = json.load(f)

scripts = []

for i in [0, 2, 3, 4, 6, 7, 11]:
    cc = ccs[i]
    code = cc["code"]
    found = re.findall(r'<script[^>]*>([\s\S]*?)<\/script>', code)
    for s in found:
        scripts.append({
            "cc_index": i,
            "id": cc["id"],
            "script": s.strip()
        })

print(f"Total script blocks found: {len(scripts)}")

script_contents = []

for item in scripts:
    s = item["script"]
    # Replace remote builder image URL in video slider with local asset path
    s = s.replace(
        'var POSTER = "https://cdn.builder.io/api/v1/image/assets%2Ffdb4d79bfbfd478d89398007f8c29424%2F";',
        'var POSTER = "./assets/images/";'
    )
    s = s.replace(
        '+ "?format=webp&width=400&quality=80"',
        '+ ".webp"'
    )
    # Ensure fallbacks work cleanly if local file extension differs
    script_contents.append(f"/* === Feature Block CC {item['cc_index']} ({item['id']}) === */\n{s}")

header = """/**
 * Immunotec She+ / She-Join Standalone Interactive Scripts
 * Pure vanilla JavaScript without external framework dependencies.
 *
 * Implements:
 * 1. Smooth Navigation & Scroll Positioning (#why and #packages)
 * 2. Mobile Section Scroll Reveal Animation (IntersectionObserver)
 * 3. Interactive Perimenopause Symptoms Conversation Thread
 * 4. Free Survival Guide Download Form Lead Capture
 * 5. Interactive Clinical Study Results SVG Chart (Vitamins/Hormones Timeline)
 * 6. Creator & Consultant Testimonial Video Slider (Vimeo Embed on Demand)
 * 7. Starter Pack Selection & Cart Flow Routing
 */

document.addEventListener('DOMContentLoaded', function () {
  console.log('Immunotec She+ Standalone Page Initialized');
});
"""

full_script = header + "\n\n" + "\n\n".join(script_contents)

with open("script.js", "w", encoding="utf-8") as f:
    f.write(full_script)

print(f"Generated script.js ({len(full_script)} bytes)")
