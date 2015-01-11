//******************************************************/
/* pokio.js
/*
//******************************************************/
(function(window, document, pokio, undefined) {

    var gateway = ""

    var attachEvent = 'attachEvent',
    addEventListener = 'addEventListener',
    readyEvent = 'DOMContentLoaded';

    var togglePokio = function(mevt){
        console.log(mevt);
        var e = mevt.srcElement;
        //TODO: make the pokios toggle!
        //swap classes i/o
        //swap img srcs
        //swap text characters
        //send event to gateway
    }
    var init = function(){
        console.log('Pokio Started');
        var poks = document.getElementsByClassName('pok');
        var poktxts = document.getElementsByClassName('pok-text');
        for(var p=0;p<poks.length;p++){
            poks[p].addEventListener('click',togglePokio,false);
        }
        for(var pt=0;pt<poktxts.length;pt++){
            poktxts[pt].addEventListener('click',togglePokio,false);
        }
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

    return this;

}(window, document, window.pokio = window.pokio || {}));
