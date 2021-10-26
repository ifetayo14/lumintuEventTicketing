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
    let elem = document.getElementById('peserta1')
    let cln = elem.cloneNode(true)
    cln.id = "peserta" + ++quantity

    $('.body-popup').append(cln)
    document.querySelector
    $(`#peserta${quantity} .special`).remove()
    $(`#peserta${quantity} h5`).text(`Peserta ${quantity}`)
    $(`#peserta${quantity} .form-group input`).attr('name', `peserta${quantity}`)
    $(`#peserta${quantity} .form-group input`).attr('id', `peserta${quantity}`)
    $(`#peserta${quantity} .form-group input`).val("")
    console.log($(`#peserta${quantity} #emailHelpBlock`).text("Your email is not valid"))
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

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validate(email) {
    const result = $(`#${email} #emailHelpBlock`);
    if (validateEmail($(`[name=${email}]`).val())) {
        result.text("Your email is valid")
    } else {
        result.text("Your email is not valid")
    }
    return false;
}