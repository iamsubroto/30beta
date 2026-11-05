const fs = require('fs');
let s = fs.readFileSync('30beta/style.css', 'utf8');

const marker = '/* Form Styles */';
const idx = s.indexOf(marker);
if (idx === -1) {
  console.error("Marker '/* Form Styles */' not found!");
  process.exit(1);
}

const newFormCss = `/* Form Styles */
.todavia-form-wrap {
  width: 100% !important;
  max-width: 100% !important;
}

.todavia-form-wrap .sj-glead,
.todavia-section .sj-glead {
  width: 100% !important;
  max-width: 100% !important;
}

.todavia-section .sj-gclose .sj-gform,
.todavia-section .sj-gform,
.todavia-gform {
  display: flex !important;
  flex-direction: column !important;
  gap: 16px !important;
  width: 100% !important;
  max-width: 100% !important;
  margin: 0 !important;
  box-sizing: border-box !important;
}

.todavia-inputs-row {
  display: flex !important;
  flex-direction: row !important;
  gap: 16px !important;
  width: 100% !important;
  max-width: 100% !important;
  box-sizing: border-box !important;
}

.todavia-input-group {
  position: relative !important;
  flex: 1 1 calc(50% - 8px) !important;
  width: calc(50% - 8px) !important;
  min-width: 0 !important;
  display: flex !important;
  align-items: center !important;
  box-sizing: border-box !important;
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
  width: 100% !important;
  height: 54px !important;
  background-color: #FFFFFF !important;
  border: 1px solid #E0E0E0 !important;
  border-radius: 9999px !important;
  padding: 0 20px 0 50px !important;
  font-size: 16px !important;
  color: #1A1A1A !important;
  outline: none !important;
  box-sizing: border-box !important;
  transition: border-color 0.2s ease, box-shadow 0.2s ease;
  font-family: inherit;
}

.todavia-input::placeholder {
  color: #7A7E85 !important;
  opacity: 1 !important;
}

.todavia-input:focus {
  border-color: #FF1E6C !important;
  box-shadow: 0 0 0 3px rgba(255, 30, 108, 0.25) !important;
}

.todavia-submit-btn {
  width: 100% !important;
  max-width: 100% !important;
  height: 56px !important;
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
  cursor: pointer !important;
  box-shadow: 0 6px 25px rgba(255, 30, 100, 0.45) !important;
  transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease;
  padding: 0 28px !important;
  box-sizing: border-box !important;
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
    width: 100% !important;
  }

  .todavia-form-wrap {
    max-width: 540px !important;
    width: 100% !important;
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
    flex-direction: column !important;
    gap: 12px !important;
  }

  .todavia-input-group {
    width: 100% !important;
    flex: 1 1 100% !important;
  }

  .todavia-submit-btn {
    font-size: 16px !important;
    height: 52px !important;
    padding: 0 16px !important;
  }

  .todavia-badge {
    font-size: 11.5px;
    padding: 6px 18px;
  }
}
`;

s = s.substring(0, idx) + newFormCss;
fs.writeFileSync('30beta/style.css', s, 'utf8');
console.log('Successfully updated 30beta/style.css with full-width row form styles!');
