$(function() {

    //TODO: https://stackoverflow.com/questions/7517188/how-can-you-tell-if-a-suggestion-was-selected-from-jquery-ui-autocomplete

    if (typeof aeroporti === 'undefined') {
        aeroporti = [];
    }

    $( ".datepicker" ).datepicker({
        dateFormat: 'yy-mm-dd'
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

} );