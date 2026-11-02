/* ============================================================
   CHATVIONIKO AFILIADOS — script.js (29beta)
   ============================================================ */

(function () {
  'use strict';

  /* ------ Header: scroll detection + mobile menu ------ */
  const header = document.querySelector('.site-header');
  const hamburger = document.querySelector('.hamburger');
  const mobileNav = document.querySelector('.mobile-nav');

  function updateHeader() {
    if (!header) return;
    header.classList.toggle('scrolled', window.scrollY > 12);
  }

  updateHeader();
  window.addEventListener('scroll', updateHeader, { passive: true });

  if (hamburger && mobileNav) {
    hamburger.addEventListener('click', function () {
      const isOpen = mobileNav.classList.toggle('open');
      hamburger.classList.toggle('active', isOpen);
      header.classList.toggle('menu-open', isOpen);
      hamburger.setAttribute('aria-expanded', String(isOpen));
    });

    // Close mobile nav when a link is clicked
    mobileNav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        mobileNav.classList.remove('open');
        hamburger.classList.remove('active');
        header.classList.remove('menu-open');
        hamburger.setAttribute('aria-expanded', 'false');
      });
    });
  }

  /* ------ Reveal on scroll (IntersectionObserver) ------ */
  var revealObserver = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          revealObserver.unobserve(entry.target);
        }
      });
    },
    { rootMargin: '0px 0px -12% 0px', threshold: 0.12 }
  );

  document.querySelectorAll('.reveal').forEach(function (el) {
    revealObserver.observe(el);
  });

  /* ------ Interactive Affiliate Commission Calculator ------ */
  const rangeInput = document.getElementById('affiliate-subscriptions');
  const numberInput = document.getElementById('affiliate-subscriptions-number');
  const resultDisplay = document.getElementById('calculator-potential-result');
  const breakdownDisplay = document.getElementById('calculator-breakdown-text');

  const launchPrice = 29;
  const directRate = 0.2;
  const commissionPerSubscription = launchPrice * directRate; // 5.80 USD

  function formatUsd(val) {
    return new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD',
      maximumFractionDigits: val % 1 === 0 ? 0 : 2,
    }).format(val);
  }

  function updateCalculator(subs) {
    var count = Math.max(1, parseInt(subs, 10) || 1);
    var potentialCommission = count * commissionPerSubscription;
    var formattedCommission = formatUsd(potentialCommission);
    var formattedPerSub = formatUsd(commissionPerSubscription);

    if (rangeInput && rangeInput.value != count) {
      rangeInput.value = Math.min(150, count);
    }
    if (numberInput && numberInput.value != count) {
      numberInput.value = count;
    }
    if (resultDisplay) {
      resultDisplay.textContent = formattedCommission;
    }
    if (breakdownDisplay) {
      breakdownDisplay.innerHTML =
        count +
        ' suscripciones x ' +
        formattedPerSub +
        ' = <span class="text-lime-glow">' +
        formattedCommission +
        '</span>';
    }
  }

  if (rangeInput) {
    rangeInput.addEventListener('input', function (e) {
      updateCalculator(e.target.value);
    });
  }

  if (numberInput) {
    numberInput.addEventListener('input', function (e) {
      updateCalculator(e.target.value);
    });
  }

  // Initial calculation on page load
  if (rangeInput || numberInput) {
    updateCalculator(rangeInput ? rangeInput.value : 25);
  }

  /* ------ Video Modal ------ */
  var modal = document.getElementById('video-modal');
  var modalVideo = document.getElementById('modal-video');
  var modalTitle = document.getElementById('modal-title');
  var modalClose = document.getElementById('modal-close');
  var lastFocused = null;

  function openModal(src, title) {
    if (!modal || !modalVideo) return;
    lastFocused = document.activeElement;
    modalTitle.textContent = title || '';

    // Remove media fragments like #t=0.001 for modal playback
    var cleanSrc = src ? src.split('#')[0] : '';
    modalVideo.src = cleanSrc;
    modalVideo.setAttribute('playsinline', '');
    modalVideo.setAttribute('webkit-playsinline', '');
    modalVideo.load();
    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
    setTimeout(function () { if (modalClose) modalClose.focus(); }, 50);
    document.addEventListener('keydown', onModalKeyDown);

    // Explicitly call play() within user gesture context for iOS Safari
    var playPromise = modalVideo.play();
    if (playPromise !== undefined) {
      playPromise.catch(function (err) {
        console.warn('Autoplay prevented or interrupted:', err);
      });
    }
  }

  function closeModal() {
    if (!modal || !modalVideo) return;
    modal.classList.remove('open');
    modalVideo.pause();
    modalVideo.removeAttribute('src');
    modalVideo.load();
    document.body.style.overflow = '';
    document.removeEventListener('keydown', onModalKeyDown);
    if (lastFocused && typeof lastFocused.focus === 'function') {
      lastFocused.focus();
    }
  }

  function onModalKeyDown(e) {
    if (e.key === 'Escape') closeModal();
  }

  if (modalClose) {
    modalClose.addEventListener('click', closeModal);
  }

  if (modal) {
    modal.addEventListener('click', function (e) {
      if (e.target === modal) closeModal();
    });
  }

  // Wire up all video preview buttons
  document.querySelectorAll('.video-preview[data-src]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      openModal(btn.dataset.src, btn.dataset.title || '');
    });
  });

  /* ------ Form Popup Modal Controller ------ */
  const formModal = document.getElementById('form-popup-modal');
  if (formModal) {
    // Force close on initial page load
    formModal.classList.remove('is-open');
    formModal.style.display = 'none';
    formModal.setAttribute('aria-hidden', 'true');

    const formOverlay = formModal.querySelector('.form-popup-overlay');
    const formCloseBtn = formModal.querySelector('.form-popup-close');
    const popupCtaButtons = document.querySelectorAll(
      '.btn-primary, a[href="https://chatvioniko.com"], .btn-trigger-popup, .header-cta a, .mobile-nav a.btn-primary, .video-section__cta-btn, a[href="#contact"]'
    );

    function openFormModal(e) {
      if (e) e.preventDefault();
      formModal.classList.add('is-open');
      formModal.style.display = 'flex';
      formModal.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
    }

    function closeFormModal(e) {
      if (e) e.preventDefault();
      formModal.classList.remove('is-open');
      formModal.style.display = 'none';
      formModal.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
    }

    popupCtaButtons.forEach(function (btn) {
      btn.addEventListener('click', openFormModal);
    });

    if (formCloseBtn) formCloseBtn.addEventListener('click', closeFormModal);
    if (formOverlay) formOverlay.addEventListener('click', closeFormModal);

    document.addEventListener('keydown', function (e) {
      if (
        e.key === 'Escape' &&
        (formModal.classList.contains('is-open') || formModal.style.display === 'flex')
      ) {
        closeFormModal();
      }
    });
  }
})();
