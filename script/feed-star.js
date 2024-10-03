// by Visna

const stars = document.querySelectorAll(".stars i");
            stars.forEach((star, index1) => {
            star.addEventListener("click", () => {
        stars.forEach((star, index2) => {
            if (index2 <= index1) {
                star.classList.add("active");
            } else {
                star.classList.remove("active");
            }
        });
    });
});