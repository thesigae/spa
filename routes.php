<?php

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use RainLab\User\Facades\Auth;

use BranMuffin\Spa\Models\Pages;

Route::get('spa/page', function(Request $req) {
    $slugName = Input::get('p');
    if ($slugName) {
        $pages = Pages::all();
        $page = $pages->where('slug', $slugName)->first();
        return $page->text;
    } else {
        echo 'Cannot Find Page';
    }
})->middleware(['web']);

Route::get('spa/assets/javascript', function(Request $req) {
    $section = Input::get('section');
    $default = Input::get('default');
    $url = Input::get('url', '/');
    $history = null;
    if (Session::get($section)) {
        $default = Session::get($section);
    }
    return "
        (function() {
            'use strict';
            var container = document.querySelector('#".$section." .pages'),
                links = document.querySelectorAll('#".$section." .pages .link'),
                textWrapper = document.querySelector('.highlight'),
                content = document.querySelector('.content'),
                linkImages = $('a:has(img)'),
                defaultTitle = 'Spa - Welcome!',
                section = '".$section."';
            ".$history."
            console.log(linkImages);
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
            function addBodyStyle(style){
                $('body').css({'overflow': style});
            }
        
            function addCurrentClass(elem,section) {
                removeCurrentClass();
                var element = document.querySelector('#' + section + ' .' + elem);
                element.classList.add('spaCurrent');
            }
            if (container != null) {
                container.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (!e.target.classList.contains('spaCurrent') && $(e.target).is('a')) {
                        var name = e.target.getAttribute('data-name');
                        var data = {name:name, section:section},
                            pushUrl = '".$url."' + data['name'],
                            loadUrl = '".$url."spa/page?p=' + data['name'];
                        $(this).request('onSessionPage', {data: {name: data['name'], section: data['section']}});
                        addCurrentClass(data['name'],data['section']);
                        history.pushState(data, null, null);
                        requestContent(loadUrl,data['section']);
                        document.title = 'Spa | ' + data['name'];
                    }
                    e.stopPropagation();
                }, false);
            }
            if (linkImages != null) {
                $('.content').on('click', 'a:has(img)', function(e) {
                    e.preventDefault();
                    var link = e.currentTarget.getAttribute('href');
                    $('#spaImageModal').html('<div class=\"imageModal\"><img src=\"'+link+'\"></div>');
                    addBodyStyle('hidden');
                });        
            }
            $('#spaImageModal').on('click', '.imageModal', function(e) {
                var link = null;
                $('#spaImageModal').html('');
                addBodyStyle('auto');
            });
            if (container != null) {
                container.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (!e.target.classList.contains('spaCurrent') && $(e.target).is('a')) {
                        var name = e.target.getAttribute('data-name');
                        var data = {name:name, section:section},
                            pushUrl = '".$url."' + data['name'],
                            loadUrl = '".$url."spa/page?p=' + data['name'];
                        $(this).request('onSessionPage', {data: {name: data['name'], section: data['section']}});
                        addCurrentClass(data['name'],data['section']);
                        history.pushState(data, null, null);
                        requestContent(loadUrl,data['section']);
                        document.title = 'Spa | ' + data['name'];
                    }
                    e.stopPropagation();
                }, false);
            }
            window.addEventListener('popstate', function(e) {
                var data = e.state;
                console.log(data);
                if (data === null) {
                    var loadUrl = '".$url."spa/page?p=".$default."';
                    removeCurrentClass();
                    addCurrentClass('".$default."', section);
                    $('#'+section+' .content').load(loadUrl);
                    document.title = defaultTitle;
                } else {
                    var loadUrl = '".$url."spa/page?p=' + data['name'];
                    requestContent(loadUrl,data['section']);
                    addCurrentClass(data['name'],data['section']);
                    document.title = 'Spa | ' + data['name'];
                }
            })
        })(); 
    ";
})->middleware(['web']);