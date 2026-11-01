# Project Context: She+ Landing Page Replication

## Objective
Pixel-accurate standalone replication of the main content from:
`https://www.immunotec.com/es-US/momentum/page/she-join`
(Strictly main content only: excludes site header, navigation bar, footer, and cookies banner).

## Tech Stack & Architecture
- **HTML:** [index.html](file:///C:/bakcup/30beta/index.html) — Semantic Builder.io AST layout.
- **CSS:** [style.css](file:///C:/bakcup/30beta/style.css) — Emotion CSS rules + responsive breakpoints (`991px`, `640px`).
- **JavaScript:** [script.js](file:///C:/bakcup/30beta/script.js) — Vanilla JS (marquee, conversation thread, SVG chart, video slider, lead form).
- **Assets:** [assets/](file:///C:/bakcup/30beta/assets/)
  - `fonts/`: 3 Akzidenz-Grotesk BQ font files (`woff2`).
  - `images/`: 63 local images & icons (0 external 404 dependencies).

## Completed Work & Critical Fixes
1. **Full Page Extracted & Built:** Complete layout from Hero down to *Fuentes* references.
2. **Interactive Features:**
   - Smooth anchor scrolling (`#why`, `#packages`).
   - Infinite marquee ticker (`.sj-marq`).
   - Mobile interactive conversation bubble thread (`#convoThread`).
   - SVG interactive clinical trial chart (`#sjbChart`).
   - 8-creator testimonial video carousel with poster mapping and Vimeo embed (`.sjv`).
3. **Card Border Overflow Fixes (`flex-shrink: 0` overrides):**
   - Proof testimonial cards (`.sj-proof .css-q2qocb`): constrained with `flex: 1 1 0% !important; min-width: 0 !important;`.
   - "Botánicos naturales" card (`.sj-rv1 .css-1s8wi70`): constrained with responsive flex wrapping.
   - Verified across viewports: 1920px, 1440px, 991px, 768px, 430px, 390px (0 border overflows).

## How to Run & Verify
- **Local Server:** `python -m http.server 8080` -> open `http://localhost:8080/index.html`
- **CDP Verification Tools:**
  - `python tools/test_file.py`: Measures `.sj-proof` boundaries across viewports.
  - `python tools/measure_rv1.py`: Measures `.sj-rv1` botanical card boundaries.
  - Screenshots in [verification_screenshots/](file:///C:/bakcup/30beta/verification_screenshots/).
