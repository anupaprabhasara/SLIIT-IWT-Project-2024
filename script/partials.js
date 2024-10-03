const menuBtn = document.getElementById("menu-btn");
const navLinks = document.getElementById("nav-links");
const menuBtnIcon = menuBtn.querySelector("i");

menuBtn.addEventListener("click", (e) => {
  navLinks.classList.toggle("open");

  const isOpen = navLinks.classList.contains("open");
  menuBtnIcon.setAttribute("class", isOpen ? "ri-close-line" : "ri-menu-line");
});

navLinks.addEventListener("click", (e) => {
  navLinks.classList.remove("open");
  menuBtnIcon.setAttribute("class", "ri-menu-line");
});

const scrollRevealOption = {
  distance: "50px",
  origin: "bottom",
  duration: 500,
};

ScrollReveal().reveal(".header__image img", {
  ...scrollRevealOption,
  origin: "right",
  afterReveal: function (el) {
    el.style.transform = "none";  // Disable transforms to test
  }
});

ScrollReveal().reveal(".header__tag", {
  ...scrollRevealOption,
  delay: 100,
});
ScrollReveal().reveal(".header__content h1", {
  ...scrollRevealOption,
  delay: 200,
});
ScrollReveal().reveal(".header__content .section__description", {
  ...scrollRevealOption,
  delay: 300,
});
ScrollReveal().reveal(".header__btns", {
  ...scrollRevealOption,
  delay: 400,
});

ScrollReveal().reveal(".service__card", {
  ...scrollRevealOption,
  interval: 100,
});

const swiper = new Swiper(".swiper", {
  slidesPerView: "auto",
  spaceBetween: 30,
});

ScrollReveal().reveal(".client__image img", {
  ...scrollRevealOption,
  origin: "left",
});
ScrollReveal().reveal(".client__content .section__subheader", {
  ...scrollRevealOption,
  delay: 100,
});
ScrollReveal().reveal(".client__content .section__header", {
  ...scrollRevealOption,
  delay: 200,
});
ScrollReveal().reveal(".client__content .section__description", {
  ...scrollRevealOption,
  delay: 300,
});
ScrollReveal().reveal(".client__details", {
  ...scrollRevealOption,
  delay: 400,
});
ScrollReveal().reveal(".client__rating", {
  ...scrollRevealOption,
  delay: 500,
});

ScrollReveal().reveal(".download__image img", {
  ...scrollRevealOption,
  origin: "right",
});
ScrollReveal().reveal(".download__content .section__subheader", {
  ...scrollRevealOption,
  delay: 100,
});
ScrollReveal().reveal(".download__content .section__header", {
  ...scrollRevealOption,
  delay: 200,
});
ScrollReveal().reveal(".download__content .section__description", {
  ...scrollRevealOption,
  delay: 300,
});
ScrollReveal().reveal(".download__btn", {
  ...scrollRevealOption,
  delay: 400,
});