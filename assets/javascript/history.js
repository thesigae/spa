(function() {
    'use strict';
    var container = document.querySelector('.pages'),
        links = document.querySelectorAll('.link'),
        textWrapper = document.querySelector('.highlight'),
        content = document.querySelector('.content'),
        defaultTitle = 'DLE - Welcome!';
        
        $('.content').load('https://dev.deltaliquidenergy.com/dev/spa/page?p=testing');

    function updateText(content) {
        textWrapper.innerHTML = content;
    }

    function requestContent(page,section) {
        $('#'+section+' .content').load(page);
    }

    function removeCurrentClass() {
        for (var i = 0; i < links.length; i++) {
            links[i].classList.remove('spaCurrent');
        }
    }

    function addCurrentClass(elem) {
        removeCurrentClass();
        var element = document.querySelector('.' + elem);
        element.classList.add('spaCurrent');
    }
    container.addEventListener('click', function(e) {
        e.preventDefault();
        if (!e.target.classList.contains('spaCurrent')) {
            var name = e.target.getAttribute('data-name'),
                section = e.target.getAttribute('data-section');
            var data = {name:name, section:section},
                pushUrl = 'https://dev.deltaliquidenergy.com/dev/' + data['name'],
                loadUrl = 'https://dev.deltaliquidenergy.com/dev/spa/page?p=' + data['name'];
            addCurrentClass(data['name']);
            history.pushState(data, null, null);
            requestContent(loadUrl,data['section']);
            document.title = 'DLE | ' + data['name'];
        }
        e.stopPropagation();
    }, false);
    window.addEventListener('popstate', function(e) {
        var data = e.state;
        if (data === null) {
            removeCurrentClass();
            content.innerHTML = ' ';
            document.title = defaultTitle;
        } else {
            var loadUrl = 'https://dev.deltaliquidenergy.com/dev/spa/page?p=' + data['name'];
            requestContent(loadUrl,data['section']);
            addCurrentClass(data['name']);
            document.title = 'DLE | ' + data['name'];
        }
    })
})();