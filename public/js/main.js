$('.owl-carousel').owlCarousel({
    loop:true,
    margin:50,
    nav:true,
    animateOut: 'fadeOut',
	animateIn: 'fadeIn',
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:3
        }
    }
})

$('.item').mouseenter( function() {
    $(this).find('.more').removeClass('d-none', 5000)
} ).mouseleave( function(){
    $(this).find('.more').addClass('d-none', 5000)
} );

// $( ".deskripsi" ).mouseenter(
//     function() {
//         $(this).find('.more').removeClass('d-none')
//     }.mouseleave(
//         function(){
//             $(this).find('.more').addClass('d-none')
//         }
//     )
//   );