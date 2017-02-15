var mil = {
    settings: {
      prizesUrl: '?action=ajaxPrizes'
    },
    html: {
        prizesLoader: $('#prizesLoader')
    },
    prizes: [],
    init: function () {
        mil.loadPrizes();
    },
    loadPrizes: function (){
        $.ajax({
            type: 'GET',
            url: mil.settings.prizesUrl,
            dataType: 'json',
            beforeSend: function () {
                mil.html.prizesLoader.show(1000);
            }
        }).always(function () {
            mil.html.prizesLoader.hide(1000);
        }).done(function (json) {
            mil.prizes = json;
            mil.buildPrizes();

        }).fail(function () {
            console.log("nie udalo sie załadować wygranych");
        });
    },
    buildPrizes: function (){
        var prizes = '', curr;
        for (var i=mil.prizes.length-1; i>=0; i--){
            curr = mil.prizes[i].value.replace(/\B(?=(\d{3})+(?!\d))/g, " ");

            if (mil.prizes[i].isActual === true) {
                prizes += '<li class="actual">';
            }else if (mil.prizes[i].isGuranteed === true){
                prizes += '<li class="guarantee">';
            }else{
                prizes += '<li>';
            }

            prizes += '<span>'+(i+1)+'</span>'+curr+' zł</li>';
        }

        $('.winPrizes').html(prizes);
    }
};

$(document).ready(function () {
    mil.init();
});