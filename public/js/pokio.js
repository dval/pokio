//******************************************************/
/* pokio.js
/*
//******************************************************/
(function(window, document, pokio, undefined) {

    var gateway = "",
    attachEvent = 'attachEvent',
    addEventListener = 'addEventListener',
    readyEvent = 'DOMContentLoaded',
    poken = {'id':'','value':''};

    var makeRequest = function(rdata,callback){

        xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                callback(xmlhttp.responseText);
                xmlhttp = null;
            }
        }
        //is there a better way to link paths?
        xmlhttp.open("POST","../php/pokio.php",true);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

        xmlhttp.send(rdata);
    }

    var getToken = function(){
        makeRequest('',setToken);
    }

    var setToken = function(response){
        response = JSON.parse(response);
        for(var k in response){
            poken.id=k;
            poken.value=response[k];
        }
    }

    var togglePokio = function(mevt){
        //console.log(mevt);
        var e = mevt.srcElement;
        var tn = mevt.target.localName;
        var id = mevt.target.id;
        var cn = mevt.target.className.split(' ').join('.');
        var ts = mevt.timeStamp;

        var req = "id="+id+"#"+cn+"&ts="+ts+"&"+poken.id+"="+poken.value;

        makeRequest(req,function(responseText){
                console.log(responseText);
            });
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
                console.log(e);
            }
        }
        */
    }

    //doit
    var init = function(){

        getToken();

        var poks = document.getElementsByClassName('pok');
        var poktxts = document.getElementsByClassName('pok-text');
        for(var p=0;p<poks.length;p++){
            poks[p].addEventListener('click',togglePokio,false);
        }
        for(var pt=0;pt<poktxts.length;pt++){
            poktxts[pt].addEventListener('click',togglePokio,false);
        }

        console.log('Pokio Started');

    }

    //equalize 'domReady' event
    if( !document[addEventListener] ){
        addEventListener = document[attachEvent] ?
        (readyEvent = 'onreadystatechange')
        && attachEvent : '';
    }
    if(/in/.test(document.readyState)){
        if(!addEventListener ){
            setTimeout(function() { init(); }, 9);
        }else{
            document[addEventListener](readyEvent, init, false);
        }
    }else{
        init();
    }

    return this;

}(window, document, window.pokio = window.pokio || {}));
