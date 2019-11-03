<?php

    namespace Config;

    //Path to your project's root folder
    define("ROOT", dirname(__DIR__) . "/");
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
	define("IMG_PATH_TMDB", "https://image.tmdb.org/t/p/original/");
	define("API_N", "5d5fe41bdf62bea9ea2f194984b9ad74");
	define("URL_API_LANGUAGE", "&language=en-US");

	define("NOW_PLAYING_PATH", "https://api.themoviedb.org/3/movie/now_playing?api_key=" . API_N . URL_API_LANGUAGE . "&page=1");
	define("COMING_SOON_PATH", "https://api.themoviedb.org/3/movie/upcoming?api_key=" . API_N . URL_API_LANGUAGE . "&page=1");
	define("MOVIE_DETAILS_PATH", "https://api.themoviedb.org/3/movie/");

	//ERR MSGS
	define("CINEMA_EXIST", "This cinema has already been registered.");
	define("CINEMA_ADDED", "Cinema added with success.");
	define("CINEMA_REMOVE", "The cinema was remove with success.");
	define("CINEMA_MODIFY", "The cinema was modified with success.");

	define("MOVIE_ADDED", "Movie added with success.");
	define("MOVIE_EXIST", "This movie has already been registered.");

	define("SHOW_ADDED", "Show added with success.");
	define("SHOW_EXIST", "This show has already been registered.");	
	
	define("USER_ADDED", "User added with success.");
	define("USER_REMOVE", "User was remove with success.");
	define("ELIMINATE_YOURSELF", "You can't eliminate yourself.");

	define("LOGIN_NEEDED", "Please! Login to continue.");
	define("LOGIN_ERROR", "You have entered an invalid e-mail or password. Try again!");	
	define("REGISTER_ERROR", "This email address has already been registered.");
	define("EMPTY_FIELDS", "Complete all the fields correctly to continue.");
?>
