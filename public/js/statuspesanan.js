let optionTicket = [{ id: 0, nama: 'No Selected Ticket', harga: 0, capacity: 0, sisa: 0 }]; //Array Jenis Ticket
let sumTicket = [0]; // Array Jumlah Data Penjualan per Ticket
let statusPemesanan = []; // Array Status Invitation
let pembelian = []; // Array menampung harga tiket pilihan
let ip = 'lumintu-tiket.tamiaindah.xyz:8055'; // IP API
let potonganHarga = 0;
let waktu = ""
let batas = ""
let expire = false;

// Reset Variable
const inisialisi = () => {
  optionTicket = [{ id: 0, nama: 'No Selected Ticket', harga: 0, capacity: 0, sisa: 0 }]; //Array Jenis Ticket
  sumTicket = [0]; // Array Jumlah Data Penjualan per Ticket
  statusPemesanan = []; // Array Status Invitation
  pembelian = []; // Array menampung harga tiket pilihan
}

// AJAX untuk mengambil Jumlah Data Penjualan per Ticket
const getTicketSold = () => {
  $.ajax({
    url: `http://${ip}/items/order?aggregate[sum]=order_quantity&groupBy[]=ticket_id`,
    type: 'GET',
    dataType: 'json',
    success: function (data, textStatus, xhr) {
      data.data.map((item) => {
        sumTicket.push(item.sum.order_quantity);
      });
    },
    error: function (xhr, textStatus, errorThrown) {
      console.log('Error in Database');
    },
  });
}

// get Data of Voucher
const getDiscount = (voucher) => {
  $.ajax({
    url: `http://${ip}/items/voucher/?filter[voucher_id]=${voucher}`,
    type: 'GET',
    dataType: 'json',
    success: function (data, textStatus, xhr) {
      potonganHarga = data.data[0].voucher_discount //Set Nilai Potongan Harga menjadi nilai dari hasil AJAX
    },
    error: function (xhr, textStatus, errorThrown) {
      console.log('Error in Database');
    },
  });
}


// Memunculkan Harga berdasarkan Pilihan
const priceShow = (idClass, value) => {
  console.log(idClass, value)
  let hasil = optionTicket.find(o => o.id == value);
  $(`.price${idClass}`).html(hasil.harga);
  checkStatus();
  pembelian[idClass - 1] = hasil.harga;
  
  total(); // Memanggil Function Harga
}

// Mencari Total Pembelian
const total = () => {
  let total = 0;
  pembelian.map((item) => {
    total += item;
  });
  $('#sub-total').val(total);
  $('#discount').val(`-${potonganHarga}`); //Merubah Nilai dari ID Input dari sebuah tag
  $('#total-harga').val(total - potonganHarga);
}

// Switch untuk Button berdasarkan input
const checkStatus = () => {
  if (statusPemesanan.indexOf(false) == -1) {
    for (i = 1; i <= $('.custom-select').length; i++) {
      if ($(`#${i}`).val() == 0) {
        $('.btn-checkout').prop('disabled', true);
        break;
      } else {
        $('.btn-checkout').prop('disabled', false);
      }
    }
  } else {
    $('.btn-checkout').prop('disabled', true);
  }
}

// Menampilkan Remaining Time
const showAndExpire = (dataSet) => {
  waktu = moment(dataSet.data[0].invitation_date).utcOffset(420).format("YYYY-MM-DDTHH:mm:ss") //Mengambil data waktu pengundang dari database
  batas = moment(waktu).add(1, 'd') //Batas Waktu Pengisian adalah 1 hari
  sekarang = moment() //Mengambil jam sekarang saat dipanggil

  let minutes = batas.diff(sekarang, 'minutes') % 60 //Modulo untuk mendapatkan sisa menit
  let hours = (batas.diff(sekarang, 'minutes') - minutes) / 60 // Untuk mendapatkan jam
  
  if (batas.diff(sekarang, 'minutes') <= 0){ // Jika waktu sudah habis maka merubah menjadi expire
    $('.remaining-time').text(`Sisa Waktu : Expired`)
  } else {
    $('.remaining-time').text(`Sisa Waktu : ${hours} Jam ${minutes} Menit`) //Jika waktu belum habis maka merubah menjadi sisa waktu
  }
}


// Mengambil Data Utama
const getData = () => {
  let link = window.location.href;
  const url = new URL(link);

  let params = url.searchParams.get('m'); //Mengambil Data dari params keyword 'm'
  let paramsVoucher = url.searchParams.get('voucher_id') //Mengambil Data dari params keyword 'voucher_id'
  getDiscount(paramsVoucher) //Mengambil Besaran Diskon dari Voucher ID
  // AJAX jenis Tiket
  $.ajax({
    url: getTicket(paramsVoucher), //Memanggil Function getTicket untuk mendapatkan return IP yang cocok berdasarkan paramter
    type: 'GET',
    dataType: 'json',
    beforeSend: function(){
      getTicketSold()
      $('#loader').removeClass('d-none')
    },
    success: function (data, textStatus, xhr) {0
      data.data.map((item) => {
        console.log(item)
        if(item.ticket_seat != null){ //Jika seat tidak samadengan null
          if(paramsVoucher == null){ //Jika paramsVoucher adalah null maka akan menampilkan tiket yang tidak memilih voucher_id
            if(item.voucher_id === null && item.ticket_seat != null){
              optionTicket.push({
                id: item.ticket_id,
                nama: item.ticket_type,
                harga: item.ticket_price,
                capacity: item.ticket_seat,
                sisa: item.current_seat
              });
            }
          } else {
            if(item.voucher_id != null && item.ticket_seat != null){
              optionTicket.push({
                id: item.ticket_id,
                nama: item.ticket_type,
                harga: item.ticket_price,
                capacity: item.ticket_seat,
                sisa: item.current_seat
              });
            }
          }
        }
        
      });

      // let panjangOpsi = paramsVoucher != null? optionTicket.length : optionTicket.length; //Mencari Length dari Array Jenis Ticket
      let panjangOpsi = optionTicket.length;

      console.log(panjangOpsi)
      
      if(paramsVoucher == null){
        let penunjuk = panjangOpsi;
        let next = 1; //Untuk Value Tiket Gabungan, setiap menambahkan tiket gabungan next + 1, value untuk tiket gabungan adalah banyak tiket yang didapat ditambah next
        for (i = 1; i < panjangOpsi; i++) {
          for (j = i + 1; j < panjangOpsi; j++) {
            if((optionTicket[i].nama).includes("Only") == true &&
            (optionTicket[j].nama).includes("Only") == true
            ){ //Melakukan Penggabungan Jenis jika mengandung kata "Only"
              optionTicket.splice(penunjuk, 0, {
                id: panjangOpsi + next,
                nama: `${optionTicket[i].nama} & ${optionTicket[j].nama}`,
                harga: optionTicket[i].harga + optionTicket[j].harga,
                capacity: Math.min(optionTicket[i].capacity, optionTicket[j].capacity),
                sisa: Math.min(optionTicket[i].sisa, optionTicket[j].sisa)
              });

              // sumTicket.splice(penunjuk, 0, Math.max(sumTicket[i], sumTicket[j]));
              penunjuk++;
              next++;
            }
            
          }
        }
      }

      $.ajax({
        url: `http://${ip}/items/invitation?fields=invitation_id,invitation_date,customer_id.customer_email,customer_id.customer_id,customer_id.customer_name,customer_inviter_id.customer_email,invitation_status&filter[customer_inviter_id][customer_code]=${params}`,
        type: 'GET',
        dataType: 'json',
        beforeSend: function () {
          $("#loader").removeClass('d-none');
        },
        success: function (data, textStatus, xhr) {

          showAndExpire(data)
          let dataPeserta = data.data

          dataPeserta.map((item, index) => {
            // console.log(item)
            if(item.invitation_status != 2) {
              pembelian.push(0);
              
              tableRow = `
                        <tr>
                            <td>
                                ${item.customer_id.customer_email}
                            </td>
                            <td>${item.customer_id.customer_name == null
                    ? "Belum Mengisi"
                    : `${item.customer_id.customer_name}`
                  }
                            </td>
                            ${item.invitation_status == 1 ?
                    `<td>
                                <select class="custom-select" id="${index + 1}" name="tiket-peserta" onchange="priceShow(this.id, this.value)"></select>
                              </td>
                              <td class= "price${index + 1}">${0}</td>
                              <td>
                                  <div class="card shadow" style="width: 32px; height: 32px; margin: 0 auto;">
                                  <img src="../public/img/true.svg" alt=""></div>
                              </td>
                              <td>
                                Completed
                              </td>
                              `
                    :
                    `<td>
                                <select class="custom-select" id="${index + 1}" onchange="priceShow(this.id, this.value)" disabled></select></td>
                              <td class= "price${index + 1}">${0}</td>
                              <td>
                                  <div class="card shadow" style="width: 32px; height: 32px; margin: 0 auto;">
                                  <img src="../public/img/false.svg" alt=""></div>
                              </td>
                              <td>
                                <button class="btn btn-danger" onclick="hapus(${item.invitation_id}, ${item.customer_id.customer_id}, ${2})" type="button">Hapus</button>
                              </td>
                              `
                  }
                            
                        </tr>    
                        `;
              $('tbody').append(tableRow);
              if (item.invitation_status == 1) {
                statusPemesanan.push(true);
              } else {
                statusPemesanan.push(false);
              }
            }
            
          });

          optionTicket.map((item, index) => {
            if (optionTicket[index].capacity != null) {
              if (optionTicket[index].capacity == 0) {
                $('.custom-select').append(`<option value="${item.id}">${item.nama}</option>`);
              } else {
                // $('.custom-select').append(`<option value="${item.id}">${item.nama} (${item.capacity - sumTicket[index]})</option>`);
                $('.custom-select').append(`<option value="${item.id}">${item.nama} (${item.sisa})</option>`);
              }
              console.log(item)
            }
          });

          checkStatus();

          if (data.data.length == 1) {
            $('.voucher').removeClass('d-none');
            $('.table-status').DataTable({
              paging: false,
              searching: false,
              info: false,
              ordering: true,
              columnDefs: [
                {
                  orderable: false,
                  targets: 'no-sort',
                },
              ],
            });
          } else {
            $('.voucher').addClass('d-none');
            $('.table-status').DataTable({
              ordering: true,
              columnDefs: [
                {
                  orderable: false,
                  targets: 'no-sort',
                },
              ],
            });
          }
        },
        complete: function (data) {
          // Hide image container
          $('#loader').addClass('d-none');
        },
        error: function (xhr, textStatus, errorThrown) {
          console.log('Error in Database');
        },
      });


    },
    error: function (xhr, textStatus, errorThrown) {
      console.log('Error in Database');
    },
  });
}

$(document).ready(function () {
  getData()
});

const getTicket = (voucher) => {
  if(voucher === null) {
    return `http://${ip}/items/ticket`
  } else {
    return `http://${ip}/items/ticket/?filter[voucher_id]=${voucher}`
  }
}

const hapus = (invit, customer, kode) => {
  $.ajax({
    url: `http://${ip}/items/invitation/${invit}`,
    type: "PATCH",
    contentType: 'application/json',
    data: JSON.stringify(
      { "invitation_status": kode }
    )
  }).done(function () {
    $.ajax({
      url: `http://${ip}/items/customer/${customer}`,
      type: "PATCH",
      contentType: 'application/json',
      data: JSON.stringify(
        { "customer_status": kode }
      )
    }).done(function () {
      Swal.fire({
        icon: 'success',
        title: 'Data has been deleted',
        showConfirmButton: true,
      })
    }).fail(function (msg) {
      console.log('FAIL')
    })
  }).fail(function (msg) {
    console.log('FAIL')
  }).always(function () {
    $(".table-status").DataTable().clear().destroy();
    inisialisi()
    getData()
  })
}


// function confirmOrder(){
//   swal.fire({
//     title: "Are you sure?",
//     text: "You will not be able to recover this imaginary file!",
//     icon: "warning",
//     buttons: [
//       'No, cancel it!',
//       'Yes, I am sure!'
//     ],
//     dangerMode: true,
//   })
// }

const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success',
    cancelButton: 'btn btn-danger',
  },
  buttonsStyling: false,
});

document.querySelector('#formPesanan').addEventListener('submit', function (e) {
  var form = this;

  e.preventDefault(); // <--- prevent form from submitting

  swal
    .fire({
      title: 'Are you sure?',
      text: 'You will not be able to change your choice!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, I am Sure',
      cancelButtonText: 'No, cancel it!',
      dangerMode: true,
    })
    .then(function (isConfirm) {
      if (isConfirm) {
        swal
          .fire({
            title: 'Success',
            text: 'Your Order is Completed!',
            icon: 'success',
          })
          .then(function () {
            form.submit();
          });
      } else {
        swal.fire('Cancelled', 'Make your better choice!', 'error');
      }
    });
});
