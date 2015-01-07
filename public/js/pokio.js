//******************************************************/
/* Mini DomReady
/* from:https://github.com/DesignByOnyx/mini-domready
/*
//******************************************************/
(function(window, document, pokio, undefined) {

    var attachEvent = 'attachEvent',
    addEventListener = 'addEventListener',
    readyEvent = 'DOMContentLoaded';

    var init = function(){
        alert('Pokio Started');
    }

    if( !document[addEventListener] ){
        addEventListener = document[attachEvent] ?
        (readyEvent = 'onreadystatechange')
        && attachEvent : '';
    }

    var pokio = function(init) {
        //this.init = init;
        /in/.test(document.readyState) ?
        !addEventListener ?
        setTimeout(function() { init(); }, 9)
        : document[addEventListener](readyEvent, init, false)
        : init();
        return this;
    };

    return pokio;

}(window, document, window.pokio = window.pokio || {}));

//window.pokio().init();
