let optionTicket = [{nama : "No Selected Ticket", harga : "-", capacity: 0}]
let sumTicket = [0]
let statusPemesanan =[]
let pembelian = []

function myFunction(idClass, value){

    $(`.price${idClass}`).text(optionTicket[value].harga)
    checkStatus()
    pembelian[idClass-1] = optionTicket[value].harga
    total()
}

function total(){
    let total = 0
    pembelian.map(item => {
        total += item
    })
    $('#total-harga').val(total)
}


function checkStatus(){

    if(statusPemesanan.indexOf(false) == -1){
        for(i = 1; i <= $('.custom-select').length; i++){
            if($(`#${i}`).val() == 0){
                $('.btn-checkout').prop('disabled', true)
                break;
            } else {
                $('.btn-checkout').prop('disabled', false)
            }
        }
    } else {
        $('.btn-checkout').prop('disabled', true)
    }

}


$(document).ready(function() {

    let link = window.location.href
    const url = new URL(link)

    let params = url.searchParams.get('m')
    console.log(atob(params))

    // AJAX terjual
    $.ajax({
        url: 'http://192.168.0.114:8055/items/order?aggregate[sum]=order_quantity&groupBy[]=ticket_id',
        type: 'GET',
        dataType: 'json',
        success: function(data, textStatus, xhr) {
            data.data.map(item => {
                sumTicket.push(item.sum.order_quantity)
            })

        },
        error: function(xhr, textStatus, errorThrown) {
            console.log('Error in Database');
        }
    });


    // AJAX jenis Tiket
    $.ajax({
        url: 'http://192.168.0.114:8055/items/ticket/',
        type: 'GET',
        dataType: 'json',
        success: function(data, textStatus, xhr) {
            data.data.map(item => {
                if(item.ticket_seat != null){
                    optionTicket.push({nama : item.ticket_type, harga : item.ticket_price, capacity : item.ticket_seat})
                }
            })
            console.log(data.data)
            let panjangOpsi = optionTicket.length-1
            let penunjuk = panjangOpsi
            for(i = 1; i < panjangOpsi; i++){
                for(j = i+1; j < panjangOpsi; j++){
                    optionTicket.splice(penunjuk, 0,
                        {
                            nama : `${optionTicket[i].nama} & ${optionTicket[j].nama}`,
                            harga : optionTicket[i].harga + optionTicket[j].harga,
                            capacity: Math.min(optionTicket[i].capacity, optionTicket[j].capacity)
                        }
                    )

                    sumTicket.splice(penunjuk, 0, Math.max(sumTicket[i], sumTicket[j]))
                    penunjuk++
                    console.log(`${optionTicket[i].nama} ${optionTicket[j].nama}`)
                }

            }
        },
        error: function(xhr, textStatus, errorThrown) {
            console.log('Error in Database');
        }
    });




    // AJAX data Table
    $.ajax({
        url: `http://192.168.0.114:8055/items/invitation?fields=invitation_id,customer_id.customer_email,customer_id.customer_name,customer_inviter_id.customer_email,invitation_status&filter[customer_inviter_id][customer_email]="${atob(params)}"`,
        type: 'GET',
        dataType: 'json',
        success: function(data, textStatus, xhr) {
            data.data.map((item, index) => {
                pembelian.push(0)
                tableRow = `
                <tr>
                    <td>${index+1}</td>
                    <td>
                        <input type="email" class="input-status" name="email-peserta-${index}" value="${item.customer_id.customer_email}" readonly>
                    </td>
                    <td>${item.customer_id.customer_name == null?
                    `<input type="email" class="input-status" name="nama-peserta" value="Belum Mengisi" readonly>`:
                    `<input type="email" class="input-status" name="nama-peserta-${index}" value="${item.customer_id.customer_name}" readonly>`}
                    </td>
                    ${item.invitation_status == 1?
                    `<td>
                        <select class="custom-select" id="${index+1}" name="tiket-peserta-${index}" onchange="myFunction(this.id, this.value)">
                        </select>
                    </td>
                    <td class= "price${index+1}">-</td>
                    <td>
                        <div class="card shadow" style="width: 32px; height: 32px;">
                        <img src="../public/img/true.svg" alt=""></div>
                    </td>`:
                    `<td>
                        <select class="custom-select" id="${index+1}" onchange="myFunction(this.id, this.value)" disabled>
                        </select>
                    </td>
                    <td class= "price${index+1}">-</td>
                    <td>
                        <div class="card shadow" style="width: 32px; height: 32px;">
                        <img src="../public/img/false.svg" alt=""></div>
                    </td>
                    `
                }
                </tr>    
                `
                $('tbody').append(tableRow)
                if(item.invitation_status == 1){
                    statusPemesanan.push(true)
                } else {
                    statusPemesanan.push(false)
                }
                console.log(statusPemesanan)
            })

            optionTicket.map((item, index) => {

                if(optionTicket[index].capacity != null){
                    if (optionTicket[index].capacity == 0){
                        $(".custom-select").append(`<option value="${index}">${item.nama}</option>`)
                    } else {
                        $(".custom-select").append(`<option value="${index}">${item.nama} (${item.capacity - sumTicket[index]})</option>`)
                    }

                }
            })
            checkStatus()

        },
        error: function(xhr, textStatus, errorThrown) {
            console.log('Error in Database');
        }
    });
});