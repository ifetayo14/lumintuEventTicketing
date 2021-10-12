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

// function buyTicketForm() {
//     Swal.fire({
//         html: `<div class="container-fluid bg-dark">
//         <div class="header-popup">
//             <p class="h3">Dream World Wide in Jogja</p>
//             <p class="organizer">By Lumintu Logic</p>
//         </div>
//         <div class="body-popup">
//             <div class="peserta border p-4 mb-4 rounded" id="peserta1">
//                 <form>
//                     <h3 class="text-left">Peserta</h3>
//                     <div class="form-group">
//                         <label for="exampleInputEmail1">Email</label>
//                         <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
//                     </div>
//                     <div class="form-group">
//                         <label for="select-ticket">Ticket</label>
//                         <select class="form-control" id="select-ticket">
//                             <option>Tiket Day 1</option>
//                             <option>Tiket Day 2</option>
//                             <option>Tiket Day 3</option>
//                             <option>Tikey Day 1 and Day 2</option>
//                             <option>Tiket Day 1 and Day 3</option>
//                             <option>Tiket Day 2 and Day 3</option>
//                           </select>
//                     </div>
//                     <div class="form-group">
//                         <label for="priceInput">Price</label>
//                         <input class="form-control" type="text" placeholder="350000" readonly id="priceInput">
//                     </div>
                    
//                 </form>
//             </div>
//         </div>
//         <div class="text-right mx-4 ">
//             <button type="button" class="mb-4 btn btn-default btn-circle btn-lg rounded-circle" onclick="tambahkan()"> 
//                 <i class="fa fa-plus"></i>
//             </button>
//         </div>
//     </div>`,
//         confirmButtonText: 'Sign in',
//         focusConfirm: false,
//         preConfirm: () => {
//           const login = Swal.getPopup().querySelector('#login').value
//           const password = Swal.getPopup().querySelector('#password').value
//           if (!login || !password) {
//             Swal.showValidationMessage(`Please enter login and password`)
//           }
//           return { login: login, password: password }
//         }
//       }).then((result) => {
//         Swal.fire(`
//           Login: ${result.value.login}
//           Password: ${result.value.password}
//         `.trim())
//       })
// }

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
        document.querySelector(`#peserta${quantity} h3`).innerHTML = `Peserta ${quantity}`
        $('.btn-circle').addClass('d-none')
    }
    $('.modal-dialogue').scrollTop($('.modal-dialogue').height())
}