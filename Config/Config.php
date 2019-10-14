<?php

    namespace Config;

    define("ROOT", dirname(__DIR__) . "/");
    //Path to your project's root folder
    define("FRONT_ROOT", "/MoviePass/");
    define("VIEWS_PATH", "Views/");
    define("LIBS_PATH", VIEWS_PATH . "assets/libs/");
	define("IMG_PATH", FRONT_ROOT . VIEWS_PATH . "assets/img/");
	define("CSS_PATH", FRONT_ROOT . VIEWS_PATH . "assets/css/");
    define("JS_PATH", FRONT_ROOT . VIEWS_PATH . "assets/js/");
	define('VIDEO_PATH', FRONT_ROOT . VIEWS_PATH . "assets/video/");
    define("IMG_PATH_TMDB", "https://image.tmdb.org/t/p/original/");

?>
