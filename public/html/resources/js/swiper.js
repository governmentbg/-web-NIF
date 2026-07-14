import Swiper from "swiper";
import { Navigation, Pagination } from "swiper/modules";

// import Swiper and modules styles
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

// init Swiper:
const swiper = new Swiper(".swiper", {
    modules: [Navigation, Pagination],
    slidesPerView: 1,
    breakpoints: {
        480: {
            slidesPerView: 2,
            spaceBetween: 20,
        },

        640: {
            slidesPerView: 3,
            spaceBetween: 20,
        },
        768: {
            slidesPerView: 4,
            spaceBetween: 20,
        },
    },
    grid: {
        rows: 3,
    },
    spaceBetween: 30,
    loop: true,
    navigation: {
        nextEl: ".button-next",
        prevEl: ".button-prev",
    },
});
