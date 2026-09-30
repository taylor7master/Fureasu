!(function($) {
  "use strict";

  let vh = window.innerHeight * 0.01;
  let vw = window.innerWidth * 0.01;
  document.documentElement.style.setProperty('--vh', `${vh}px`);
  document.documentElement.style.setProperty('--vw', `${vw}px`);

  $(window).on('resize', function() {
    vh = window.innerHeight * 0.01;
    vw = window.innerWidth * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
    document.documentElement.style.setProperty('--vw', `${vw}px`);
  });

  // Toggle .header-scrolled
  $(window).scroll(function() {
    if ($(this).scrollTop() > 100) {
      $('#header').addClass('header-scrolled');
    } else {
      $('#header').removeClass('header-scrolled');
    }
  });

  if ($(window).scrollTop() > 100) {
    $('#header').addClass('header-scrolled');
  }

  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var isFinePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

  function getScrollOffset() {
    return $('#header').outerHeight() || 80;
  }

  function smoothScrollTo(top, durationSec) {
    durationSec = typeof durationSec === 'number' ? durationSec : 1.2;
    if (window.lenis && typeof window.lenis.scrollTo === 'function') {
      window.lenis.scrollTo(top, {
        duration: durationSec,
        lock: true
      });
      return;
    }
    $('html, body').animate({
      scrollTop: top
    }, Math.round(durationSec * 1000), 'swing');
  }

  // Smooth scroll (Lenis + in-page anchors)
  var scrolltoOffset = getScrollOffset();

  $(document).on('click', 'a.link, .scrollto, .nav-menu a, .mobile-nav-menu a, .footer-menu a', function(e) {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      if (target.length) {
        e.preventDefault();
        scrolltoOffset = getScrollOffset();
        var scrollto = target.offset().top - scrolltoOffset;

        if ($(this).attr("href") == '#header') {
          scrollto = 0;
        }

        if ($(this).hasClass('menu-link')) {
          $('.nav-menu .menu-link, .mobile-nav-menu .menu-link').removeClass('active');
          $(this).addClass('active');
        }

        smoothScrollTo(scrollto, 1.2);

        if ($('body').hasClass('mobile-nav-active')) {
          $('body').removeClass('mobile-nav-active');
          $('.mobile-nav-toggle').toggleClass('toggle-active');
          $('.mobile-nav-overly').fadeOut();
          if (window.lenis) {
            window.lenis.start();
          }
        }

        return false;
      }
    }
  });

  $(document).ready(function() {
    if (window.location.hash) {
      var initial_nav = window.location.hash;
      if ($(initial_nav).length) {
        scrolltoOffset = getScrollOffset();
        var scrollto = $(initial_nav).offset().top - scrolltoOffset;
        smoothScrollTo(scrollto, 1.2);
      }
    }
  });

  // Mobile Navigation
  $('body').prepend('<button type="button" class="mobile-nav-toggle" aria-label="メニュー"><span class="toggle-icon"><span></span><span></span><span></span></span></button>');
  $('body').append('<div class="mobile-nav-overly"></div>');

  $(document).on('click', '.mobile-nav-toggle', function(e) {
    $('body').toggleClass('mobile-nav-active');
    $('.mobile-nav-toggle').toggleClass('toggle-active');
    $('.mobile-nav-overly').toggle();
    if (window.lenis) {
      if ($('body').hasClass('mobile-nav-active')) {
        window.lenis.stop();
      } else {
        window.lenis.start();
      }
    }
  });

  $(document).click(function(e) {
    var container = $("#mobile-nav, .mobile-nav-toggle");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
      if ($('body').hasClass('mobile-nav-active')) {
        $('body').removeClass('mobile-nav-active');
        $('.mobile-nav-toggle').toggleClass('toggle-active');
        $('.mobile-nav-overly').fadeOut();
        if (window.lenis) {
          window.lenis.start();
        }
      }
    }
  });

  $(document).on('keydown', function(e) {
    if (e.key === 'Escape') {
      closeHoursPanel();
      if ($('body').hasClass('mobile-nav-active')) {
        $('body').removeClass('mobile-nav-active');
        $('.mobile-nav-toggle').removeClass('toggle-active');
        $('.mobile-nav-overly').fadeOut();
        if (window.lenis) {
          window.lenis.start();
        }
      }
    }
  });

  // Blog hover soft effect
  $('.blog-item').on('mouseenter', function() {
    $(this).css('opacity', '1').siblings().css('opacity', '0.55');
  }).on('mouseleave', function() {
    $('.blog-item').css('opacity', '1');
  });

  // FAQ accordion
  $(document).on('click', '.faq-item .question', function(e) {
    var answer = $(this).next();
    $(this).toggleClass('expanded');
    answer.slideToggle(400);
  });

  // Scroll hint
  if (typeof ScrollHint !== 'undefined') {
    new ScrollHint('.scroll-hint', {
      suggestiveShadow: true,
      remainingTime: 5000,
      i18n: {
        scrollable: 'スクロールできます',
      },
    });
  }

  // Lenis smooth scroll (tojiro.net / Luxy-like inertia)
  function initLenis() {
    if (reduceMotion || typeof Lenis === 'undefined') {
      return;
    }

    var lenis = new Lenis({
      duration: 1.4,
      easing: function(t) {
        return Math.min(1, 1.001 - Math.pow(2, -10 * t));
      },
      orientation: 'vertical',
      gestureOrientation: 'vertical',
      smoothWheel: true,
      wheelMultiplier: 0.9,
      touchMultiplier: 1.4,
      infinite: false
    });

    window.lenis = lenis;

    function raf(time) {
      lenis.raf(time);
      requestAnimationFrame(raf);
    }
    requestAnimationFrame(raf);
  }

  function loadLenis(callback) {
    if (typeof Lenis !== 'undefined') {
      callback();
      return;
    }
    var script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/lenis@1.1.20/dist/lenis.min.js';
    script.async = true;
    script.onload = callback;
    document.head.appendChild(script);
  }

  loadLenis(initLenis);

  // Custom mouse (dream-lab.work)
  function initMouse() {
    if (reduceMotion || !isFinePointer || window.innerWidth <= 768) {
      return;
    }

    if (!$('.js-mouse').length) {
      $('body').append('<div id="mouseBall" class="js-mouse"><div class="js-mouse__ball"></div></div>');
    }

    var $ball = $('.js-mouse__ball');
    var mouseX = window.innerWidth / 2;
    var mouseY = window.innerHeight / 2;
    var ballX = mouseX;
    var ballY = mouseY;
    var speed = 0.18;

    $(window).on('mousemove.fureasuMouse', function(e) {
      mouseX = e.clientX;
      mouseY = e.clientY;
      $('.js-mouse').removeClass('is-out');
    });

    $(document).on('mouseleave.fureasuMouse', function() {
      $('.js-mouse').addClass('is-out');
    }).on('mouseenter.fureasuMouse', function() {
      $('.js-mouse').removeClass('is-out');
    });

    $(document).on('mouseenter.fureasuMouse', 'a, button, .link-btn, .action-btn, .js-hover, input, textarea, select, .swiper-pagination-bullet, .mobile-nav-toggle', function() {
      $ball.addClass('is-hover');
    }).on('mouseleave.fureasuMouse', 'a, button, .link-btn, .action-btn, .js-hover, input, textarea, select, .swiper-pagination-bullet, .mobile-nav-toggle', function() {
      $ball.removeClass('is-hover');
    });

    function tick() {
      ballX += (mouseX - ballX) * speed;
      ballY += (mouseY - ballY) * speed;
      $ball.css('transform', 'translate3d(' + ballX + 'px, ' + ballY + 'px, 0)');
      requestAnimationFrame(tick);
    }
    requestAnimationFrame(tick);
  }

  initMouse();

  // Image cover reveal (daiwajyutaku.com)
  function initScrtCover() {
    var targets = document.querySelectorAll('.scrt-cover');
    if (!targets.length) {
      return;
    }

    function revealCover(el) {
      if (!el || el.classList.contains('visible')) {
        return true;
      }
      el.classList.add('visible');
      return true;
    }

    function shouldReveal(el) {
      var rect = el.getBoundingClientRect();
      if (rect.height <= 0) {
        return false;
      }
      return rect.top < window.innerHeight * 0.92;
    }

    function checkCovers() {
      Array.prototype.forEach.call(targets, function(el) {
        if (!el.classList.contains('visible') && shouldReveal(el)) {
          revealCover(el);
        }
      });
    }

    if (reduceMotion) {
      Array.prototype.forEach.call(targets, revealCover);
      return;
    }

    if (typeof IntersectionObserver !== 'undefined') {
      var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
          if (entry.isIntersecting) {
            revealCover(entry.target);
            observer.unobserve(entry.target);
          }
        });
      }, {
        threshold: 0.12,
        rootMargin: '0px 0px -6% 0px'
      });

      Array.prototype.forEach.call(targets, function(el) {
        observer.observe(el);
        var img = el.querySelector('img');
        if (img) {
          if (img.complete) {
            if (shouldReveal(el)) {
              revealCover(el);
            }
          } else {
            img.addEventListener('load', function() {
              if (shouldReveal(el)) {
                revealCover(el);
              }
            }, { once: true });
          }
        }
      });
    }

    $(window).on('scroll.scrtCover resize.scrtCover', checkCovers);
    checkCovers();
  }

  initScrtCover();

  // Voice index custom select (SP)
  function isVoiceIndexSp() {
    return window.matchMedia('(max-width: 768px)').matches;
  }

  function closeVoiceIndexs($except) {
    $('.voice-indexs').not($except || $()).removeClass('is-open');
  }

  $(document).on('click', '.voice-indexs .index-link', function(e) {
    if (!isVoiceIndexSp()) {
      return;
    }

    var $link = $(this);
    var $list = $link.closest('.voice-indexs');
    var isActive = $link.hasClass('active');
    var isOpen = $list.hasClass('is-open');
    var href = $link.attr('href');
    var hasUrl = href && href !== '' && href !== '#';

    if (!isOpen) {
      e.preventDefault();
      closeVoiceIndexs($list);
      $list.addClass('is-open');
      return;
    }

    if (isActive) {
      e.preventDefault();
      $list.removeClass('is-open');
      return;
    }

    $list.find('.index-link').removeClass('active');
    $link.addClass('active');
    $list.removeClass('is-open');

    if (!hasUrl) {
      e.preventDefault();
    }
  });

  $(document).on('click', function(e) {
    if (!$(e.target).closest('.voice-indexs').length) {
      closeVoiceIndexs();
    }
  });

  $(document).on('keydown', function(e) {
    if (e.key === 'Escape') {
      closeVoiceIndexs();
    }
  });

  $(window).on('resize', function() {
    if (!isVoiceIndexSp()) {
      closeVoiceIndexs();
    }
  });

  var monoKey = 'fureasuMono';

  function setMonoMode(on) {
    document.documentElement.classList.toggle('is-mono', on);
    $('.switch-color-btn')
      .toggleClass('is-active', on)
      .attr('aria-pressed', on ? 'true' : 'false')
      .find('em')
      .text(on ? 'ON' : 'OFF');
    try {
      localStorage.setItem(monoKey, on ? '1' : '0');
    } catch (e) {}
  }

  setMonoMode(document.documentElement.classList.contains('is-mono'));

  $(document).on('click', '.switch-color-btn', function() {
    setMonoMode(!document.documentElement.classList.contains('is-mono'));
  });

  $(document).on('click', '.search-zip-btn', function() {
    var zip = (($('#your-zip1').val() || '') + ($('#your-zip2').val() || '')).replace(/\D/g, '');
    if (zip.length !== 7) {
      alert('郵便番号を正しく入力してください');
      return;
    }
    $.getJSON('https://zipcloud.ibsnet.co.jp/api/search', { zipcode: zip })
      .done(function(res) {
        if (!res || !res.results || !res.results[0]) {
          return;
        }
        var row = res.results[0];
        $('#your-prefecture').val((row.address1 || '') + (row.address2 || '') + (row.address3 || ''));
      });
  });

})(jQuery);
