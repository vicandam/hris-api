function getMeta(name) {
    var metas = document.getElementsByTagName('meta');
    for (var i=0; i<metas.length; i++) {
        var keyName = metas[i].getAttribute('name');
        var content = metas[i].getAttribute('content');

        if(keyName == name) {
            return content;
        }
    }

    return "";
}

let host = window.location.hostname;

window.url = getMeta('url');
window.tab = getMeta('tab');
window.page = getMeta('page');
