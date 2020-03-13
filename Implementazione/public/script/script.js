$(function() {

    //TODO: https://stackoverflow.com/questions/7517188/how-can-you-tell-if-a-suggestion-was-selected-from-jquery-ui-autocomplete

    if (typeof aeroporti === 'undefined') {
        aeroporti = [];
    }

    $( ".datepicker" ).datepicker({
        dateFormat: 'yy-mm-dd',
        changeYear: true,
        changeMonth: true,
        yearRange: '1950:2025',
    });

    $('.date-ym-picker').datepicker( {
        dateFormat: "mm/yy",
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        onClose: function(dateText, inst) {
            function isDonePressed(){
                return ($('#ui-datepicker-div').html().indexOf('ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all ui-state-hover') > -1);
            }
            if (isDonePressed()){
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1)).trigger('change');

                $('.date-picker').focusout()//Added to remove focus from datepicker input box on selecting date
            }
        },
        beforeShow : function(input, inst) {
            inst.dpDiv.addClass('month_year_datepicker')
            if ((datestr = $(this).val()).length > 0) {
                year = datestr.substring(datestr.length-4, datestr.length);
                month = datestr.substring(0, 2);
                $(this).datepicker('option', 'defaultDate', new Date(year, month-1, 1));
                $(this).datepicker('setDate', new Date(year, month-1, 1));
                $(".ui-datepicker-calendar").hide();
            }
        }
    });

    $( ".aeroporto" ).autocomplete({
        source: aeroporti
    });

    $(".datepicker").keydown(function(e){
        e.preventDefault();
    });

    $('#form-ricerca').submit(function() {
        var aeroportoPartenza = codiciAeroporti[$("#form-ricerca #da").val()];
        var aeroportoDestinazione = codiciAeroporti[$("#form-ricerca #a").val()];
        if(aeroportoPartenza && aeroportoDestinazione) {
            location.href= "/public/vendita/consultaVoli/" + aeroportoPartenza + "/" + aeroportoDestinazione + "/" +
                            $("#form-ricerca #data_partenza").val() + "/" + $("#form-ricerca #viaggiatori").val();
        }
        return false;
    });

    $('#form-registrazione').submit(function() {
        var indirizzo = $("#form-registrazione #indirizzo").val();
        var citta = $("#form-registrazione #citta").val();
        var cap = $("#form-registrazione #cap").val();
        $("#form-registrazione #hidden_indirizzo").val(indirizzo + " " + citta + " " + cap);
        return true;
    });

    $('#form-data').submit(function() {
        $("#form-data #id_nuovo_volo").val($(".data-disponibile.selected").eq(0).attr('data-volo'));
        $("#form-data #nuova_tariffa").val($(".tariffa.selected").eq(0).attr('data-tariffa'));
        return true;
    });

    $('#button-punti').click(function() {
        $('#button-punti').addClass("selected");
        $('#button-carta').removeClass("selected");
        $('#pagamento-carta').hide();
        $('#pagamento-punti').show();
    });

    $('#button-carta').click(function() {
        $('#button-punti').removeClass("selected");
        $('#button-carta').addClass("selected");
        $('#pagamento-carta').show();
        $('#pagamento-punti').hide();
    });

    $('.data-disponibile').click(function() {
        $('.data-disponibile').removeClass("selected");
        $(this).addClass("selected");
    });

    $('.tariffa').click(function() {
        $('.tariffa').removeClass("selected");
        $(this).addClass("selected");
    });

    $(document).ready(function () {
        $("#tar_plus").click(function () {
            if($(this).hasClass("selected")){

            } else {
                $(this).addClass("selected");
                $("#tar_stand").removeClass("selected");
                $("#supplemento_row").slideDown();
                $("#tariffa_row").slideDown();
                $("#prezzo_tot").text((parseFloat($("#prezzo_base")[0].innerHTML.replace("€",""))+20).toFixed(2)+"€");
                if($("#old_tot").length){
                    var temp = $("#old_tot")[0].innerHTML.replace("€","");
                    $("#old_tot").text(parseFloat(temp).toFixed(1)+20+"€");
                }
            }
        });
        $("#tar_stand").click(function () {
            if($(this).hasClass("selected")){

            } else {
                $(this).addClass("selected");
                $("#tar_plus").removeClass("selected");
                $("#supplemento_row").slideUp();
                $("#tariffa_row").slideUp();
                $("#prezzo_tot").text(parseFloat($("#prezzo_base")[0].innerHTML.replace("€","")).toFixed(2)+"€");
            }
        });
    });

} );