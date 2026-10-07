(function () {
  var btn = document.querySelector('.hd__sp-menu');
  var drawer = document.querySelector('.drawer');
  if (btn && drawer) {
    var openDrawer = function () {
      drawer.classList.add('is-open');
      btn.setAttribute('aria-expanded', 'true');
      document.documentElement.classList.add('is-drawer-open');
      var c = drawer.querySelector('.drawer__close');
      if (c) setTimeout(function () { c.focus(); }, 50);
    };
    var closeDrawer = function () {
      if (!drawer.classList.contains('is-open')) return;
      drawer.classList.remove('is-open');
      btn.setAttribute('aria-expanded', 'false');
      btn.focus();
      document.documentElement.classList.remove('is-drawer-open');
    };
    btn.addEventListener('click', openDrawer);
    drawer.addEventListener('click', function (e) {
      if (e.target === drawer || e.target.closest('.drawer__close')) closeDrawer();
    });
    drawer.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') { closeDrawer(); return; }
      if (e.key !== 'Tab') return;
      var f = Array.prototype.filter.call(drawer.querySelectorAll('a[href],button,select,input,[tabindex]:not([tabindex="-1"])'), function (el) {
        return el.getClientRects().length;
      });
      if (!f.length) return;
      var first = f[0], last = f[f.length - 1];
      if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
      else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
    });
  }

  document.querySelectorAll('.drawer__acc-btn').forEach(function (b) {
    b.addEventListener('click', function () {
      var open = b.getAttribute('aria-expanded') === 'true';
      b.setAttribute('aria-expanded', open ? 'false' : 'true');
      var sub = document.getElementById(b.getAttribute('aria-controls'));
      if (sub) sub.hidden = open;
    });
  });

  var KEY = 'fr_a11y';
  var html = document.documentElement;
  var state = {};
  try { state = JSON.parse(localStorage.getItem(KEY) || '{}') || {}; } catch (e) { state = {}; }
  if (localStorage.getItem('fureasuMono') === '1') state.mono = true;

  function save() {
    try {
      localStorage.setItem(KEY, JSON.stringify(state));
      localStorage.setItem('fureasuMono', state.mono ? '1' : '0');
    } catch (e) {}
  }
  function apply() {
    if (state.mono) html.setAttribute('data-a11y-mono', '1');
    else html.removeAttribute('data-a11y-mono');
    document.querySelectorAll('button[data-a11y-mono]').forEach(function (b) {
      b.setAttribute('aria-pressed', state.mono ? 'true' : 'false');
      var st = b.querySelector('[data-a11y-state]');
      if (st) st.textContent = state.mono ? 'ON' : 'OFF';
    });
  }
  document.addEventListener('click', function (e) {
    var t = e.target.closest && e.target.closest('button[data-a11y-mono]');
    if (!t) return;
    state.mono = !state.mono;
    save();
    apply();
  });
  apply();

  var ui = document.querySelector('.fixed-ui');
  var tabs = ui && ui.querySelector('.vtabs');
  if (ui && tabs) {
    var fit = function () {
      if (window.innerWidth < 768) { ui.style.removeProperty('--fk'); return; }
      ui.style.setProperty('--fk', '1');
      var bottom = tabs.offsetTop + tabs.offsetHeight;
      var k = Math.min(1, Math.max(0.6, (window.innerHeight - 8) / bottom));
      ui.style.setProperty('--fk', k.toFixed(4));
    };
    fit();
    window.addEventListener('resize', fit);
    window.addEventListener('load', fit);
  }
})();
