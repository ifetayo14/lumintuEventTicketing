const IP = "192.168.0.125:8001"; // IP API
const LINK = window.location.href;
const URL = new URL(LINK);
const PARAMS = URL.searchParams.get("m");
const TOTAL_HARGA = $("#total-harga")
const CUSTOM_SELECT = $(".custom-select")
const BUTTON_CHECKOUT = $(".btn-checkout")
const TABLE = $(".table-status")
const VOUCHER = $(".voucher")
const TABLE_BODY = $("tbody")

let optionTicket = [
    { nama: "No Selected Ticket", harga: 0, capacity: 0 }
];  //Array Jenis Ticket
let sumTicket = [0]; // Array Jumlah Data Penjualan per Ticket
let statusPemesanan = []; // Array Status Invitation
let pembelian = []; // Array menampung harga tiket pilihan


// AJAX untuk mengambil Jumlah Data Penjualan per Ticket
$.ajax({
    url: `http://${IP}/items/order?aggregate[sum]=order_quantity&groupBy[]=ticket_id`,
    type: "GET",
    dataType: "json",
    success: function (data, textStatus, xhr) {
        const items = data.data
        items.map((item) => {
            let sumOrder = item.sum.order_quantity
            sumTicket.push(sumOrder);
        });
    },
    error: function (xhr, textStatus, errorThrown) {
        console.log("Error in Database");
    },
});

// Deklarasi
let inisialisi = () => {
    optionTicket = [
        { nama: "No Selected Ticket", harga: 0, capacity: 0 }
    ]; //Array Jenis Ticket
    sumTicket = [0]; // Array Jumlah Data Penjualan per Ticket
    statusPemesanan = []; // Array Status Invitation
    pembelian = []; // Array menampung harga tiket pilihan
}

// Memunculkan Harga
let priceShow = (idClass, value) => {
    $(`.price${idClass}`).html(optionTicket[value].harga);
    checkStatus();
    pembelian[idClass - 1] = optionTicket[value].harga;
    total(); // Memanggil Function Harga
}

// Mencari Total Pembelian
let total = () => {
    let total = 0;
    pembelian.map((item) => {
        total += item;
    });
    TOTAL_HARGA.val(total);
}

// Switch untuk Button berdasarkan input
let checkStatus = () => {
    if (statusPemesanan.indexOf(false) == -1) {
        for (i = 1; i <= CUSTOM_SELECT.length; i++) {
            if ($(`#${i}`).val() == 0) {
                BUTTON_CHECKOUT.prop("disabled", true);
                break;
            } else {
                BUTTON_CHECKOUT.prop("disabled", false);
            }
        }
    } else {
        BUTTON_CHECKOUT.prop("disabled", true);
    }
}

let deleteData = (invit, customer) => {
    swal.fire({
        title: "Are you sure?",
        text: "You will not be able to use this data again!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, I am Sure',
        cancelButtonText: 'No, cancel it!',
        dangerMode: true,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `http://${IP}/items/invitation/${invit}`,
                type: "PATCH",
                contentType: 'application/json',
                data: JSON.stringify(
                    { "invitation_status": 2 }
                )
            }).done(function () {
                $.ajax({
                    url: `http://${IP}/items/customer/${customer}`,
                    type: "PATCH",
                    contentType: 'application/json',
                    data: JSON.stringify(
                        { "customer_status": 2 }
                    )
                }).done(function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Data has been deleted',
                        showConfirmButton: true,
                    })
                }).fail(function (msg) {

                })
            }).fail(function (msg) {
                Swal.fire({
                    icon: 'error',
                    title: 'Data not deleted',
                    showConfirmButton: true,
                })
            }).always(function () {
                TABLE.DataTable().clear().destroy();
                inisialisi()
                getData()
            })
        } else if (result.isDenied) {
            swal.fire("Cancelled", "Make your better choice!", "error");
        }
    })
}

// Mengambil Data Ticket, Data Order, 
let getData = () => {
    $.ajax({
        url: `http://${IP}/items/ticket/`,
        type: "GET",
        dataType: "json",
        beforeSend: function () {
            $("#loader").removeClass('d-none');
        },
        success: function (data, textStatus, xhr) {
            const items = data.data
            items.map((item) => { //Menyimpan Jenis Tiket ke Array
                let ticket_seat = item.ticket_seat
                if (ticket_seat != null) {
                    optionTicket.push({
                        nama: item.ticket_type,
                        harga: item.ticket_price,
                        capacity: item.ticket_seat,
                    });
                }
            });

            let panjangOpsi = optionTicket.length - 1; //Mencari Length dari Array Jenis Ticket
            let penunjuk = panjangOpsi;
            for (i = 1; i < panjangOpsi; i++) {
                for (j = i + 1; j < panjangOpsi; j++) {
                    optionTicket.splice(penunjuk, 0, {
                        nama: `${optionTicket[i].nama} & ${optionTicket[j].nama}`,
                        harga: optionTicket[i].harga + optionTicket[j].harga,
                        capacity: Math.min(
                            optionTicket[i].capacity,
                            optionTicket[j].capacity
                        ),
                    });

                    sumTicket.splice(penunjuk, 0, Math.max(sumTicket[i], sumTicket[j]));
                    penunjuk++;
                }
            }


            $.ajax({
                url: `http://${IP}/items/invitation?fields=invitation_id,customer_id.customer_id,customer_id.customer_email,customer_id.customer_name,customer_id.customer_status,customer_inviter_id.customer_id,customer_inviter_id.customer_email,invitation_status&filter[customer_inviter_id][customer_code]="${PARAMS}"`,
                type: "GET",
                dataType: "json",
                beforeSend: function () {
                    $("#loader").removeClass('d-none');
                },
                success: function (data, textStatus, xhr) {
                    const items = data.data

                    items.map((item, index) => {
                        let status = item.invitation_status
                        let customer_id = item.customer_id.customer_id
                        let customer_email = item.customer_id.customer_email
                        let customer_name = item.customer_id.customer_name
                        if (status != 2) {
                            pembelian.push(0);
                            tableRow = `
                            <tr>
                                <td>
                                    ${customer_email}
                                </td>
                                <td>${customer_name == null
                                    ? "Belum Mengisi"
                                    : `${customer_name}`
                                }
                                </td>
                                ${status == 1 ?
                                    `<td>
                                    <select class="custom-select" id="${index + 1}" name="tiket-peserta" onchange="priceShow(this.id, this.value)"></select>
                                </td>
                                <td class= "price${index + 1}">${0}</td>
                                <td>
                                    <div class="card shadow" style="width: 32px; height: 32px; margin: 0 auto;">
                                    <img src="../public/img/true.svg" alt=""></div>
                                </td>
                                <td>Completed</td>
                                `
                                    :
                                    `<td>
                                    <select class="custom-select" id="${index + 1}" onchange="priceShow(this.id, this.value)" disabled></select>
                                </td>
                                <td class= "price${index + 1}">${0}</td>
                                <td>
                                    <div class="card shadow" style="width: 32px; height: 32px; margin: 0 auto;">
                                    <img src="../public/img/false.svg" alt=""></div>
                                </td>
                                <td>
                                    <button class="btn btn-danger" onclick="deleteData(${item.invitation_id}, ${customer_id})" type="button">Hapus</button>
                                </td>
                                `
                                }
                            </tr>`;
                            TABLE_BODY.append(tableRow);
                            if (status == 1) {
                                statusPemesanan.push(true);
                            } else {
                                statusPemesanan.push(false);
                            }
                        }
                    });

                    optionTicket.map((item, index) => {
                        if (optionTicket[index].capacity != null) {
                            if (optionTicket[index].capacity == 0) {
                                CUSTOM_SELECT.append(
                                    `<option value="${index}">${item.nama}</option>`
                                );
                            } else {
                                CUSTOM_SELECT.append(
                                    `<option value="${index}">${item.nama} (${item.capacity - sumTicket[index]
                                    })</option>`
                                );
                            }
                        }
                    });

                    checkStatus();

                    if (pembelian.length <= 1) {
                        VOUCHER.removeClass("d-none");
                        TABLE.DataTable({
                            paging: false,
                            searching: false,
                            info: false,
                            ordering: true,
                            columnDefs: [{
                                orderable: false,
                                targets: "no-sort"
                            }]
                        });
                    } else {
                        VOUCHER.addClass("d-none");
                        TABLE.DataTable({
                            ordering: true,
                            columnDefs: [{
                                orderable: false,
                                targets: "no-sort"
                            }]
                        });
                    }

                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log("Error in Database");
                },
            });
        },
        complete: function (data) {
            // Hide image container
            $("#loader").addClass("d-none");
        },
        error: function (xhr, textStatus, errorThrown) {
            $("#loader").addClass("d-none");
            TABLE_BODY.html(`<td colspan="6" class="text-center">Failed to Load Data</td>`);
        },
    });
}

$(document).ready(function () {
    getData()
});



const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false
})


document.querySelector('#formPesanan').addEventListener('submit', function (e) {
    var form = this;

    e.preventDefault(); // <--- prevent form from submitting

    swal.fire({
        title: "Are you sure?",
        text: "You will not be able to change your choice!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, I am Sure',
        cancelButtonText: 'No, cancel it!',
        dangerMode: true,
    }).then((result) => {
        if (result.isConfirmed) {
            swal.fire({
                title: 'Success',
                text: 'Your Order is Completed!',
                icon: 'success'
            }).then(function () {
                form.submit();
            });
        } else if (result.isDenied) {
            swal.fire("Cancelled", "Make your better choice!", "error");
        }
    })
});