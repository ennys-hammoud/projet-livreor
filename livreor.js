document.addEventListener("DOMContentLoaded", function() {
    // Apparition au chargement (Fade In)
    const elements = document.querySelectorAll(".container, header, nav, footer, .image-banniere");

    elements.forEach((element) => {
        element.style.opacity = 0;
        element.style.transform = "translateY(20px)";
        setTimeout(() => {
            element.style.transition = "opacity 1s ease-out, transform 1s ease-out";
            element.style.opacity = 1;
            element.style.transform = "translateY(0)";
        }, 300);
    });

    // Parallax sur l'image de la bannière
    const banniereImage = document.querySelector(".image-banniere img");
    if (banniereImage) {
        window.addEventListener('scroll', function() {
            const scrollPos = window.scrollY;
            banniereImage.style.transform = 'translateY(' + scrollPos * 0.3 + 'px)';
        });
    }

    // Apparition progressive des paragraphes au défilement
    window.addEventListener("scroll", function() {
        const paragraphs = document.querySelectorAll("main p");
        paragraphs.forEach((p) => {
            const position = p.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;

            if (position < windowHeight - 50) {
                p.style.opacity = 1;
                p.style.transform = "translateY(0)";
                p.style.transition = "opacity 1s ease-out, transform 1s ease-out";
            }
        });
    });
});
