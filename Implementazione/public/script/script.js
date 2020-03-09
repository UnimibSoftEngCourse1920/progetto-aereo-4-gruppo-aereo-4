$(function() {

    //TODO: https://stackoverflow.com/questions/7517188/how-can-you-tell-if-a-suggestion-was-selected-from-jquery-ui-autocomplete

    /*var availableTags = [
        "Milano Malpensa (MXP)",
        "Milano Linate (LIN)",
        "Parigi Orly (ORY)"
    ];*/

    $( ".datepicker" ).datepicker({
        dateFormat: 'dd/mm/yy'
    });

    $( ".aeroporto" ).autocomplete({
        source: aeroporti
    });

    $('#form-ricerca').submit(function() {
        var aeroportoPartenza = codiciAeroporti[$("#form-ricerca #da").val()];
        var aeroportoDestinazione = codiciAeroporti[$("#form-ricerca #a").val()];
        if(aeroportoPartenza && aeroportoDestinazione) {
            $("#form-ricerca #da").css('color', 'white');
            $("#form-ricerca #a").css('color', 'white');
            $("#form-ricerca #da").val(aeroportoPartenza);
            $("#form-ricerca #a").val(aeroportoDestinazione);
            return true;
        }
        return false;
    });

} );