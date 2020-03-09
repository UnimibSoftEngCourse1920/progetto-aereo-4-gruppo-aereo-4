$(function() {

    //TODO: https://stackoverflow.com/questions/7517188/how-can-you-tell-if-a-suggestion-was-selected-from-jquery-ui-autocomplete

    var availableTags = [
        "Milano Malpensa (MXP)",
        "Milano Linate (LIN)",
        "Parigi Orly (ORY)"
    ];

    $( ".datepicker" ).datepicker({
        dateFormat: 'dd/mm/yy'
    });

    $( ".aeroporto" ).autocomplete({
        source: availableTags
    });

} );