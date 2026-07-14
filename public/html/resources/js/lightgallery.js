import lightGallery from "lightgallery";

// Plugins
import lgZoom from "lightgallery/plugins/zoom";

lightGallery(document.getElementById("swiper-container"), {
    speed: 500,
    showZoomInOutIcons: true,
    actualSize: false,
    controls: true,
    selector: ".swiper-slide > img",
    plugins: [lgZoom],
});
