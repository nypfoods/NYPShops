/*  Page Loader ========================================================================== */
if (isvueapp) {
    $("body").on('onvueload', function() {
        load_preloader($('#loader'));
        //callServerMethod('print_header').then((d) => { log('Not Modified', d); });
    });
} else {
    $("body").on('winload', function() {
        load_preloader($('#loader'));
    });
}

var notify = null;
t$("#notifycon").node.innerHTML = `
    <dbdata name='ntftbl' sql='select * from orders' @row="(val)=>{handelNotifyEnd(val);}" >
        <div :id="'ntf'+d.val.itmid" slot='row' slot-scope='d' class='ncard' style="display:grid" >
            <div style="position:relative">
                <div class='ntitle'>{{d.val.pname}}</div>
                <div class='nbody'>{{d.val.pname}}</div>
                <button class="clsbtn" type="button" @click="t$('#ntf'+d.val.itmid).class('hide');t$('#ntf'+d.val.itmid).css('display','none');">X</span>
            </div>
        </div>
    </dbdata>
`;
let lnotifylen = 0;

function load_preloader(loader) {
    let nd = t$(t$("#notify").node.parentNode);
    setTimeout(function() {
        if (loader.length > 0) {
            loader.fadeOut();
        }
        if (window.ntftbl && ntftbl.vue && ntftbl.vue.show) {
            ntftbl.vue.show = false;
        }
    }, 1000);
    if (nd.node != document) {
        nd.on('click', () => {
            ntftbl.vue.show = !ntftbl.vue.show;
        });
    }
    loadVue(t$("#notifycon").node).then((val) => {
        notify = val;
        // t$("body").on("onintervel",function(){
        //  ntftbl.vue.fetchData();
        // });
    });
}

function playAudio(url) {
    var audio = document.createElement('audio');
    audio.src = url;
    audio.style.display = "none"; //added to fix ios issue
    audio.autoplay = true; //avoid the user has not interacted with your page issue
    audio.onended = function() {
        audio.remove(); //remove after playing to clean the Dom
    };
    document.body.appendChild(audio);
}

function handelNotifyEnd(val) {
    if (lnotifylen != val.length) {
        if (val.length > lnotifylen && val.length != 0 || lnotifylen == 0) {
            playAudio(get_url("/res/aud/ring1.mp3"));
        }
        lnotifylen = val.length;
        if (window.ntftbl && ntftbl.vue && ntftbl.vue.show) {
            ntftbl.vue.show = true;
        }
        let autohide = true;
        setTimeout(function() {
            if (autohide) {
                if (window.ntftbl && ntftbl.vue && ntftbl.vue.show) {
                    ntftbl.vue.show = false;
                }
            }
        }, 1000);
    }
    let ln = lnotifylen -
        (t$(".ncard.hide").nodes ? t$(".ncard.hide").nodes.length : 0);
    t$('#notify').text(ln);
}