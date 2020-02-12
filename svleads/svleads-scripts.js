function labelUp(id) {
    $(`#${id}`).css({'border-bottom': '3px solid #426e70'});
    $(`#${id}`).prev().css({'color': '#426e70', 'top': '0', 'left': '0', 'transform': 'none', 'font-size': '0.7em', 'font-weight': 'bolder'});
}

function labelDown(id) {
    if($(`#${id}`).val() === '') {
        $(`#${id}`).css({'border-bottom': '1px solid cadetblue'});
        $(`#${id}`).prev().css({'color': '#aaa', 'top': '50%', 'left': '50%', 'transform': 'translate(-50%, -50%)', 'font-size': '1em', 'font-weight': 'normal'});    
    } else {
        $(`#${id}`).css({'border-bottom': '3px solid #426e70'});
        $(`#${id}`).prev().css({'color': '#426e70', 'top': '0', 'left': '0', 'transform': 'none', 'font-size': '0.7em', 'font-weight': 'bolder'});    
    }
}


//adding jquery date time picker to the appropriate input
$('#ldt').datetimepicker({
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


//show dd container on clicking on it or config input and hide it once clicked outside

//first hide the dd container
$(".div-dd").hide();

//show when clicked/focused on config input
$("#lconfig").focus(function(){
    $(".div-dd").show();
});
  

$('.svleads-container').mouseup(function(e) 
{
    let container = $(".div-dd");
    let inputContainer = $('#lconfig');

    let arr = [];

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0 && !inputContainer.is(e.target)) {

        container.hide();

        $(`.div-dd input:checkbox[name="config"]:checked`).each(function(){
            arr.push($(this).val());
        });

        inputContainer.val(arr);

        labelDown('lconfig');

    }

});