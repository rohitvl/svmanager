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

//show when clicked/focused on config/sourceby input
$("#lconfig").focus(function(){
    $(".div-dd-config").show();
});

$("#lnemp").focus(function(){
    $(".div-dd-source").show();
});

$("#lsvs").focus(function(){
    $(".div-dd-svs").show();
});
  

$('.svleads-container').mouseup(function(e) 
{
    let configcontainer = $(".div-dd-config");
    let configinputContainer = $('#lconfig');

    let carr = [];

    // if the target of the click isn't the container nor a descendant of the container
    if (!configcontainer.is(e.target) && configcontainer.has(e.target).length === 0 && !configinputContainer.is(e.target)) {

        configcontainer.hide();

        $(`.div-dd-config input:radio[name="config"]:checked`).each(function(){
            carr.push($(this).val());
        });

        configinputContainer.val(carr);

        labelDown('lconfig');

    }

    let sourcecontainer = $(".div-dd-source");
    let sourceinputContainer = $('#lnemp');

    let sarr = [];

    // if the target of the click isn't the container nor a descendant of the container
    if (!sourcecontainer.is(e.target) && sourcecontainer.has(e.target).length === 0 && !sourceinputContainer.is(e.target)) {

        sourcecontainer.hide();

        $(`.div-dd-source input:radio[name="ddlnemp"]:checked`).each(function(){
            sarr.push($(this).val());
        });

        sourceinputContainer.val(sarr);

        labelDown('lnemp');

    }


    let svscontainer = $(".div-dd-svs");
    let svsinputContainer = $('#lsvs');

    let svsarr = [];

    // if the target of the click isn't the container nor a descendant of the container
    if (!svscontainer.is(e.target) && svscontainer.has(e.target).length === 0 && !svsinputContainer.is(e.target)) {

        svscontainer.hide();

        $(`.div-dd-svs input:radio[name="svsdd"]:checked`).each(function(){
            svsarr.push($(this).val());
        });

        svsinputContainer.val(svsarr);

        labelDown('lsvs');

    }

});