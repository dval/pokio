//******************************************************/
/* pokio.js
/*
//******************************************************/
(function(window, document, pokio, undefined) {

    var gateway = "",
    attachEvent = 'attachEvent',
    addEventListener = 'addEventListener',
    readyEvent = 'DOMContentLoaded';

    var togglePokio = function(mevt){
        console.log(mevt);
        var e = mevt.srcElement;
        xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                console.log(xmlhttp.responseText);
                xmlhttp = null;
            }
        }
        xmlhttp.open("POST","http://spaghetti.local/projects/pokio/src/php/pokio-recorder.php",true);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        var tn = mevt.target.localName;
        var id = mevt.target.id;
        var cn = mevt.target.className.split(' ').join('.');
        var ts = mevt.timeStamp;
        xmlhttp.send("id="+id+"#"+cn+"&ts="+ts);
        //TODO: make the pokios toggle!
        //swap classes i/o
        //swap img srcs
        //swap text characters
        //send event to gateway
        /*
        for(var p in e.attributes){
            if(p.indexOf('data-pokio')>-1){
                console.log(p);
            }else{
                //console.log(e);
            }
        //console.log(p);
        }
        */
    }

    //doit
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

    //equalize 'domReady' event
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
