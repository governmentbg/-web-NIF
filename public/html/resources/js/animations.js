document.addEventListener("DOMContentLoaded", () => {
    const elements = document.querySelectorAll("[data-animation]");
    const groups = document.querySelectorAll("[data-group]");

    /* INITIAL HIDE */

    elements.forEach((el) => {
        const trigger = el.dataset.on || "scroll";

        if (trigger !== "hover") {
            el.style.opacity = "0";
            el.style.visibility = "hidden";
        }
    });

    /* GROUP STAGGER */

    groups.forEach((group) => {
        const children = group.querySelectorAll("[data-animation]");

        children.forEach((el, index) => {
            if (!el.dataset.delay) {
                el.dataset.delay = index * 150;
            }
        });
    });

    /* PLAY ANIMATION */

    function playAnimation(el) {
        const animation = el.dataset.animation;
        const delay = el.dataset.delay;
        const duration = el.dataset.duration;
        const repeat = el.dataset.repeat === "true";

        el.style.opacity = "1";
        el.style.visibility = "visible";

        el.classList.add("animate__animated", "animate__" + animation);

        if (delay) {
            el.style.animationDelay = delay + "ms";
        }

        if (duration) {
            el.style.animationDuration = duration;
        }

        el.addEventListener(
            "animationend",
            () => {
                if (!repeat) {
                    el.classList.remove(
                        "animate__animated",
                        "animate__" + animation,
                    );
                }
            },
            { once: true },
        );
    }

    /* LOAD */

    elements.forEach((el) => {
        const trigger = el.dataset.on || "scroll";

        if (trigger === "load") {
            playAnimation(el);
        }
    });

    /* HOVER */

    elements.forEach((el) => {
        if (el.dataset.on === "hover") {
            el.addEventListener("mouseenter", () => {
                playAnimation(el);
            });
        }
    });

    /* SCROLL */

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const el = entry.target;

                    if (!el.dataset.on || el.dataset.on === "scroll") {
                        playAnimation(el);
                    }

                    observer.unobserve(el);
                }
            });
        },
        { threshold: 0.2 },
    );

    elements.forEach((el) => {
        const trigger = el.dataset.on;

        if (!trigger || trigger === "scroll") {
            observer.observe(el);
        }
    });
});

/*
    data-animation: animation_name
    data-delay: delay in ms
    data-on: load / scroll / hover
    data-duration: animation duration
    data-repeat: true / false
    data-group: define parent as group animation container
*/

// Load / Scroll Animations: data-on = load
/*
    1. fadeIn
    2. fadeInUp
    3. fadeInDown
    4. fadeInLeft
    5. fadeInRight
    6. zoomIn
    7. zoomOut
    9. slideInUp
    10. slideInDown
    11. slideInLeft
    12. slideInRight
    13. bounceIn
    14. flipInX
    15. flipInY
*/

// Hover Animations: data-on = hover
/*
    1. pulse
    2. rubberBand
    3. swing
    4. tada
    5. heartBeat
    6. bounce
    7. jello
    8. shakeX
*/
