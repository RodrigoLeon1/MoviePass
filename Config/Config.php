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
	define("UPLOADS_PATH", "uploads/");
	define("IMG_UPLOADS_PATH", FRONT_ROOT . "uploads/");

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
	define("DB_ERROR", "An error has ocurred. Try later!");

	define("CINEMA_EXIST", "This cinema has already been registered.");
	define("CINEMA_ADDED", "Cinema added with success.");
	define("CINEMA_DISABLE", "Cinema disable with success.");
	define("CINEMA_ENABLE", "Cinema enable with success.");
	define("CINEMA_MODIFY", "Cinema modified with success.");
	define("CINEMA_HAS_SHOWS", "Can't disable the cinema because has next shows.");

	define("CINEMA_ROOM_EXIST", "This cinema room has already been registered in this cinema.");
	define("CINEMA_ROOM_ADDED", "Cinema room added with success.");
	define("CINEMA_ROOM_DISABLE", "Cinema room disable with success.");
	define("CINEMA_ROOM_ENABLE", "Cinema room enable with success.");
	define("CINEMA_ROOM_MODIFY", "Cinema room modified with success.");
	define("CINEMA_ROOM_HAS_SHOWS", "Can't disable the cinema room because has next shows.");

	define("MOVIE_ADDED", "Movie added with success.");
	define("MOVIE_EXIST", "This movie has already been registered.");
	define("MOVIE_DISABLE", "Movie disable with success.");
	define("MOVIE_ENABLE", "Movie enable with success.");
	define("MOVIES_NULL", "No movies found");
	define("MOVIE_HAS_SHOWS", "Can't disable the movie because has next shows.");

	define("SHOW_ADDED", "Show added with success.");
	define("SHOW_DISABLE", "Show disable with success.");
	define("SHOW_ENABLE", "Show enable with success.");
	define("SHOW_ERROR", "Can't add the show! Check the date, hour or the movie and try again.");
	define("SHOW_CHECK_DAY", "The show must be at least one day anticipation.");
	define("SHOW_EXIST", "This show has already been registered.");	
	
	define("USER_ADDED", "User added with success.");
	define("USER_DISABLE", "User disable with success.");
	define("USER_ENABLE", "User enable with success.");
	define("ACCOUNT_DISABLE", "Your account is disabled at the moment. Contact the admin.");
	define("ELIMINATE_YOURSELF", "You can't disable yourself.");

	define("LOGIN_NEEDED", "Please! Login to continue.");
	define("LOGIN_ERROR", "You have entered an invalid e-mail or password. Try again!");	
	define("REGISTER_ERROR", "This email address has already been registered.");
	define("EMPTY_FIELDS", "Complete all the fields correctly to continue.");
?>
