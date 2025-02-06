const carouselInner = document.querySelector(".carousel-inner");
const itemsPerView = 3;
let currentIndex = 0;
let totalItems = 0;

const images = Array.from({ length: 21 }, (_, i) => `img/${i + 1}.jpeg`);

console.log(images);

let createCarouselItem = (src) => {
    const item = document.createElement("div");
    item.classList.add("carousel-item");
    const img = document.createElement("img");
    img.src = src;
    item.appendChild(img);
    carouselInner.appendChild(item);
}

for (let i = 0; i < itemsPerView; i++) {
    createCarouselItem(images[i]);
}

totalItems = images.length;

let handleScroll = () => {
    const scrollPosition = window.pageXOffset;
    const scrollThreshold = window.innerWidth / itemsPerView;
    const newIndex = Math.floor(scrollPosition / scrollThreshold);

    if (newIndex !== currentIndex) {
        currentIndex = newIndex;

        const translateX = currentIndex * -100 / itemsPerView;
        carouselInner.computedStyleMap.transform = `translateX(${translateX}%)`;

        if (currentIndex + itemsPerView < totalItems) {
            for (let i = currentIndex + itemsPerView; i < currentIndex + itemsPerView * 2; i++) {
                if (i < totalItems) {
                    createCarouselItem(images[i]);
                }
            }
        } else if (currentIndex > 0) {
            for (let i = 0; i < itemsPerView; i++) {
                carouselInner.firstChild.remove();
            }
        }
    }
}

window.addEventListener("scroll", handleScroll);