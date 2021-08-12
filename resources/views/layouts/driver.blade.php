<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Make Payment</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('third_party_stylesheets')
    @stack('page_css')
</head>
<body>
@yield('content')
<script src="{{ mix('js/app.js') }}" ></script>
@yield('third_party_scripts')
@stack('page_scripts')
<script>
var tab_row = 0;
function add_row() {
    var total_cash = 0;
    var rhn_id = $("#RHN").val();
    var plat_id = $('input[name="plat_id[]"]');
    for (var j = 0; j < tab_row; j++) {
        if (plat_id.eq(j).val() != undefined) {
            if(rhn_id == plat_id.eq(j).val()){
                alert("Duplicate Platform");
                return false;
            }
        }
    }
    var RHN = $("#RHN option:selected").text();
    var SPF = $("#SPF").val().trim();
    var CPF = $("#CPF").val().trim();
    var TPF = $("#TPF").val().trim();
    if(SPF != "" && CPF != "" && TPF != "" ){
        var cash = $('input[name="cash[]"]');
        $('#addr' + tab_row).html("<td style='text-align: center'>"
        + "<input value='" + rhn_id + "' name='plat_id[]' type='hidden'><input value='" + SPF + "' name='earning[]' type='hidden'><input value='" + CPF + "' name='cash[]' type='hidden'><input value='" + TPF + "' name='trips[]' type='hidden'><button title='Delete' onclick='delete_row(" + tab_row + ")' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button></td>"
        + "<td style='text-align: center'>" + RHN + "</td>"
        + "<td style='text-align: center'>" + SPF + "</td>"
        + "<td style='text-align: center'>" + CPF + "</td>"
        + "<td style='text-align: center'>" + TPF + "</td>");
        $('#example1').append('<tr id="addr' + (tab_row + 1) + '"></tr>');
        tab_row++;
        for (var j = 0; j < tab_row; j++) {
            if (cash.eq(j).val() != undefined) {
                total_cash = total_cash + parseFloat(cash.eq(j).val());
            }
        }
        total_cash = total_cash + parseFloat(CPF);  
    }
    $("#total_cash").html(total_cash);
}    

function delete_row(row) {
    $("#addr" + (row)).remove();
    var total_cash = 0;
    var cash = $('input[name="cash[]"]');
    for (var j = 0; j < tab_row; j++) {
        if (cash.eq(j).val() != undefined) {
            total_cash = total_cash + parseFloat(cash.eq(j).val());
        }
    }
    $("#total_cash").html(total_cash);
}

function submit_data() {
    if(tab_row > 0){
        var plat_id = $('input[name="plat_id[]"]');
        var earning = $('input[name="earning[]"]');
        var cash = $('input[name="cash[]"]');
        var trips = $('input[name="trips[]"]');
        $("#plat_id_hidden").val(plat_id.eq(0).val());
        $("#earning_hidden").val(earning.eq(0).val());
        $("#cash_hidden").val(cash.eq(0).val());
        $("#trips_hidden").val(trips.eq(0).val());
        $('#sales_form')[0].submit();
    }else{

    }    
}

$(document).ready(function(){
    
    $(".decimal").keypress(function(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode != 46 && charCode > 31
            && (charCode < 48 || charCode > 57)) {
            return false;
        }
        if (charCode == 46 && this.value.indexOf(".") !== -1) {
            return false;
        }
        return true;
    });

    $('.number').keypress(function (event) {
        var keycode = event.which;
        if (!(event.shiftKey == false && (keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
        event.preventDefault();
        }
    });
});
</script>
</body>
</html>
