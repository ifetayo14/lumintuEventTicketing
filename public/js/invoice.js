let IP = '192.168.18.67:8001';


//ambil data cust
$.ajax({
  url: `http://${ip}/items/invoice?fields=invoice_id,customer_id.customer_name,customer_id.customer_email,customer_id.customer_phone="${params}"`,
  type: 'GET',
  dataType: 'json',
  success: function (data, textStatus, xhr) {
    console.log(data.data.length);

    data.data.map((item, index) => {
      invoice.push(0);
      dataCust = `
      <p class="card-text isi-nama">${item.customer_id.customer_name}</p>
      <p class="card-text isi-email">${item.customer_id.customer_email}</p>
      <p class="card-text isi-nohp">${item.customer_id.customer_phone}</p>
      `;
      $('.isinya-cust').append(dataCust);
    });
  }
});

//ambil data orderannya
$.ajax({
  url: `http://${ip}/items/order?fields=order_id,order_quantity,ticket_id.ticket_type,ticket_id.ticket_price="${params}"`,
  type: 'GET',
  dataType: 'json',
  success: function (data, textStatus, xhr) {
    console.log(data.data.length);

    data.data.map((item, index) => {
      invoice.push(0);
      dataOrder = `     
      <h5 class="card-title"><b>Dream World Wide in Jogja</b></h5>
          
            <div class="row">
              <div class="col-sm-6">
              <p class="card-text"><b>ID ORDER</b></p>
              </div>
              <div class="col-sm-6 id-order">
              <p class="card-text">${item.order_id}</p>
              </div>
            </div>
          <hr>
          
          <br>
            <div class="row">
              <div class="col-6 col-md-4">${item.order_id.ticket_type}</div>
              <div class="col-6 col-md-4">${item.order_quantity}</div>
              <div class="col-6 col-md-4">${item.order_id.ticket_price}</div>
            </div>
            <hr>
      `;
      $('.orderannya').append(dataOrder);
    });
  }
});

//ambil data totalnya
$.ajax({
  url: `http://${ip}/items/invoice?fields=invoice_id,invoice_total="${params}"`,
  type: 'GET',
  dataType: 'json',
  success: function (data, textStatus, xhr) {
    console.log(data.data.length);

    data.data.map((item, index) => {
      invoice.push(0);
      dataCust = `
        <div class="col-6 col-md-4"><b>Total</b></div>
        <div class="col-6 col-md-4"></div>
        <div class="col-6 col-md-4">${item.order_id.invoice_total}</div>
      `;
      $('.totalnya').append(dataCust);
    });
  }
});