$('#leads').DataTable( {
    "ajax": "getleads.php",

    "pageLength": 10,
    "bLengthChange": false,
    "bSort": false,

    "columns": [
        { "data": "lead_name" },
        { "data": "lead_number" },
        { "data": "lead_status" },
        { "data": "lead_token" },

        { "data": "lead_config" },
        { "data": "lead_svd" },
        { "data": "sv_status" },
        { "data": "closing_who" },
        { "data": "closing_name" },
        { "data": "attend_status" },
        { "data": "sv_done" },
        { "data": "visit_result" },
        { "data": "lead_remarks" },
        { "data": "lead_source_by" },
        { "data": "lead_id" }
    ],

    // "columnDefs": [
    //     {
    //         "targets": 0,
    //         "createdCell": function (td, cellData, rowData, row, col) {
    //             if (cellData == "pedro jonas") {
    //                 $(tr).css({'color': '#fff', 'background-color': '#4CAF50'});
    //             }
    //         }
    //     }
    // ],

    "createdRow": function(row, data, dataIndex) {
        if (data["sv_status"] == "RSV") {
          $(row).css("background-color", "#c8e6c9");
        }
    },

    rowId: function(a) {
        return "lead_" + a.lead_id;
    }
} );


//adding jquery date time picker to the appropriate input
$('#svd-modal').datetimepicker({
    format:'d/m/Y H:i:00',
    showSecond: false,
    enabledHours: [9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
    step: 30,
    en: {
        months: [
        "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
        ],
        dayOfWeekShort: [
        "Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"
        ],
        dayOfWeek: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]
    }
});



//store all the global variables
let id = null;

//on click row do the primary job :)
$('#leads tbody').on('click', 'tr', function() {
    let rowID = this.id;
    id = rowID.slice(5);

    //fetching the data
    let name = $(`#${rowID}`).children().eq(0).text();
    let number = $(`#${rowID}`).children().eq(1).text();
    let leadstatus = $(`#${rowID}`).children().eq(2).text();
    let token = $(`#${rowID}`).children().eq(3).text();

    let config = $(`#${rowID}`).children().eq(4).text();
    let svdate = $(`#${rowID}`).children().eq(5).text();
    svdate = svdate.slice(8, 10) + '/' + svdate.slice(5, 7) + '/' + svdate.slice(0, 4) + ' ' + svdate.slice(11);
    let svstatus = $(`#${rowID}`).children().eq(6).text();
    let closewho = $(`#${rowID}`).children().eq(7).text();
    let closename = $(`#${rowID}`).children().eq(8).text();
    let attended = $(`#${rowID}`).children().eq(9).text();
    let svdone = $(`#${rowID}`).children().eq(10).text();
    let visitresult = $(`#${rowID}`).children().eq(11).text();
    let remarks = $(`#${rowID}`).children().eq(12).text();
    let sourcedby = $(`#${rowID}`).children().eq(13).text();

    //pushing the fetched data

    //NAME
    $('#lname').val(name);
    //store name in the top of modal
    $('.name-on-modal').html(`Lead Name: <b><u>${name}</u></b>`);

    //NUMBER
    $('#lnumber').val(number);

    //CONFIG
    $("#lconfig").val(config);

    //SV Date
    $("#svd-modal").val(svdate);

    //SV Status
    $("#lsvstatus").val(svstatus);

    //Lead Status
    $("#lstatus").val(leadstatus);

    //Lead Token
    $("#token-input").val(token);

    //close who?
    $("#whoClosing").val(closewho);

    //close name
    $("#closingName").val(closename);

    //attend status
    $("#attendStatus").val(attended);

    //sv done???????
    svdone === "Yes" ? $('#issvdone').prop("checked", true) : $('#issvdone').prop("checked", false)

    //visit result
    $("#visitresult").val(visitresult);

    //remarks
    $("#lremarks").val(remarks);

    //sourced by
    $("#lsourceby").val(sourcedby);

    //appropriate functions to be called in order to have proper visible elements
    lstatusflip(leadstatus);
    attendFlip(attended);
    checksvdone('issvdone');
    vrselected(visitresult);

    $('.leadInfo').show();
});




//hide modal on clicking the close 
$('.close-modal i').click(function() {
    id = null;
    $('.feedback').text("");
    $('#leads').DataTable().ajax.reload(null, false);
    $('.leadInfo').hide();
});

//hide the selected modal elements on load of the page

$('.modal-token-container, .modal-closing-container, .modal-svdonecheck-container, .modal-visitresult-container').hide();

//on change of lead status if it is anything except arrived, then show the token element
//on change of lead status to Closing, then show the closing input select elements
function lstatusflip(value) {

    value === "" ? value = "Arrived" : null;

    value !== "Arrived" ? $('.modal-token-container').show() : (
        
        $('.modal-token-container').hide(),
        $('#token-input').val('')
    );

    value === "Not Arrived" ? (
        $('.modal-token-container').hide(),
        $('#token-input').val('')
    ) : null;

    (value === "Closing" || value === "Booked") ? $('.modal-closing-container').show() : (
        
        $('.modal-closing-container').hide(),
        $('#whoClosing').val(''),
        $('#closingName').val('')
    );
}


//if attended, then show the is sv done and visit result elements, else hide it
function attendFlip(value) {
    value === "Attended" ? $('.modal-svdonecheck-container').show() : (
        $('.modal-svdonecheck-container, .modal-visitresult-container').hide(),
        $('#issvdone').prop("checked", false),
        $("#visitresult").val("")
    )
}

//on click the is sv done then hide/show the visit result element appropriately
function checksvdone(element) {
    $(`#${element}`).prop("checked") === true ? $('.modal-visitresult-container').show() : (
        $('.modal-visitresult-container').hide(),
        $("#visitresult").val("")
    )
}

//on changing the visit result, also select the appropriate value in the lead status
function vrselected(value) {
    $('#lstatus').val(value);
    if(value === "Booked") {
        lstatusflip('Booked');
    } else if (value === "Planned RSV") {
        lstatusflip('Planned RSV');
    } else {
        null;
    }
}

$('#issvdone').on('click', function() {

    checksvdone('issvdone');

});


//on save, save the data of lead
$('#save').on('click', function() {
    let sname = $('#lname').val();
    let snumber = $('#lnumber').val();
    let sleadstatus = $('#lstatus').val();
    let stoken = $('#token-input').val();

    let sconfig = $('#lconfig').val();
    let ssvdate = $('#svd-modal').val();
    ssvdate = ssvdate.slice(6, 10) + '-' + ssvdate.slice(3, 5) + '-' + ssvdate.slice(0, 2) + ' ' + ssvdate.slice(11);
    let ssvstatus = $('#lsvstatus').val();
    let sclosewho = $('#whoClosing').val();
    let sclosename = $('#closingName').val();
    let sattended = $('#attendStatus').val();

    let ssvdone = null;
    let svisitresult = null;


    $('#issvdone').prop("checked") === true ? (
        ssvdone = "Yes",
        svisitresult = $('#visitresult').val()
    ) : (
        ssvdone = "No",
        svisitresult = ""

    );

    let sremarks = $('#lremarks').val();

    // alert(`${sname} ${snumber} ${sleadstatus} ${stoken}  ${sconfig} ${ssvdate} `);
    // alert(`${ssvstatus} ${sclosewho} ${sclosename} ${sattended}  ${ssvdone} ${svisitresult} `);

    if(sname === "" || snumber === "" || sremarks === "" || sleadstatus === "" || ssvstatus === "" || ((sleadstatus === "Tagged" || sleadstatus === "Pre WR" || sleadstatus === "AV" || sleadstatus === "Post WR" || sleadstatus === "Closing" || sleadstatus === "Booked" || sleadstatus === "Planned RSV") && stoken === "")) {
        $('.feedback').text('**please enter required fields like remarks / change status / token number**');
    } else {

        $.ajax({
            url: "savelead.php",
            data: {
                id: id,
                name: sname,
                number: snumber,
                leadstatus: sleadstatus,
                token: stoken,
                config: sconfig,
                svdate: ssvdate,
                svstatus: ssvstatus,
                closewho: sclosewho,
                closename: sclosename,
                attended: sattended,
                svdone: ssvdone,
                visitresult: svisitresult,
                remarks: sremarks
    
            },
            type: "POST",
            success: function(result) {
                $('.feedback').text(result);
                $('#leads').DataTable().ajax.reload(null, false);
            }
        });

    }

});