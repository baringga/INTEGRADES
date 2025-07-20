import './bootstrap';
import Swiper from 'swiper';
import { Pagination } from 'swiper/modules';
import 'swiper/swiper-bundle.css';
import '../css/app.css';
import 'alpinejs';

document.addEventListener('DOMContentLoaded', () => {
  const swiper = new Swiper('.mySwiper', {
    modules: [Pagination],
    loop: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
  });
});