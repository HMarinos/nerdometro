import "./bootstrap";
import Swiper from "swiper/bundle";
import "swiper/css/bundle";

import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();

const animeswiper1 = new Swiper(".animeswiper1", {
    slidesPerView: 5,
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
});

const animeswiper2 = new Swiper(".animeswiper2", {
    slidesPerView: 5,
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
});

const animeswipe3 = new Swiper(".animeswiper3", {
    speed: 600,
    spaceBetween: 10,
    slidesPerView: 1.2,
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
