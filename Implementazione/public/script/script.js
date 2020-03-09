$(function() {

    //TODO: https://stackoverflow.com/questions/7517188/how-can-you-tell-if-a-suggestion-was-selected-from-jquery-ui-autocomplete

    /*var availableTags = [
        "Milano Malpensa (MXP)",
        "Milano Linate (LIN)",
        "Parigi Orly (ORY)"
    ];*/

    $( ".datepicker" ).datepicker({
        dateFormat: 'yy-mm-dd'
    });

    $( ".aeroporto" ).autocomplete({
        source: aeroporti
    });

    $('#form-ricerca').submit(function() {
        var aeroportoPartenza = codiciAeroporti[$("#form-ricerca #da").val()];
        var aeroportoDestinazione = codiciAeroporti[$("#form-ricerca #a").val()];
        if(aeroportoPartenza && aeroportoDestinazione) {
            $("#form-ricerca #hidden_da").val(aeroportoPartenza);
            $("#form-ricerca #hidden_a").val(aeroportoDestinazione);
            return true;
        }
        return false;
    });

    $('#form-registrazione').submit(function() {
        var indirizzo = $("#form-registrazione #indirizzo").val();
        var citta = $("#form-registrazione #citta").val();
        var cap = $("#form-registrazione #cap").val();
        $("#form-ricerca #hidden_indirizzo").val(indirizzo + " " + citta + " " + cap);
        return true;
    });

} );