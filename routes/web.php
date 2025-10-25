<?php

foreach ([
    __DIR__ . '/controllers/home.php',
    __DIR__ . '/controllers/answer.php',
    __DIR__ . '/controllers/question.php',
    __DIR__ . '/controllers/tag.php',
    __DIR__ . '/controllers/user.php',
    __DIR__ . '/controllers/comment.php',
    __DIR__ . '/controllers/admin_post.php',
] as $controllerRouteFile) {
    require $controllerRouteFile;
}
