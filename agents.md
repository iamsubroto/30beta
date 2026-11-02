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
3. **Card Border & Layout Fixes:**
   - Hero proof cards (`.sj-proof`): 3 columns horizontally on desktop; stacked **vertically** on mobile/tablet (`<=991px`) so all 3 boxes are fully visible with 0 cropping.
   - "Botánicos naturales" card (`.sj-rv1 .css-1s8wi70`): constrained with responsive flex wrapping.
   - Verified across viewports: 1920px, 1440px, 991px, 768px, 430px, 390px.

