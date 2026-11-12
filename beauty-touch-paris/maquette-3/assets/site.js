/* Inkway — comportements communs des sites standards (sans dépendance) */
(function () {
  "use strict";
  var $ = function (s, r) { return (r || document).querySelector(s); };
  var $$ = function (s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); };
  var DAYS = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];

  /* Navigation mobile + en-tête au défilement */
  $$("[data-nav-toggle]").forEach(function (b) {
    b.addEventListener("click", function () {
      var open = document.body.classList.toggle("nav-open");
      b.setAttribute("aria-expanded", open ? "true" : "false");
    });
  });
  $$(".nav a[href^='#'], [data-close-nav]").forEach(function (a) {
    a.addEventListener("click", function () { document.body.classList.remove("nav-open"); });
  });
  var header = $("[data-header]");
  var onScroll = function () {
    if (header) header.classList.toggle("scrolled", window.scrollY > 40);
    var top = $("[data-totop]");
    if (top) top.classList.toggle("show", window.scrollY > 700);
  };
  window.addEventListener("scroll", onScroll, { passive: true });
  onScroll();
  $$("[data-totop]").forEach(function (b) { b.addEventListener("click", function () { window.scrollTo({ top: 0, behavior: "smooth" }); }); });

  /* Apparition au défilement */
  if ("IntersectionObserver" in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add("in"); io.unobserve(e.target); } });
    }, { threshold: 0.12, rootMargin: "0px 0px -40px 0px" });
    $$("[data-reveal]").forEach(function (el, i) {
      el.style.transitionDelay = (el.dataset.delay || (i % 4) * 70) + "ms";
      io.observe(el);
    });
  } else $$("[data-reveal]").forEach(function (el) { el.classList.add("in"); });

  /* Compteurs */
  $$("[data-count]").forEach(function (el) {
    var end = parseFloat(el.dataset.count), done = false;
    var run = function () {
      if (done) return; done = true;
      var t0 = performance.now();
      var step = function (t) {
        var p = Math.min(1, (t - t0) / 1400);
        el.textContent = Math.round(end * (1 - Math.pow(1 - p, 3))).toLocaleString("fr-FR");
        if (p < 1) requestAnimationFrame(step);
      };
      requestAnimationFrame(step);
    };
    if ("IntersectionObserver" in window) new IntersectionObserver(function (e, o) { if (e[0].isIntersecting) { run(); o.disconnect(); } }).observe(el);
    else run();
  });

  /* Onglets */
  $$("[data-tabs]").forEach(function (box) {
    var btns = $$("[data-tab]", box), panels = $$("[data-panel]", box);
    btns.forEach(function (b) {
      b.addEventListener("click", function () {
        btns.forEach(function (x) { x.classList.toggle("active", x === b); x.setAttribute("aria-selected", x === b ? "true" : "false"); });
        panels.forEach(function (p) { p.hidden = p.dataset.panel !== b.dataset.tab; });
      });
    });
  });

  /* Filtres (galerie, carte de soins) */
  $$("[data-filter-group]").forEach(function (box) {
    var scope = box.dataset.filterGroup ? $(box.dataset.filterGroup) : box.parentElement;
    $$("[data-filter]", box).forEach(function (b) {
      b.addEventListener("click", function () {
        $$("[data-filter]", box).forEach(function (x) { x.classList.toggle("active", x === b); });
        $$("[data-cat]", scope).forEach(function (it) {
          var show = b.dataset.filter === "all" || it.dataset.cat.split(" ").indexOf(b.dataset.filter) > -1;
          it.classList.toggle("is-hidden", !show);
        });
      });
    });
  });

  /* Visionneuse */
  var lb;
  $$("[data-lightbox]").forEach(function (a, i, all) {
    a.addEventListener("click", function (ev) {
      ev.preventDefault();
      if (!lb) {
        lb = document.createElement("div");
        lb.className = "iw-lightbox";
        lb.innerHTML = '<button class="iw-lb-close" aria-label="Fermer">×</button><button class="iw-lb-prev" aria-label="Précédent">‹</button><figure><img alt=""><figcaption></figcaption></figure><button class="iw-lb-next" aria-label="Suivant">›</button>';
        document.body.appendChild(lb);
        lb.addEventListener("click", function (e) { if (e.target === lb || e.target.classList.contains("iw-lb-close")) lb.classList.remove("open"); });
        document.addEventListener("keydown", function (e) {
          if (!lb.classList.contains("open")) return;
          if (e.key === "Escape") lb.classList.remove("open");
          if (e.key === "ArrowRight") $(".iw-lb-next", lb).click();
          if (e.key === "ArrowLeft") $(".iw-lb-prev", lb).click();
        });
      }
      var idx = i;
      var show = function (n) {
        idx = (n + all.length) % all.length;
        $("img", lb).src = all[idx].getAttribute("href");
        $("figcaption", lb).textContent = all[idx].dataset.caption || "";
      };
      $(".iw-lb-prev", lb).onclick = function () { show(idx - 1); };
      $(".iw-lb-next", lb).onclick = function () { show(idx + 1); };
      show(i);
      lb.classList.add("open");
    });
  });

  /* Carrousel (avis, rituels) */
  $$("[data-slider]").forEach(function (sl) {
    var track = $("[data-track]", sl) || sl, slides = $$(".slide", track), i = 0;
    var dots = $("[data-dots]", sl);
    if (dots) slides.forEach(function (_, n) {
      var d = document.createElement("button");
      d.setAttribute("aria-label", "Aller à " + (n + 1));
      d.addEventListener("click", function () { go(n); reset(); });
      dots.appendChild(d);
    });
    var go = function (n) {
      i = (n + slides.length) % slides.length;
      slides.forEach(function (s, k) { s.classList.toggle("active", k === i); });
      if (dots) $$("button", dots).forEach(function (d, k) { d.classList.toggle("active", k === i); });
    };
    var timer, reset = function () { clearInterval(timer); timer = setInterval(function () { go(i + 1); }, 6000); };
    $$("[data-prev]", sl).forEach(function (b) { b.addEventListener("click", function () { go(i - 1); reset(); }); });
    $$("[data-next]", sl).forEach(function (b) { b.addEventListener("click", function () { go(i + 1); reset(); }); });
    go(0); reset();
  });

  /* Horaires : statut ouvert/fermé + ligne du jour */
  var parseHours = function (el) { try { return JSON.parse(el.dataset.hours); } catch (e) { return null; } };
  var hoursSrc = $("[data-hours]");
  var HOURS = hoursSrc ? parseHours(hoursSrc) : null;
  var toMin = function (s) { var p = s.split(":"); return +p[0] * 60 + +p[1]; };
  var fmt = function (s) { return s.replace(":00", "h").replace(":", "h"); };
  if (HOURS) {
    var now = new Date(), d = now.getDay(), m = now.getHours() * 60 + now.getMinutes();
    var today = HOURS[d], label;
    if (today && m >= toMin(today[0]) && m < toMin(today[1])) label = '<i class="dot on"></i>Ouvert maintenant · jusqu’à ' + fmt(today[1]);
    else {
      var k = 0, nd = d, nh;
      if (today && m < toMin(today[0])) nh = today;
      else { do { nd = (nd + 1) % 7; k++; } while (!HOURS[nd] && k < 7); nh = HOURS[nd]; }
      label = '<i class="dot"></i>Fermé · ouvre ' + (nh === today ? "aujourd’hui" : k === 1 ? "demain" : DAYS[nd].toLowerCase()) + " à " + fmt(nh[0]);
    }
    $$("[data-open-status]").forEach(function (el) { el.innerHTML = label; });
    $$("[data-day]").forEach(function (el) { el.classList.toggle("today", +el.dataset.day === d); });
  }

  /* Prise de rendez-vous */
  $$("form[data-booking]").forEach(function (form) {
    var hours = parseHours(form) || HOURS || {};
    var step = +(form.dataset.step || 30);
    var date = form.elements.date, time = form.elements.time;
    if (date) {
      var t = new Date(); t.setMinutes(t.getMinutes() - t.getTimezoneOffset());
      date.min = t.toISOString().slice(0, 10);
      var max = new Date(t); max.setDate(max.getDate() + 60);
      date.max = max.toISOString().slice(0, 10);
    }
    var fill = function () {
      if (!time || !date) return;
      time.innerHTML = "";
      if (!date.value) { time.innerHTML = "<option value=''>Choisissez d’abord une date</option>"; return; }
      var dd = new Date(date.value + "T12:00:00"), h = hours[dd.getDay()];
      if (!h) { time.innerHTML = "<option value=''>Fermé ce jour-là</option>"; return; }
      var nowM = new Date(), isToday = date.value === date.min, cur = nowM.getHours() * 60 + nowM.getMinutes() + 30;
      var opts = "<option value=''>Choisir un créneau</option>", n = 0;
      for (var x = toMin(h[0]); x <= toMin(h[1]) - 30; x += step) {
        if (isToday && x < cur) continue;
        var lab = String(Math.floor(x / 60)).padStart(2, "0") + ":" + String(x % 60).padStart(2, "0");
        opts += "<option>" + lab + "</option>"; n++;
      }
      time.innerHTML = n ? opts : "<option value=''>Plus de créneau aujourd’hui</option>";
    };
    if (date) date.addEventListener("change", fill);
    fill();
    $$("[data-book]").forEach(function (b) {
      b.addEventListener("click", function () {
        var sel = form.elements.service;
        if (!sel) return;
        if (sel.tagName === "SELECT") sel.value = b.dataset.book;
        else $$("input[name=service]", form).forEach(function (r) { r.checked = r.value === b.dataset.book; });
        form.dispatchEvent(new Event("change"));
      });
    });

    /* Étapes */
    var steps = $$("[data-step-panel]", form), cur = 0;
    var showStep = function (n) {
      cur = n;
      steps.forEach(function (s, k) { s.hidden = k !== n; });
      $$("[data-step-dot]", form).forEach(function (s, k) { s.classList.toggle("active", k <= n); });
    };
    var validStep = function (panel) {
      var ok = true;
      $$("input,select,textarea", panel).forEach(function (f) { if (!f.checkValidity()) { ok = false; f.reportValidity(); } });
      return ok;
    };
    $$("[data-step-next]", form).forEach(function (b) { b.addEventListener("click", function () { if (validStep(steps[cur])) showStep(cur + 1); }); });
    $$("[data-step-prev]", form).forEach(function (b) { b.addEventListener("click", function () { showStep(cur - 1); }); });
    if (steps.length) showStep(0);

    var summary = function () {
      var v = function (n) { var f = form.elements[n]; return f ? (f.value || "").trim() : ""; };
      var d = v("date") ? new Date(v("date") + "T12:00:00").toLocaleDateString("fr-FR", { weekday: "long", day: "numeric", month: "long" }) : "";
      $$("[data-sum]", form.parentElement).forEach(function (el) {
        var k = el.dataset.sum; el.textContent = k === "date" ? d : v(k) || "—";
      });
      return { service: v("service"), date: d, time: v("time"), name: v("name"), phone: v("phone"), note: v("note") };
    };
    form.addEventListener("change", summary);
    form.addEventListener("submit", function (ev) {
      ev.preventDefault();
      if (!form.checkValidity()) { form.reportValidity(); return; }
      var s = summary();
      var msg = "Bonjour " + (form.dataset.salon || "") + ", je souhaite un rendez-vous :\n• Prestation : " + s.service +
        "\n• Date : " + s.date + " à " + s.time + "\n• Nom : " + s.name + "\n• Téléphone : " + s.phone + (s.note ? "\n• Précision : " + s.note : "") +
        "\nMerci de me confirmer le créneau.";
      var out = $("[data-booking-result]", form.parentElement) || $("[data-booking-result]");
      var wa = form.dataset.whatsapp ? "https://wa.me/" + form.dataset.whatsapp + "?text=" + encodeURIComponent(msg) : "";
      if (out) {
        out.hidden = false;
        out.innerHTML = '<b>Demande prête ✓</b><p>' + s.service + " · " + s.date + " à " + s.time + "</p>" +
          (form.dataset.demo !== undefined
            ? "<p class='small'>Modèle de démonstration : aucune demande n’est envoyée. Sur le site du client, la demande part vers son WhatsApp ou son e-mail.</p>"
            : "<p class='small'>Votre demande s’ouvre dans WhatsApp. Le salon vous confirme le créneau en retour.</p>") +
          (wa && form.dataset.demo === undefined ? '<a class="btn" target="_blank" rel="noopener" href="' + wa + '">Envoyer sur WhatsApp</a>' : "");
        out.scrollIntoView({ behavior: "smooth", block: "nearest" });
      }
      if (wa && form.dataset.demo === undefined) window.open(wa, "_blank", "noopener");
    });
  });

  /* Carte de fidélité interactive */
  $$("[data-loyalty]").forEach(function (card) {
    var stamps = $$(".stamp", card), out = $("[data-loyalty-out]", card);
    stamps.forEach(function (s, i) {
      s.addEventListener("click", function () {
        stamps.forEach(function (x, k) { x.classList.toggle("on", k <= i); });
        var unit = card.dataset.unit || "coupe", left = 9 - (i + 1);
        if (out) out.textContent = i >= 9 ? "Cette " + unit + " est offerte !" : left === 0 ? "La prochaine " + unit + " est offerte !" :
          left + " " + unit + (left > 1 ? "s" : "") + " avant la " + unit + " offerte";
      });
    });
  });

  /* Année et badge de démonstration */
  $$("[data-year]").forEach(function (el) { el.textContent = new Date().getFullYear(); });
  if (document.body.hasAttribute("data-demo")) {
    var b = document.createElement("div");
    b.className = "iw-demo-badge";
    b.innerHTML = "Modèle standard <b>" + (document.body.dataset.demo || "") + "</b> · contenus de démonstration";
    document.body.appendChild(b);
  }
})();
