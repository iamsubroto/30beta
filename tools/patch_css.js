const fs = require('fs');
let s = fs.readFileSync('30beta/style.css', 'utf8');

const marker = '/* ==========================================================================\n   Section: "¿Todavía no estás lista?" (Dark Pink Neon Theme)';
const markerCRLF = '/* ==========================================================================\r\n   Section: "¿Todavía no estás lista?" (Dark Pink Neon Theme)';

let idx = s.indexOf(marker);
if (idx === -1) idx = s.indexOf(markerCRLF);
if (idx === -1) {
  console.error("Marker not found in style.css!");
  process.exit(1);
}

const newCss = `/* ==========================================================================
   Section: "¿Todavía no estás lista?" (Dark Pink Neon Theme)
   Follows Section-Todavía.jpg
   ========================================================================== */
.todavia-section {
  position: relative;
  width: 100%;
  background-color: #0b0711;
  background-image: 
    radial-gradient(ellipse 60% 45% at 72% 8%, rgba(212, 20, 90, 0.4) 0%, rgba(11, 7, 17, 0) 70%),
    radial-gradient(ellipse 50% 50% at 20% 90%, rgba(181, 13, 72, 0.35) 0%, rgba(11, 7, 17, 0) 70%),
    linear-gradient(90deg, #170E1F 0%, #120A17 35%, #0B0811 70%, #0A0911 100%);
  padding: 50px 0 65px 0;
  overflow: hidden;
  color: #ffffff;
  font-family: inherit;
}

.todavia-container {
  width: 100%;
  max-width: 1320px;
  margin-left: auto;
  margin-right: auto;
  padding-left: 28px;
  padding-right: 28px;
  box-sizing: border-box;
}

.todavia-grid {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: space-between;
  gap: 40px;
}

/* Left Column: Mockup Image */
.todavia-media-col {
  flex: 0 0 44%;
  max-width: 550px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.todavia-image-wrap {
  width: 100%;
  position: relative;
  display: flex;
  justify-content: center;
}

.todavia-mockup-img {
  width: 100%;
  height: auto;
  max-height: 590px;
  object-fit: contain;
  display: block;
  filter: drop-shadow(0 15px 35px rgba(0, 0, 0, 0.5));
}

/* Right Column: Content */
.todavia-content-col {
  flex: 1 1 56%;
  min-width: 0;
  display: flex;
  flex-direction: column;
}

/* Top Pill Badge */
.todavia-badge-wrap {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 24px;
  width: 100%;
}

.todavia-glow-line {
  position: absolute;
  top: 50%;
  left: -20px;
  right: -20px;
  height: 1.5px;
  background: linear-gradient(90deg, 
    rgba(255, 45, 122, 0) 0%, 
    rgba(255, 45, 122, 0.4) 15%, 
    rgba(255, 120, 180, 0.95) 50%, 
    rgba(255, 45, 122, 0.4) 85%, 
    rgba(255, 45, 122, 0) 100%);
  box-shadow: 0 0 12px rgba(255, 45, 122, 0.8), 0 0 4px rgba(255, 200, 220, 0.9);
  transform: translateY(-50%);
  pointer-events: none;
  z-index: 1;
}

.todavia-badge {
  position: relative;
  z-index: 2;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: linear-gradient(90deg, #A80A3B 0%, #D8145C 50%, #A80A3B 100%);
  border: 1.2px solid rgba(255, 120, 175, 0.65);
  box-shadow: 0 0 18px rgba(216, 20, 92, 0.65);
  border-radius: 9999px;
  padding: 7px 28px;
  font-size: 13.5px;
  font-weight: 700;
  letter-spacing: 0.16em;
  color: #FFFFFF;
  text-transform: uppercase;
  white-space: nowrap;
}

.todavia-badge-dot {
  font-weight: 900;
  opacity: 0.9;
}

/* Heading */
.todavia-section .todavia-heading {
  font-size: 50px !important;
  line-height: 1.05 !important;
  font-weight: 800 !important;
  letter-spacing: -0.02em !important;
  margin: 0 0 16px 0 !important;
  display: flex !important;
  flex-direction: column !important;
  font-family: inherit !important;
}

.todavia-section .todavia-heading-white {
  color: #FFFFFF !important;
  font-weight: 800 !important;
}

.todavia-section .todavia-heading-pink {
  color: #FF1E6C !important;
  letter-spacing: -0.015em !important;
  font-weight: 800 !important;
}

/* Subtitle */
.todavia-section .todavia-subtext {
  font-size: 16.5px !important;
  line-height: 1.45 !important;
  color: #FFFFFF !important;
  margin: 0 0 22px 0 !important;
  max-width: 620px;
  font-weight: 400 !important;
  opacity: 0.96;
}

/* Checklist */
.todavia-section .todavia-checklist {
  list-style: none !important;
  margin: 0 0 24px 0 !important;
  padding: 0 !important;
  display: flex !important;
  flex-direction: column !important;
  gap: 10px !important;
}

.todavia-section .todavia-checklist li {
  display: flex !important;
  align-items: center !important;
  gap: 12px !important;
  font-size: 16.5px !important;
  line-height: 1.35 !important;
  color: #FFFFFF !important;
  font-weight: 400 !important;
}

.todavia-chk-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  width: 20px;
  height: 16px;
}

.todavia-chk-icon svg {
  width: 18px;
  height: 14px;
  filter: drop-shadow(0 0 4px rgba(255, 30, 108, 0.6));
}

/* Bonus Box */
.todavia-bonus-box {
  position: relative;
  display: flex;
  align-items: center;
  gap: 18px;
  background: linear-gradient(135deg, rgba(80, 10, 44, 0.45) 0%, rgba(20, 6, 22, 0.8) 100%);
  border: 1.5px solid #FF2D7A;
  border-radius: 18px;
  padding: 16px 22px;
  margin-bottom: 24px;
  box-shadow: 0 0 22px rgba(255, 45, 122, 0.35), inset 0 0 16px rgba(255, 45, 122, 0.12);
}

.todavia-bonus-tv {
  flex-shrink: 0;
  width: 48px;
  height: 48px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.todavia-bonus-tv svg {
  width: 46px;
  height: 46px;
  filter: drop-shadow(0 0 6px rgba(255, 45, 122, 0.6));
}

.todavia-bonus-divider {
  width: 1px;
  align-self: stretch;
  background: linear-gradient(180deg, rgba(255, 45, 122, 0.1) 0%, rgba(255, 45, 122, 0.6) 50%, rgba(255, 45, 122, 0.1) 100%);
  flex-shrink: 0;
}

.todavia-bonus-body {
  flex: 1 1 auto;
  min-width: 0;
}

.todavia-bonus-head {
  display: flex;
  flex-wrap: wrap;
  align-items: baseline;
  gap: 6px;
  margin-bottom: 2px;
}

.todavia-bonus-tag {
  color: #FFE64E !important;
  font-size: 16.5px !important;
  font-weight: 800 !important;
  letter-spacing: 0.03em;
  text-shadow: 0 0 10px rgba(255, 230, 78, 0.4);
}

.todavia-bonus-title {
  color: #FFFFFF !important;
  font-size: 16.5px !important;
  font-weight: 700 !important;
}

.todavia-bonus-speaker {
  color: #FFFFFF !important;
  font-size: 16px !important;
  font-weight: 700 !important;
  margin-bottom: 4px;
}

.todavia-bonus-desc {
  color: #FFFFFF !important;
  font-size: 13px !important;
  line-height: 1.45 !important;
  margin: 0 !important;
  opacity: 0.94 !important;
}

.todavia-bonus-flask {
  flex-shrink: 0;
  width: 52px;
  height: 52px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.todavia-bonus-flask svg {
  width: 50px;
  height: 50px;
  filter: drop-shadow(0 0 8px rgba(255, 45, 122, 0.7));
}

/* Form Styles */
.todavia-form-wrap {
  width: 100%;
}

.todavia-gform {
  display: flex;
  flex-direction: column;
  gap: 14px;
  width: 100%;
}

.todavia-inputs-row {
  display: flex;
  flex-direction: row;
  gap: 16px;
  width: 100%;
}

.todavia-input-group {
  position: relative;
  flex: 1 1 50%;
  display: flex;
  align-items: center;
}

.todavia-input-icon {
  position: absolute;
  left: 20px;
  top: 50%;
  transform: translateY(-50%);
  width: 18px;
  height: 18px;
  color: #6E7178;
  display: flex;
  align-items: center;
  justify-content: center;
  pointer-events: none;
  z-index: 2;
}

.todavia-input-icon svg {
  width: 17px;
  height: 17px;
  fill: currentColor;
}

.todavia-input {
  width: 100%;
  height: 52px;
  background-color: #FFFFFF !important;
  border: 1px solid #E0E0E0 !important;
  border-radius: 9999px !important;
  padding: 0 20px 0 48px !important;
  font-size: 15.5px !important;
  color: #1A1A1A !important;
  outline: none;
  box-sizing: border-box;
  transition: border-color 0.2s ease, box-shadow 0.2s ease;
  font-family: inherit;
}

.todavia-input::placeholder {
  color: #7A7E85;
  opacity: 1;
}

.todavia-input:focus {
  border-color: #FF1E6C !important;
  box-shadow: 0 0 0 3px rgba(255, 30, 108, 0.25) !important;
}

.todavia-submit-btn {
  width: 100%;
  height: 56px;
  background: linear-gradient(180deg, #FF2E74 0%, #E6125A 50%, #B80A40 100%) !important;
  border: none !important;
  border-radius: 9999px !important;
  color: #FFFFFF !important;
  font-size: 18px !important;
  font-weight: 700 !important;
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  gap: 14px !important;
  cursor: pointer;
  box-shadow: 0 6px 25px rgba(255, 30, 100, 0.45) !important;
  transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease;
  padding: 0 28px !important;
  box-sizing: border-box;
  font-family: inherit;
}

.todavia-submit-btn:hover {
  transform: translateY(-1px);
  filter: brightness(1.06);
  box-shadow: 0 8px 30px rgba(255, 30, 100, 0.55) !important;
}

.todavia-submit-btn:active {
  transform: translateY(1px);
  box-shadow: 0 3px 12px rgba(255, 30, 100, 0.4) !important;
}

.todavia-btn-text {
  font-size: 18px !important;
  font-weight: 700 !important;
  letter-spacing: 0.01em;
}

.todavia-btn-arrow {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 22px;
  height: 22px;
}

.todavia-btn-arrow svg {
  width: 20px;
  height: 20px;
}

/* Responsive adjustments */
@media only screen and (max-width: 991px) {
  .todavia-grid {
    flex-direction: column;
    gap: 36px;
    text-align: center;
  }

  .todavia-media-col {
    max-width: 460px;
    margin: 0 auto;
  }

  .todavia-content-col {
    width: 100%;
    align-items: center;
  }

  .todavia-section .todavia-heading {
    font-size: 38px !important;
    text-align: center;
  }

  .todavia-section .todavia-subtext {
    text-align: center;
  }

  .todavia-section .todavia-checklist {
    text-align: left;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
  }

  .todavia-bonus-box {
    text-align: left;
    max-width: 540px;
  }

  .todavia-form-wrap {
    max-width: 540px;
    margin-left: auto;
    margin-right: auto;
  }
}

@media only screen and (max-width: 640px) {
  .todavia-section {
    padding: 40px 0 50px 0;
  }

  .todavia-container {
    padding-left: 16px;
    padding-right: 16px;
  }

  .todavia-section .todavia-heading {
    font-size: 30px !important;
    line-height: 1.12 !important;
  }

  .todavia-section .todavia-subtext {
    font-size: 15px !important;
  }

  .todavia-section .todavia-checklist li {
    font-size: 14.5px !important;
  }

  .todavia-bonus-box {
    flex-direction: column;
    align-items: flex-start;
    padding: 16px;
    gap: 12px;
  }

  .todavia-bonus-divider {
    display: none;
  }

  .todavia-bonus-flask {
    align-self: flex-end;
    margin-top: -32px;
  }

  .todavia-inputs-row {
    flex-direction: column;
    gap: 12px;
  }

  .todavia-submit-btn {
    font-size: 16px !important;
    height: 52px;
    padding: 0 16px !important;
  }

  .todavia-badge {
    font-size: 11.5px;
    padding: 6px 18px;
  }
}
`;

s = s.substring(0, idx) + newCss;
fs.writeFileSync('30beta/style.css', s, 'utf8');
console.log('Successfully updated 30beta/style.css!');
