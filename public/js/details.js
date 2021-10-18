$('.owl-carousel').owlCarousel({
    margin:0,
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


function tambahkan() {
    let quantity = document.querySelectorAll('.peserta').length
    if (quantity < 4){
        let elem = document.getElementById('peserta1')
        let cln = elem.cloneNode(true)
        cln.id = "peserta" + ++quantity
        
        $('.body-popup').append(cln)
        document.querySelector(`#peserta${quantity} h5`).innerHTML = `Peserta ${quantity}`
    } else if (quantity == 4) {
        let elem = document.getElementById('peserta1')
        let cln = elem.cloneNode(true)
        cln.id = "peserta" + ++quantity
        
        $('.body-popup').append(cln)
        document.querySelector(`#peserta${quantity} h5`).innerHTML = `Peserta ${quantity}`
        $('.btn-circle').addClass('d-none')
    }
    $('.modal-dialogue').scrollTop($('.modal-dialogue').height())
}

// Show Voucher Code Field
$(document).on('change', '.switchMe', function() {
    if(this.checked) {
        $("input#voucher").css('visibility', 'visible');
    } else{
        $("input#voucher").css('visibility', 'hidden');
    }
});

$("input#voucher").on('input', function(){
    if($(this).val() != ""){
        $(".btn-plus").addClass('d-none')
    } else {
        $(".btn-plus").removeClass('d-none')
    }
    console.log($(this).val())
})
