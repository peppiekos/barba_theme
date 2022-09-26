jQuery(document).ready(function () {
    let gutter = parseInt(jQuery('.swiper.products-swiper').css('--gutter').split('px').shift());
    const productSwiper = new Swiper('.swiper.products-swiper', {
        slidesPerView: 4,
        spaceBetween: gutter,
        grabCursor: true
    });
});