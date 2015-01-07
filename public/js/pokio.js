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
        console.log('Pokio Started');
    }

    if( !document[addEventListener] ){
        addEventListener = document[attachEvent] ?
        (readyEvent = 'onreadystatechange')
        && attachEvent : '';
    }

    /in/.test(document.readyState) ?
    !addEventListener ?
    setTimeout(function() { init(); }, 9)
    : document[addEventListener](readyEvent, init, false)
    : init();

    return this

}(window, document, window.pokio = window.pokio || {}));
