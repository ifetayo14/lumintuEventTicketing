let IP = 'lumintu-tiket.tamiaindah.xyz:8055';
let link = window.location.href;
const url = new URL(link);
let params = url.searchParams.get('m');


//ambil data cust
$.ajax({
  url: `http://${IP}/items/invoice?fields=invoice_id,customer_id.customer_name,customer_id.customer_email,customer_id.customer_phone&filter[customer_id][customer_code]=${params}`,
  type: 'GET',
  dataType: 'json',
  success: function (data, textStatus, xhr) {
    console.log(data.data);
    data.data.map( (item, index) => {
      console.log(item)
      let dataCust = `
      <div class="card-body">
      
      <h5 class=""><b>Data Peserta</b></h5>
            <hr>
            <h5 class="card-title peserta-brp urutan-cust"><b>CUSTOMER ${index + 1} :</b></h5>
            <div class="row">
              <div class="col-sm-6">
                <p class="card-text nama"><b>Nama</b></p>
                <p class="card-text email"><b>Email</b></p>
                <p class="card-text nohp"><b>No. Hp</b></p>
              </div>
              <div class="col-sm-6 isinya-cust">
                <p class="card-text isi-nama">${item.customer_id.customer_name}</p>
                <p class="card-text isi-email">${item.customer_id.customer_email}</p>
                <p class="card-text isi-nohp">${item.customer_id.customer_phone}</p> 
              </div>
            </div>
          </div>
      `;
      console.log(dataCust)
      $('.data-cust').append(dataCust)
    })
  }
});

//ambil data id invoice
$.ajax({
  url: `http://${IP}/items/invoice?fields=invoice_id&filter[customer_id][customer_code]=${params}`,
  type: 'GET',
  dataType: 'json',
  success: function (data, textStatus, xhr) {
    console.log(data.data);
    data.data.map((item, index) => {
      console.log(item)
      let dataOrder = `  
        <div class="col-6 col-md-4"><b>ID INVOICE</b></div>
        <div class="col-6 col-md-4"></div>
        <div class="col-6 col-md-4">${item.invoice_id}</div>
      `;
      console.log(dataOrder)
      $('.id-invoice').append(dataOrder);
    });
  }
});



//ambil data orderannya
$.ajax({
  url: `http://${IP}/items/order?fields=order_id,order_quantity,ticket_id.ticket_type,ticket_id.ticket_price&filter[customer_id][customer_code]=${params}`,
  type: 'GET',
  dataType: 'json',
  success: function (data, textStatus, xhr) {
    console.log(data.data);
    data.data.map((item, index) => {
      console.log(item)
      let dataOrder = `      
        <div class="col-6 col-md-4">${item.ticket_id.ticket_type}</div>
        <div class="col-6 col-md-4">${item.order_quantity}</div>
        <div class="col-6 col-md-4">${item.ticket_id.ticket_price}</div>
      `;
      console.log(dataOrder)
      $('.orderannya').append(dataOrder);
    });
  }
});


//ambil data orderannya
$.ajax({
  url: `http://${IP}/items/invoice?fields=invoice_id,invoice_total&filter[customer_id][customer_code]=${params}`,
  type: 'GET',
  dataType: 'json',
  success: function (data, textStatus, xhr) {
    console.log(data.data);
    data.data.map((item, index) => {
      console.log(item)
      let dataOrder = `      
        <div class="col-6 col-md-4"><b>Total</b></div>
        <div class="col-6 col-md-4"></div>
        <div class="col-6 col-md-4">${item.invoice_total}</div>
      `;
      console.log(dataOrder)
      $('.totalnya').append(dataOrder);
    });
  }
});