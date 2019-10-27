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

	//DB
	define("DB_HOST", "localhost");
	define("DB_NAME", "moviepass");
	define("DB_USER", "root");
	define("DB_PASS", "");
	
	//API TMDB
	define("URL_TMDB", "https://api.themoviedb.org/3");
	define("TOKEN_TMDB", "5d5fe41bdf62bea9ea2f194984b9ad74");
	define("SLASH_MOVIE_TMDB", "/movie");
	define("LANGUAGE_TMDB", "&language=en-US");
	define("PAGE_TMDB", "&page=");
	define("IMG_PATH_TMDB", "https://image.tmdb.org/t/p/original/");

	define("API_N", "5d5fe41bdf62bea9ea2f194984b9ad74");
	define("NOW_PLAYING_PATH", "https://api.themoviedb.org/3/movie/now_playing?api_key=" . API_N . "&language=en-US&page=1");

	//ERROR -- No se si es la mejor forma de hacerlo
	define("CINEMA_EXIST", "This cinema has already been registered.");
	define("MOVIE_EXIST", "This movie has already been registered.");
	// define(" ", " ");
	define("LOGIN_ERROR", "You have entered an invalid e-mail or password. Try again!");
	define("REGISTER_ERROR", "This email address has already been registered.");
?>
