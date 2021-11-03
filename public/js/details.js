const ip = "192.168.18.226:8001"
let arrayOfSession = []

const idEvent = 2;

$(document).ready(function(){
    // AJAX Day
    $.ajax({
        url: `http://${ip}/items/day`,
        type: "GET",
        dataType: "json",
        success: function (data, textStatus, xhr) {
            data.data.map((item, index) => {
                if(index == 0){
                    $('.owl-carousel').append(
                        `
            <div class="item border-carousel-item active">
              <a href="#" onclick="getSession(${index})">
                <p class="h5">${item.day_name}</p>
                <p class="tanggal-event">${convertDate(item.day_date)}</p>
              </a>
            </div>
            `
                    )
                } else {
                    $('.owl-carousel').append(
                        `
            <div class="item border-carousel-item">
              <a href="#" onclick="getSession(${index})">
                <p class="h5">${item.day_name}</p>
                <p class="tanggal-event">${convertDate(item.day_date)}</p>
              </a>
            </div>
            `
                    )
                }
            })
        },
        complete: function(){
            initializeCarousel()
            sesi()
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log("Error in Database");
        },
    });

    // AJAX Event
    $.ajax({
        url: `http://${ip}/items/event/${idEvent}`,
        type: "GET",
        dataType: "json",
        beforeSend: function () {
            $("#loader").removeClass('d-none');
        },
        success: function (data, textStatus, xhr) {
            const event = data.data;
            console.log(event.event_name);
            $(".nama-event").text(event.event_name);
            $(".eventClient").text("By " + event.event_client);
            $(".eventAddress").text(event.event_address);
            $(".eventDesc").text(event.event_desc);
        },
        complete: function () {
            $("#loader").addClass('d-none');
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log("Error in Database");
        },
    });

})


function sesi(){ // AJAX Session
    $.ajax({
        url: `http://${ip}/items/ticket?fields=ticket_id,ticket_type,ticket_x_session.session_id.*,ticket_x_day.day_id.*`,
        type: "GET",
        dataType: "json",
        beforeSend: function () {
            $(".spinner-event").removeClass('d-none');
        },
        success: function (data, textStatus, xhr) {
            console.log(data.data)
            data.data.map((item, index) => {
                if (item.ticket_type.includes("Only")){
                    arrayOfSession.push(new Array())
                    item.ticket_x_session.map((item, keys) => {
                        arrayOfSession[index].push(item)
                    })
                }
            })

        },
        complete: function () {
            $(".spinner-event").addClass('d-none');
            getSession(0)
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log("Error in Database");
        },
    });
}

function initializeCarousel(){
    $(".owl-carousel").owlCarousel({
        margin: 5,
        nav: true,
        responsive: {
            0: {
                items: 3,
            },
            600: {
                items: 3,
            },
            1000: {
                items: 4,
            },
        },
    });
}

function getSession(day) {
    $('.table').html("")
    arrayOfSession[day].map(item => {
        let data = item.session_id
        let isiTabel =
            `
    <tr>
      <td class="date-session">${convertTime(data.start_time)} - ${convertTime(data.finish_time)}</td>
      <td class="title-session font-weight-bold">${data.session_type}<br>
        <span class="detail-session font-weight-normal">${data.session_desc}</span>
      </td>
    </tr>
    `
        $('.table').append(isiTabel)
    })
}

function convertDate(dateString) {
    var momentObj = moment(dateString, "YYYY-DD-MM");
    var momentString = momentObj.format("D MMM yy");
    return momentString;
}

function convertTime(time) {
    var momentObj = moment(time, "YYYY-MM-DDTHH:mm:ss");
    var momentString = momentObj.format("hh.mm A");
    return momentString;
}

function tambahkan() {
    let quantity = document.querySelectorAll(".peserta").length;
    let elem = document.getElementById("peserta1");
    let cln = elem.cloneNode(true);
    cln.id = "peserta" + ++quantity;

    $(".body-popup").append(cln);
    document.querySelector;
    $(`#peserta${quantity} .special`).remove();
    $(`#peserta${quantity} p`).text(`Peserta ${quantity}`);
    $(`#peserta${quantity} .form-group input`).attr("name", `peserta${quantity}`);
    $(`#peserta${quantity} .form-group input`).attr("id", `peserta${quantity}`);
    $(`#peserta${quantity} .form-group input`).val("");
    $(`#peserta${quantity} #emailHelpBlock`).removeClass('d-none')
}

// Show Voucher Code Field
$(document).on("change", ".switchMe", function () {
    if (this.checked) {
        $("input#voucher").css("visibility", "visible");
    } else {
        $("input#voucher").css("visibility", "hidden");
    }
});

$("input#voucher").on("input", function () {
    if ($(this).val() != "") {
        $(".btn-plus").addClass("d-none");
    } else {
        $(".btn-plus").removeClass("d-none");
    }
    console.log($(this).val());
});

function validateEmail(email) {
    const re =
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validate(email) {
    const result = $(`#${email} #emailHelpBlock`);
    if (validateEmail($(`[name=${email}]`).val())) {
        result.text("Your email is valid");
        result.addClass('d-none')
    } else {
        result.text("Your email is not valid");
    }
    return false;
}
