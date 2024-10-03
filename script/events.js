// by Visna

ScrollReveal({
    reset: false,
    distance: '60px',
    duration: 500,
    delay: 100,
    once: true
    });

ScrollReveal().reveal('.box1',{delay: 200, origin: 'right', afterReveal: function (el) {el.style.transform = "none"; } });
ScrollReveal().reveal('.heading',{delay: 100, origin: 'left', afterReveal: function (el) {el.style.transform = "none"; } });
ScrollReveal().reveal('.no-records',{delay: 100, origin: 'right', afterReveal: function (el) {el.style.transform = "none"; } });