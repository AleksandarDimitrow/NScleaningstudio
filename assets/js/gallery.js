document.addEventListener("DOMContentLoaded", function () {
    const images = document.querySelectorAll(".gallery img");
    const lightbox = document.createElement("div");
    lightbox.id = "lightbox";
    document.body.appendChild(lightbox);

    const img = document.createElement("img");
    lightbox.appendChild(img);

    const closeBtn = document.createElement("span");
    closeBtn.classList.add("close");
    closeBtn.innerHTML = "&times;";
    lightbox.appendChild(closeBtn);

    images.forEach(image => {
        image.addEventListener("click", () => {
            lightbox.style.display = "flex";
            img.src = image.src;
        });
    });

    closeBtn.addEventListener("click", () => {
        lightbox.style.display = "none";
    });

    lightbox.addEventListener("click", (e) => {
        if (e.target !== img) {
            lightbox.style.display = "none";
        }
    });
});
