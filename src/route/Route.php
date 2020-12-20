<?php

$router->get('/', "Posts:index", 'posts.index');

$router->get(
    '/posts', function () {
        echo 'tout les articles';
    }
);

$router->get('/post/:slug-:id', "Posts:show", 'posts.show')->with('id', '[0-9]+')->with('slug', '[a-z\-0-9]+');

$router->post(
    '/post/:id', function ($id) {
        echo 'article:'.$id;
    }
);

