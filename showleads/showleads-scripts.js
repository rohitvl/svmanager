$('#leads').DataTable( {
    "ajax": "getleads.php",

    "pageLength": 10,
    "bLengthChange": false,
    "bSort": false,

    "columns": [
        { "data": "name" },
        { "data": "number" },
        { "data": "status" },
        { "data": "token" },
    ]
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
