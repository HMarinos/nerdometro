import "./bootstrap";
import Swiper from "swiper/bundle";
import "swiper/css/bundle";

import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();

const animeswiper1 = new Swiper(".animeswiper1", {
    loop: true,
    slidesPerView: 1,
    spaceBetween: 10,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
    },
    breakpoints: {
        520: {
          slidesPerView: 2,
          spaceBetween: 10,
        },
        700: {
          slidesPerView: 3,
          spaceBetween: 10,
        },
        860: {
          slidesPerView: 4,
          spaceBetween: 10,
        },
        1024: {
          slidesPerView: 5,
          spaceBetween: 10,
        },
    }
});

const animeswiper2 = new Swiper(".animeswiper2", {
    loop: true,
    slidesPerView: 1,
    spaceBetween: 10,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
    },
    breakpoints: {
        520: {
          slidesPerView: 2,
          spaceBetween: 10,
        },
        700: {
          slidesPerView: 3,
          spaceBetween: 10,
        },
        860: {
          slidesPerView: 4,
          spaceBetween: 10,
        },
        1024: {
          slidesPerView: 5,
          spaceBetween: 10,
        },
    }
});

const animeswipe3 = new Swiper(".animeswiper3", {
    loop: true,
    autoplay: {
        delay: 2000,
        disableOnInteraction: true,
    },
    speed: 600,
    spaceBetween: 10,
    slidesPerView: 1,
    parallax: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});


const movieswiper1 = new Swiper(".movieswiper1", {
    loop: true,
    slidesPerView: 1,
    spaceBetween: 10,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
    },
    breakpoints: {
        520: {
          slidesPerView: 2,
          spaceBetween: 10,
        },
        700: {
          slidesPerView: 3,
          spaceBetween: 10,
        },
        860: {
          slidesPerView: 4,
          spaceBetween: 10,
        },
        1024: {
          slidesPerView: 5,
          spaceBetween: 10,
        },
    }
});

const movieswiper2 = new Swiper(".movieswiper2", {
    loop: true,
    slidesPerView: 1,
    spaceBetween: 10,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
    },
    breakpoints: {
        520: {
          slidesPerView: 2,
          spaceBetween: 10,
        },
        700: {
          slidesPerView: 3,
          spaceBetween: 10,
        },
        860: {
          slidesPerView: 4,
          spaceBetween: 10,
        },
        1024: {
          slidesPerView: 5,
          spaceBetween: 10,
        },
    }
});


const gameswiper1 = new Swiper(".gameswiper1", {
    loop: true,
    slidesPerView: 1,
    spaceBetween: 10,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
    },
    breakpoints: {
        520: {
          slidesPerView: 2,
          spaceBetween: 10,
        },
        700: {
          slidesPerView: 3,
          spaceBetween: 10,
        },
        860: {
          slidesPerView: 4,
          spaceBetween: 10,
        },
        1024: {
          slidesPerView: 5,
          spaceBetween: 10,
        },
    }
});

const gameswiper2 = new Swiper(".gameswiper2", {
    loop: true,
    slidesPerView: 1,
    spaceBetween: 10,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
    },
    breakpoints: {
        520: {
          slidesPerView: 2,
          spaceBetween: 10,
        },
        700: {
          slidesPerView: 3,
          spaceBetween: 10,
        },
        860: {
          slidesPerView: 4,
          spaceBetween: 10,
        },
        1024: {
          slidesPerView: 5,
          spaceBetween: 10,
        },
    }
});

const gameswiper3 = new Swiper(".gameswiper3", {
    loop: true,
    slidesPerView: 1,
    spaceBetween: 10,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
    },
    breakpoints: {
        520: {
          slidesPerView: 2,
          spaceBetween: 10,
        },
        700: {
          slidesPerView: 3,
          spaceBetween: 10,
        },
        860: {
          slidesPerView: 4,
          spaceBetween: 10,
        },
        1024: {
          slidesPerView: 5,
          spaceBetween: 10,
        },
    }
});
