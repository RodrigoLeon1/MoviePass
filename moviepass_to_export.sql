-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-11-2019 a las 15:31:00
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `moviepass`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemaRooms_deleteById` (IN `id` INT)  BEGIN
	DELETE FROM `cinema_rooms` WHERE `cinema_rooms`.`id` = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemaRooms_GetAll` ()  BEGIN
	SELECT 
		cinema_rooms.id as cinema_room_id,
		cinema_rooms.name as cinema_room_name,
		cinema_rooms.capacity as cinema_room_capacity,
		cinema_rooms.price as cinema_room_price,
		cinemas.id as cinema_id,
		cinemas.name as cinema_name,
		cinemas.address as cinema_address
	FROM cinema_rooms
	INNER JOIN cinemas ON cinema_rooms.FK_id_cinema = cinemas.id
	ORDER BY cinemas.name ASC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemaRooms_getById` (IN `id` INT)  BEGIN
	SELECT * FROM `cinema_rooms` WHERE `cinema_rooms`.`id` = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemaRooms_getByIdShow` (IN `id` INT)  BEGIN
	SELECT * FROM `cinema_rooms`
	INNER JOIN shows ON shows.FK_id_cinemaRoom = cinema_rooms.id
	WHERE shows.id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemaRooms_getByName` (IN `name` VARCHAR(255))  BEGIN
	SELECT * FROM `cinema_rooms` WHERE `cinema_rooms`.`name` = name;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemaRooms_getByNameAndCinema` (IN `name` VARCHAR(255), IN `id_cinema` INT)  BEGIN
	SELECT * FROM `cinema_rooms` WHERE `cinema_rooms`.`name` = `name` AND `cinema_rooms`.`FK_id_cinema` = `id_cinema`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemaRooms_hasShows` (IN `id` INT)  BEGIN
	SELECT *
	FROM cinema_rooms
	INNER JOIN shows ON cinema_rooms.id = shows.FK_id_cinemaRoom
	WHERE cinema_rooms.id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemaRooms_modify` (IN `id` INT, IN `name` VARCHAR(255), IN `capacity` INT, IN `price` INT)  BEGIN
	UPDATE cinema_rooms SET cinema_rooms.name = name, cinema_rooms.address = address,cinema_rooms.capacity = capacity, cinema_rooms.price = price  WHERE cinema_rooms.id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemas_add` (IN `name` VARCHAR(255), IN `address` VARCHAR(255))  BEGIN
	INSERT INTO cinemas (
			cinemas.name,
			cinemas.address
	)
    VALUES
        (name, address);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemas_deleteById` (IN `id` INT)  BEGIN
	DELETE FROM `cinemas` WHERE `cinemas`.`id` = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemas_GetAll` ()  BEGIN
	SELECT * FROM `cinemas`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemas_getById` (IN `id` INT)  BEGIN
	SELECT * FROM `cinemas` WHERE `cinemas`.`id` = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemas_getByName` (IN `name` VARCHAR(255))  BEGIN
	SELECT * FROM `cinemas` WHERE `cinemas`.`name` = name;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemas_hasShows` (IN `id_cinema` INT)  BEGIN
	SELECT *
	FROM cinemas
	INNER JOIN cinema_rooms ON cinemas.id = cinema_rooms.FK_id_cinema
	INNER JOIN shows ON cinema_rooms.id = shows.FK_id_cinemaRoom
	WHERE cinemas.id = id_cinema;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemas_modify` (IN `id` INT, IN `name` VARCHAR(255), IN `address` VARCHAR(255))  BEGIN
	UPDATE cinemas SET cinemas.name = name, cinemas.address = address WHERE cinemas.id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinema_rooms_add` (IN `name` VARCHAR(255), IN `price` INT, IN `capacity` INT, IN `id_cinema` INT)  BEGIN
	INSERT INTO cinema_rooms (
			cinema_rooms.name,
			cinema_rooms.price,
			cinema_rooms.capacity,
			cinema_rooms.FK_id_cinema
	)
    VALUES
        (name, price, capacity, id_cinema);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `genreMovie_add` (IN `FK_gxm_id_genre` INT, IN `FK_gxm_id_movie` INT)  BEGIN
	INSERT INTO genres_x_movies (
			genres_x_movies.FK_gxm_id_genre,
			genres_x_movies.FK_gxm_id_movie)
    VALUES
        (FK_gxm_id_genre, FK_gxm_id_movie);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `genresxmovies_add` (IN `FK_id_genre` INT, IN `FK_id_movie` INT)  BEGIN
	INSERT INTO genres_x_movies (
			genres_x_movies.FK_id_genre,
			genres_x_movies.FK_id_movie
	)
    VALUES
        (FK_id_genre, FK_id_movie);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `genresxmovies_getByDate` (IN `date_show` DATE)  BEGIN
    SELECT     movies.id,
            movies.popularity,
            movies.vote_count,
            movies.video,
            movies.poster_path,
            movies.adult,
            movies.backdrop_path,
            movies.original_language,
            movies.original_title,
            movies.genre_ids,
            movies.title,
            movies.vote_average,
            movies.overview,
            movies.release_date
    FROM genres_x_movies
    INNER JOIN movies ON FK_id_movie = movies.id 
    INNER JOIN shows ON movies.id = shows.FK_id_movie
    WHERE (shows.date_start = date_show)
    GROUP BY movies.id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `genresxmovies_getByGenre` (IN `id_genre` INT)  BEGIN
	SELECT 	movies.id,
			movies.popularity,
			movies.vote_count,
			movies.video,
			movies.poster_path,
			movies.adult,
			movies.backdrop_path,
			movies.original_language,
			movies.original_title,
			movies.genre_ids,
			movies.title,
			movies.vote_average,
			movies.overview,
			movies.release_date
	FROM genres_x_movies
	INNER JOIN movies ON genres_x_movies.FK_id_movie = movies.id 
	INNER JOIN shows ON movies.id = shows.FK_id_movie
	WHERE (genres_x_movies.FK_id_genre = id_genre)
	GROUP BY movies.id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `genresxmovies_getByGenreAndDate` (IN `id_genre` INT, IN `date_show` DATE)  BEGIN
    SELECT     movies.id,
            movies.popularity,
            movies.vote_count,
            movies.video,
            movies.poster_path,
            movies.adult,
            movies.backdrop_path,
            movies.original_language,
            movies.original_title,
            movies.genre_ids,
            movies.title,
            movies.vote_average,
            movies.overview,
            movies.release_date,
            movies.runtime
    FROM genres_x_movies
    INNER JOIN movies ON FK_id_movie = movies.id 
    INNER JOIN shows ON movies.id = shows.FK_id_movie
    WHERE (FK_id_genre = id_genre AND shows.date_start = date_show)
    GROUP BY movies.id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `genresxmovies_getGenresOfMovie` (IN `id_movie` INT)  BEGIN
	SELECT 	*
	FROM genres_x_movies
	INNER JOIN movies ON movies.id = FK_id_movie
	INNER JOIN genres ON FK_id_genre = genres.id						
	WHERE (FK_id_movie = id_movie);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `genresxmovies_getGenresOfShows` ()  BEGIN
	SELECT 	genres.name, genres.id
	FROM genres_x_movies
	INNER JOIN movies ON movies.id = genres_x_movies.FK_id_movie
	INNER JOIN genres ON genres_x_movies.FK_id_genre = genres.id
	INNER JOIN shows ON shows.FK_id_movie = genres_x_movies.FK_id_movie						
	WHERE (genres_x_movies.FK_id_movie = shows.FK_id_movie)
	GROUP BY genres.name;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `genres_add` (IN `id` INT, IN `name` VARCHAR(255))  BEGIN
	INSERT INTO genres (
			genres.id,
			genres.name
	)
    VALUES
        (id, name);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `genres_GetAll` ()  BEGIN
    SELECT * 
    FROM genres 
	ORDER BY name ASC; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `genres_getById` (IN `id` INT)  BEGIN
	SELECT 	genres.name,
			genres.id
	FROM genres
    WHERE (genres.id = id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `genres_getByName` (IN `name` VARCHAR(255))  BEGIN
	SELECT 	genres.name,
			genres.id
	FROM genres
    WHERE (genres.name = name);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `genres_x_movies_getByGenre` (IN `id_genre` INT)  BEGIN
	SELECT 	movies.id,
			movies.popularity,
			movies.vote_count,
			movies.video,
			movies.poster_path,
			movies.adult,
			movies.backdrop_path,
			movies.original_language,
			movies.original_title,
			movies.genre_ids,
			movies.title,
			movies.vote_average,
			movies.overview,
			movies.release_date
	FROM genres_x_movies
	INNER JOIN movies ON genres_x_movies.FK_id_movie = movies.id 
	INNER JOIN shows ON movies.id = shows.FK_id_movie
	WHERE (genres_x_movies.FK_id_genre = id_genre)
	GROUP BY movies.id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movies_add` (IN `id` INT, IN `popularity` VARCHAR(255), IN `vote_count` VARCHAR(255), IN `video` VARCHAR(255), IN `poster_path` VARCHAR(255), IN `adult` VARCHAR(255), IN `backdrop_path` VARCHAR(255), IN `original_language` VARCHAR(255), IN `original_title` VARCHAR(255), IN `genre_ids` VARCHAR(255), IN `title` VARCHAR(255), IN `vote_average` VARCHAR(255), IN `overview` VARCHAR(255), IN `release_date` DATE)  BEGIN
	INSERT INTO movies (
			movies.id,
			movies.popularity,
			movies.vote_count,
			movies.video,
			movies.poster_path,
			movies.adult,
			movies.backdrop_path,
			movies.original_language,
			movies.original_title,
			movies.genre_ids,
			movies.title,
			movies.vote_average,
			movies.overview,
			movies.release_date
	)
    VALUES
        (id, popularity, vote_count, video, poster_path, adult, backdrop_path, original_language, original_title, genre_ids, title, vote_average, overview, release_date);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movies_add_details` (IN `id` INT, IN `popularity` VARCHAR(255), IN `vote_count` VARCHAR(255), IN `video` VARCHAR(255), IN `poster_path` VARCHAR(255), IN `adult` VARCHAR(255), IN `backdrop_path` VARCHAR(255), IN `original_language` VARCHAR(255), IN `original_title` VARCHAR(255), IN `title` VARCHAR(255), IN `vote_average` VARCHAR(255), IN `overview` VARCHAR(255), IN `release_date` DATE, IN `runtime` INT)  BEGIN
	INSERT INTO movies (
			movies.id,
			movies.popularity,
			movies.vote_count,
			movies.video,
			movies.poster_path,
			movies.adult,
			movies.backdrop_path,
			movies.original_language,
			movies.original_title,			
			movies.title,
			movies.vote_average,
			movies.overview,
			movies.release_date,
			movies.runtime
	)
    VALUES
        (id, popularity, vote_count, video, poster_path, adult, backdrop_path, original_language, original_title, title, vote_average, overview, release_date, runtime);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movies_add_runtime` (IN `id` INT, IN `runtime` INT)  BEGIN
	UPDATE movies
	SET movies.runtime = runtime
	WHERE movies.id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movies_deleteById` (IN `id` INT)  BEGIN
	DELETE FROM `movies` WHERE `movies`.`id` = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movies_getAll` ()  BEGIN
	SELECT * FROM `movies` ORDER BY title ASC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movies_getById` (IN `id` INT)  BEGIN
	SELECT * FROM `movies` WHERE `movies`.`id` = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movies_getByTitle` (IN `title` VARCHAR(255))  BEGIN
	SELECT
		movies.id AS movie_id
	FROM movies 
	INNER JOIN shows ON movies.id = shows.FK_id_movie
	WHERE movies.title = title;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movies_hasShows` (IN `id_movie` INT)  BEGIN
	SELECT *
	FROM movies
	INNER JOIN shows ON movies.id = shows.FK_id_movie
	WHERE movies.id = id_movie;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `profile_users_add` (IN `dni` INT, IN `first_name` VARCHAR(255), IN `last_name` VARCHAR(255))  BEGIN
	INSERT INTO profile_users (
			profile_users.dni,
			profile_users.first_name,
			profile_users.last_name
	)
    VALUES
        (dni, first_name, last_name);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `purchases_Add` (IN `ticket_quantity` INT, IN `discount` INT, IN `date` DATE, IN `total` INT, IN `dni_user` INT)  BEGIN
    INSERT INTO purchases(purchases.ticket_quantity, purchases.discount, purchases.date, purchases.total, purchases.FK_dni)
    VALUES (ticket_quantity, discount, date, total, dni_user);	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `purchases_GetAll` ()  BEGIN
	SELECT purchases.id_purchase AS purchases_id_purchase,
           purchases.ticket_quantity AS purchases_ticket_quantity,
           purchases.discount AS purchases_discount,
           purchases.date AS purchases_date,
           purchases.total AS purchases_total,
           purchases.FK_dni AS purchases_FK_dni
	FROM purchases;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `purchases_GetByDni` (IN `dni` INT)  BEGIN 
    SELECT purchases.id_purchase AS purchases_id_purchase,
           purchases.ticket_quantity AS purchases_ticket_quantity,
           purchases.discount AS purchases_discount,
           purchases.date AS purchases_date,
           purchases.total AS purchases_total,
           purchases.FK_dni AS purchases_FK_dni
    FROM purchases
    WHERE(purchases.FK_dni = dni);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `purchases_GetById` (IN `id` INT)  BEGIN 
    SELECT purchases.id_purchase AS purchases_id_purchase,
           purchases.ticket_quantity AS purchases_ticket_quantity,
           purchases.discount AS purchases_discount,
           purchases.date AS purchases_date,
           purchases.total AS purchases_total,
           purchases.FK_dni AS purchases_FK_dni
    FROM purchases
    WHERE(purchases.id_purchase = id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `roles_getAll` ()  BEGIN
	SELECT *
    FROM roles;    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `roles_getById` (IN `id` INT)  BEGIN
	SELECT roles.id, roles.description
    FROM roles
    WHERE (roles.id = id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `shows_add` (IN `FK_id_cinemaRoom` INT, IN `FK_id_movie` INT, IN `date_start` DATE, IN `time_start` DATE, IN `date_end` DATE, IN `time_end` DATE)  BEGIN
	INSERT INTO shows (
			shows.FK_id_cinemaRoom,
			shows.FK_id_movie,
			shows.date_start,
			shows.time_start,
			shows.date_end,
			shows.time_end
	)
    VALUES
        (FK_id_cinemaRoom, FK_id_movie, date_start, time_start, date_end, time_end);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `shows_deleteById` (IN `id` INT)  BEGIN
	DELETE FROM `shows` WHERE `shows`.`id` = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `shows_getAll` ()  BEGIN
	SELECT 	shows.id AS shows_id,
			shows.date_start AS shows_date_start,
			shows.time_start AS shows_time_start,
			shows.date_end AS shows_date_end,
			shows.time_end AS shows_time_end,
			movies.id AS movies_id,
			movies.title AS movies_title,
			cinema_rooms.id AS cinema_rooms_id,
			cinema_rooms.name AS cinema_rooms_name,
			cinemas.name AS cinema_name
	FROM `shows`
	INNER JOIN movies ON movies.id = shows.FK_id_movie
	INNER JOIN cinema_rooms ON cinema_rooms.id = shows.FK_id_cinemaRoom
	INNER JOIN cinemas ON cinemas.id = cinema_rooms.FK_id_cinema
	ORDER BY movies.title ASC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `shows_getByCinemaId` (IN `id_movie` INT)  BEGIN
	SELECT 	*
	FROM `shows`
	WHERE (shows.FK_id_cinema = id_movie);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `shows_getByCinemaRoomId` (IN `id_cinemaRoom` INT)  BEGIN
	SELECT 	*
	FROM `shows`
	WHERE (shows.FK_id_cinemaRoom = id_cinemaRoom);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `shows_getById` (IN `id` INT)  BEGIN
	SELECT 	shows.id AS shows_id,
			shows.date_start AS shows_date_start,
			shows.time_start AS shows_time_start,
			shows.date_end AS shows_date_end,
			shows.time_end AS shows_time_end,
			movies.id AS movies_id,
			movies.title AS movies_title,
            movies.backdrop_path AS movies_backdrop_path,
			cinema_rooms.id AS cinema_rooms_id,
			cinema_rooms.name AS cinema_rooms_name,
            cinema_rooms.capacity AS cinema_rooms_capacity,
            cinema_rooms.price AS cinema_rooms_price,
			cinemas.name AS cinema_name,
			cinemas.address AS cinema_address
	FROM `shows`
	INNER JOIN movies ON movies.id = shows.FK_id_movie
	INNER JOIN cinema_rooms ON cinema_rooms.id = shows.FK_id_cinemaRoom
	INNER JOIN cinemas ON cinemas.id = cinema_rooms.FK_id_cinema
	WHERE (shows.id = id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `shows_getByMovieId` (IN `id_movie` INT)  BEGIN
	SELECT 	*
	FROM `shows`
	WHERE (shows.FK_id_movie = id_movie);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `shows_getShowsOfMovie` (IN `id_movie` INT)  BEGIN
	SELECT 
		shows.id as show_id,
		shows.date_start as show_date_start,
		shows.time_start as show_time_start,
		cinema_rooms.name as cinema_rooms_name,
		cinemas.name as cinema_name,
		cinemas.address as cinema_address
	FROM shows 
	INNER JOIN 
		movies ON shows.FK_id_movie = movies.id
	INNER JOIN 
		cinema_rooms ON cinema_rooms.id = shows.FK_id_cinemaRoom
	INNER JOIN
		cinemas ON cinemas.id = cinema_rooms.FK_id_cinema
	WHERE ( (shows.FK_id_movie = id_movie) AND (shows.date_start >= curdate()) ) 
	ORDER BY shows.date_start ASC, shows.time_start ASC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `shows_modify` (IN `id` INT, IN `id_cinemaRoom` INT, IN `id_movie` INT, IN `date_start` DATE, IN `time_start` TIME, IN `date_end` DATE, IN `time_end` TIME)  BEGIN
	UPDATE shows SET shows.	FK_id_cinemaRoom = id_cinemaRoom, shows.FK_id_movie = id_movie, shows.date_start = date_start, shows.time_start = time_start, shows.date_end = date_end, shows.time_end = time_end WHERE shows.id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tickets_Add` (IN `id_purchase` INT, IN `id_show` INT)  BEGIN
    INSERT INTO tickets(tickets.FK_id_purchase, tickets.FK_id_show)
    VALUES (id_purchase, id_show);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tickets_GetAll` ()  BEGIN
	SELECT tickets.ticket_number AS tickets_ticket_number,
           tickets.QR AS tickets_QR,
           tickets.FK_id_purchase AS tickets_FK_id_purchase,
           tickets.FK_id_show AS tickets_FK_id_show
	FROM tickets;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tickets_GetByNumber` (IN `number` INT)  BEGIN
    SELECT tickets.ticket_number AS tickets_ticket_number,
           tickets.QR AS tickets_QR,
           tickets.FK_id_purchase AS tickets_FK_id_purchase,
           shows.FK_id_show AS shows_FK_id_show
    FROM tickets
    WHERE(tickets.ticket_number = number);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tickets_GetByShowId` (IN `id_show` INT)  BEGIN
    SELECT *
    FROM tickets
    WHERE(tickets.FK_id_show = id_show);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tickets_GetInfoTicket` ()  BEGIN
	SELECT 
		shows.id AS show_id,
		shows.date_start AS show_date_start,
		shows.time_start AS show_time_start,
		cinemas.name AS cinema_name,
		cinemas.id AS cinema_id,
		cinema_rooms.name AS cinema_room_name,
		movies.title AS movie_title	
	FROM tickets 
	INNER JOIN shows ON tickets.FK_id_show = shows.id
	INNER JOIN purchases ON tickets.FK_id_purchase = purchases.id_purchase
	INNER JOIN cinema_rooms ON shows.FK_id_cinemaRoom = cinema_rooms.id
	INNER JOIN cinemas ON cinemas.id = cinema_rooms.FK_id_cinema
	INNER JOIN movies ON shows.FK_id_movie = movies.id
	GROUP BY shows.id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tickets_getTicketsOfCinema` (IN `id_cinema` INT)  BEGIN	
	SELECT 		
		count(tickets.FK_id_show) AS count_tickets,
		cinema_rooms.name,
		cinema_rooms.price
	FROM tickets
	INNER JOIN shows ON tickets.FK_id_show = shows.id
	INNER JOIN movies ON shows.FK_id_movie = movies.id
	INNER JOIN cinema_rooms ON shows.FK_id_cinemaRoom = cinema_rooms.id
	INNER JOIN cinemas ON cinema_rooms.FK_id_cinema = cinemas.id
	WHERE cinemas.id = id_cinema
	GROUP BY cinema_rooms.id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tickets_getTicketsOfCinemaRoom` (IN `id_cinema_room` INT)  BEGIN	
	SELECT 		
		count(tickets.FK_id_show) AS count_tickets,
		cinema_rooms.name,
		cinema_rooms.price
	FROM tickets
	INNER JOIN shows ON tickets.FK_id_show = shows.id
	INNER JOIN movies ON shows.FK_id_movie = movies.id
	INNER JOIN cinema_rooms ON shows.FK_id_cinemaRoom = cinema_rooms.id
	INNER JOIN cinemas ON cinema_rooms.FK_id_cinema = cinemas.id
	WHERE cinema_rooms.id = id_cinema_room
	GROUP BY cinema_rooms.id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tickets_getTicketsOfMovie` (IN `id_movie` INT)  BEGIN	
		SELECT 		
			count(tickets.FK_id_show) AS count_tickets,
			cinema_rooms.name,
			cinema_rooms.price
		FROM tickets
		INNER JOIN shows ON tickets.FK_id_show = shows.id
		INNER JOIN movies ON shows.FK_id_movie = movies.id
		INNER JOIN cinema_rooms ON shows.FK_id_cinemaRoom = cinema_rooms.id
		WHERE movies.id = id_movie
		GROUP BY cinema_rooms.id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tickets_getTicketsOfShows` (IN `id_show` INT)  BEGIN
	SELECT
		count(FK_id_show)
	FROM tickets
	WHERE tickets.FK_id_show = id_show;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `users_deleteByDni` (IN `dni` INT)  BEGIN
	DELETE FROM `users` WHERE `users`.`FK_dni` = dni;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `users_getAll` ()  BEGIN
	SELECT 	users.mail,
			users.password,
			users.FK_id_role,
			profile_users.dni,
			profile_users.first_name,
			profile_users.last_name
	FROM users
	INNER JOIN profile_users ON users.FK_dni = profile_users.dni
	ORDER By profile_users.dni;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `users_getByMail` (IN `mail` VARCHAR(255))  BEGIN
	SELECT 	users.mail,
			users.password,
			users.FK_id_role,
			profile_users.dni,
			profile_users.first_name,
			profile_users.last_name
	FROM users
	INNER JOIN profile_users ON users.FK_dni = profile_users.dni
    WHERE (users.mail = mail);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cinemas`
--

CREATE TABLE `cinemas` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cinemas`
--

INSERT INTO `cinemas` (`id`, `name`, `address`) VALUES
(10, 'Paseo Aldrey', 'Sarmiento 2685'),
(11, 'Ambassador', 'Cordoba DVi'),
(12, 'CinemaCenter', 'Diag. Pueyrredon 3050'),
(13, 'Cinema II', 'Los Gallegos Shopping'),
(14, 'Cine del Paseo', 'Diagonal Pueyrredon');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cinema_rooms`
--

CREATE TABLE `cinema_rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `price` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `FK_id_cinema` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `cinema_rooms`
--

INSERT INTO `cinema_rooms` (`id`, `name`, `price`, `capacity`, `FK_id_cinema`) VALUES
(11, 'Sala 1', 50, 120, 10),
(12, 'Sala 1', 30, 160, 11),
(13, 'Sala 2', 55, 5, 10),
(14, 'Sala 3', 15, 15, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(12, 'Adventure'),
(14, 'Fantasy'),
(16, 'Animation'),
(18, 'Drama'),
(27, 'Horror'),
(28, 'Action'),
(35, 'Comedy'),
(36, 'History'),
(37, 'Western'),
(53, 'Thriller'),
(80, 'Crime'),
(99, 'Documentary'),
(878, 'Science Fiction'),
(9648, 'Mystery'),
(10402, 'Music'),
(10749, 'Romance'),
(10751, 'Family'),
(10752, 'War'),
(10770, 'TV Movie');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genres_x_movies`
--

CREATE TABLE `genres_x_movies` (
  `FK_id_genre` int(11) DEFAULT NULL,
  `FK_id_movie` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `genres_x_movies`
--

INSERT INTO `genres_x_movies` (`FK_id_genre`, `FK_id_movie`) VALUES
(80, 475557),
(18, 475557),
(53, 475557),
(28, 290859),
(878, 290859),
(12, 420809),
(14, 420809),
(10751, 420809),
(80, 559969),
(18, 559969),
(53, 559969),
(28, 568012),
(12, 568012),
(16, 568012),
(12, 480105),
(18, 480105),
(27, 480105),
(53, 480105),
(28, 338967),
(35, 338967),
(27, 338967),
(27, 501170),
(35, 521777),
(27, 417384),
(53, 417384),
(27, 474350),
(28, 453405),
(53, 453405),
(16, 481084),
(35, 481084),
(14, 481084),
(10751, 481084),
(12, 454640),
(16, 454640),
(35, 454640),
(10751, 454640),
(80, 398978),
(18, 398978),
(28, 458156),
(80, 458156),
(53, 458156),
(35, 515195),
(14, 515195),
(10402, 515195),
(10749, 515195),
(12, 157336),
(18, 157336),
(878, 157336),
(9648, 77),
(53, 77);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `popularity` varchar(255) NOT NULL,
  `vote_count` varchar(255) NOT NULL,
  `video` varchar(255) NOT NULL,
  `poster_path` varchar(255) NOT NULL,
  `adult` varchar(255) NOT NULL,
  `backdrop_path` varchar(255) NOT NULL,
  `original_language` varchar(255) NOT NULL,
  `original_title` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `vote_average` varchar(255) NOT NULL,
  `overview` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `release_date` date NOT NULL,
  `runtime` int(11) DEFAULT NULL,
  `genre_ids` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `movies`
--

INSERT INTO `movies` (`id`, `popularity`, `vote_count`, `video`, `poster_path`, `adult`, `backdrop_path`, `original_language`, `original_title`, `title`, `vote_average`, `overview`, `release_date`, `runtime`, `genre_ids`) VALUES
(77, '15.923', '8417', '', '/fQMSaP88cf1nz4qwuNEEFtazuDM.jpg', '', '/q2CtXYjp9IlnfBcPktNkBPsuAEO.jpg', 'en', 'Memento', 'Memento', '8.2', 'Leonard Shelby is tracking down the man who raped and murdered his wife. The difficulty of locating his wife\'s killer, however, is compounded by the fact that he suffers from a rare, untreatable form of short-term memory loss. Although he can recall detai', '2000-10-11', 113, NULL),
(157336, '41.105', '19972', '', '/nBNZadXqJSdt05SHLqgT0HuC5Gm.jpg', '', '/xu9zaAevzQ5nnrsXN6JcahLnG4i.jpg', 'en', 'Interstellar', 'Interstellar', '8.3', 'Interstellar chronicles the adventures of a group of explorers who make use of a newly discovered wormhole to surpass the limitations on human space travel and conquer the vast distances involved in an interstellar voyage.', '2014-11-05', 169, 0),
(290859, '315.137', '159', '', '/vqzNJRH4YyquRiWxCCOH0aXggHI.jpg', '', '/a6cDxdwaQIFjSkXf7uskg78ZyTq.jpg', 'en', 'Terminator: Dark Fate', 'Terminator: Dark Fate', '6.6', 'More than two decades have passed since Sarah Connor prevented Judgment Day, changed the future, and re-wrote the fate of the human race. Dani Ramos is living a simple life in Mexico City with her brother and father when a highly advanced and deadly new T', '2019-11-01', 128, 0),
(295151, '95.424', '125', '', '/tXTccijjTnpXWFEMaHC1gp59cNc.jpg', '', '/9REB0BCTk2RueTj5PuELYRYJN5e.jpg', 'en', 'Let It Snow', 'Let It Snow', '6.3', 'When a huge blizzard (that doesn\'t show signs of stopping) hits, Gracetown is completely snowed in. But even though it\'s cold outside, things are heating up inside, proving that Christmas is magical when it comes to love.', '2019-11-08', 93, 0),
(338967, '99.847', '213', '', '/pIcV8XXIIvJCbtPoxF9qHMKdRr2.jpg', '', '/jCCdt0e8Xe9ttvevD4S3TSMNdH.jpg', 'en', 'Zombieland: Double Tap', 'Zombieland: Double Tap', '7.5', 'The group will face a new zombie threat as a new breed of zombie has developed. This new super-zombie type is faster, bigger, and stronger than the previous strain of zombies and harder to kill. These super-zombies have started grouping up into a horde go', '2019-10-18', 99, 0),
(398978, '53.593', '7', '', '/eXH2w0Ylh706Rwj6CHFm1FKRBXG.jpg', '', '/aZ1ZqJ4uO1RK5gU5jRsO4qG7rJo.jpg', 'en', 'The Irishman', 'The Irishman', '8.9', 'World War II veteran and mob hitman Frank \"The Irishman\" Sheeran recalls his possible involvement with the slaying of union leader Jimmy Hoffa.', '2019-11-01', 209, 0),
(417384, '90.103', '484', '', '/q5298SICFzqMcKtQoBktk8p6FH.jpg', '', '/qBI3Spq93lNxGzecdGpbwV5lOvU.jpg', 'en', 'Scary Stories to Tell in the Dark', 'Scary Stories to Tell in the Dark', '6.3', 'Mill Valley, Pennsylvania, Halloween night, 1968. After playing a joke on a school bully, Sarah and her friends decide to sneak into a supposedly haunted house that once belonged to the powerful Bellows family, unleashing dark forces that they will be una', '2019-08-09', 108, 0),
(420809, '230.948', '579', '', '/tBuabjEqxzoUBHfbyNbd8ulgy5j.jpg', '', '/skvI4rYFrKXS73BJxWGH54Omlvv.jpg', 'en', 'Maleficent: Mistress of Evil', 'Maleficent: Mistress of Evil', '7.3', 'Maleficent and her goddaughter Aurora begin to question the complex family ties that bind them as they are pulled in different directions by impending nuptials, unexpected allies, and dark new forces at play.', '2019-10-18', 118, 0),
(453405, '94.626', '442', '', '/uTALxjQU8e1lhmNjP9nnJ3t2pRU.jpg', '', '/c3F4P2oauA7IQmy4hM0OmRt2W7d.jpg', 'en', 'Gemini Man', 'Gemini Man', '5.8', 'Henry Brogen, an aging assassin tries to get out of the business but finds himself in the ultimate battle: fighting his own clone who is 25 years younger than him and at the peak of his abilities.', '2019-10-11', 117, 0),
(454640, '59.76', '224', '', '/ebe8hJRCwdflNQbUjRrfmqtUiNi.jpg', '', '/k7sE3loFwuU2mqf7FbZBeE3rjBa.jpg', 'en', 'The Angry Birds Movie 2', 'The Angry Birds Movie 2', '6.5', 'Red, Chuck, Bomb and the rest of their feathered friends are surprised when a green pig suggests that they put aside their differences and unite to fight a common threat. Aggressive birds from an island covered in ice are planning to use an elaborate weap', '2019-08-14', 96, 0),
(458156, '60.831', '3085', '', '/ziEuG1essDuWuC5lpWUaw1uXY2O.jpg', '', '/stemLQMLDrlpfIlZ5OjllOPT8QX.jpg', 'en', 'John Wick: Chapter 3 - Parabellum', 'John Wick: Chapter 3 - Parabellum', '7.1', 'Super-assassin John Wick returns with a $14 million price tag on his head and an army of bounty-hunting killers on his trail. After killing a member of the shadowy international assassin’s guild, the High Table, John Wick is excommunicado, but the world’s', '2019-05-17', 131, 0),
(474350, '108.576', '1800', '', '/zfE0R94v1E8cuKAerbskfD3VfUt.jpg', '', '/8moTOzunF7p40oR5XhlDvJckOSW.jpg', 'en', 'It Chapter Two', 'It Chapter Two', '6.9', '27 years after overcoming the malevolent supernatural entity Pennywise, the former members of the Losers\' Club, who have grown up and moved away from Derry, are brought back together by a devastating phone call.', '2019-09-06', 169, 0),
(475557, '470.723', '4556', '', '/udDclJoHjfjb8Ekgsd4FDteOkCU.jpg', '', '/n6bUvigpRFqSwmPp1m2YADdbRBc.jpg', 'en', 'Joker', 'Joker', '8.5', 'During the 1980s, a failed stand-up comedian is driven insane and turns to a life of crime and chaos in Gotham City while becoming an infamous psychopathic crime figure.', '2019-10-04', 122, 0),
(480105, '96.279', '121', '', '/g4z7mDmJmx23vsVg6XNWcnXb6gc.jpg', '', '/3uG3aOhEzFCjcQulsJQiAzLSrw8.jpg', 'en', '47 Meters Down: Uncaged', '47 Meters Down: Uncaged', '5.2', 'A group of backpackers diving in a ruined underwater city discover that they have stumbled into the territory of the ocean\'s deadliest shark species.', '2019-08-16', 90, 0),
(481084, '80.361', '111', '', '/uaXNjRkDdjfxfVuKHo25wkA6CiA.jpg', '', '/ur4NTeFGZmQ6Hz5uEkAMgPI3WRg.jpg', 'en', 'The Addams Family', 'The Addams Family', '5.9', 'The Addams family\'s lives begin to unravel when they face-off against a treacherous, greedy crafty reality-TV host while also preparing for their extended family to arrive for a major celebration.', '2019-10-11', 86, 0),
(501170, '92.496', '59', '', '/p69QzIBbN06aTYqRRiCOY1emNBh.jpg', '', '/4D4Ic9N4tnwaW4x241LGb1XOi7O.jpg', 'en', 'Doctor Sleep', 'Doctor Sleep', '6.9', 'A traumatized, alcoholic Dan Torrance meets Abra, a kid who also has the ability to \"shine.\" He tries to protect her from the True Knot, a cult whose goal is to feed off people like them in order to remain immortal.', '2019-11-08', 152, 0),
(515195, '64.828', '880', '', '/1rjaRIAqFPQNnMtqSMLtg0VEABi.jpg', '', '/t5Kp02Jzixl0KfpwthHp9ZUex9t.jpg', 'en', 'Yesterday', 'Yesterday', '6.7', 'Jack Malik is a struggling singer-songwriter in an English seaside town whose dreams of fame are rapidly fading, despite the fierce devotion and support of his childhood best friend, Ellie. After a freak bus accident during a mysterious global blackout, J', '2019-06-28', 116, 0),
(521777, '91.718', '279', '', '/tximyCXMEnWIIyOy9STkOduUprG.jpg', '', '/jTwUkBa6BOPypqCx4KcvrYIlAcI.jpg', 'en', 'Good Boys', 'Good Boys', '6.5', 'A group of young boys on the cusp of becoming teenagers embark on an epic quest to fix their broken drone before their parents get home.', '2019-08-16', 89, 0),
(559969, '119.825', '1227', '', '/ePXuKdXZuJx8hHMNr2yM4jY2L7Z.jpg', '', '/ijiE9WoGSwSzM16zTxvUneJ8RXc.jpg', 'en', 'El Camino: A Breaking Bad Movie', 'El Camino: A Breaking Bad Movie', '7.1', 'In the wake of his dramatic escape from captivity, Jesse Pinkman must come to terms with his past in order to forge some kind of future.', '2019-10-11', 123, 0),
(568012, '126.478', '60', '', '/4E2lyUGLEr3yH4q6kJxPkQUhX7n.jpg', '', '/iGnCzXEx0cFlUbpyAMeHwHWhPhx.jpg', 'ja', 'ワンピーススタンピード', 'One Piece: Stampede', '7.6', 'One Piece: Stampede is a stand-alone film that celebrates the anime\'s 20th Anniversary and takes place outside the canon of the \"One Piece\" TV series. Monkey D. Luffy and his Straw Hat pirate crew are invited to a massive Pirate Festival that brings many ', '2019-10-24', 101, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profile_users`
--

CREATE TABLE `profile_users` (
  `dni` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `profile_users`
--

INSERT INTO `profile_users` (`dni`, `first_name`, `last_name`) VALUES
(0, 'user', 'user'),
(2, 'x', 'x'),
(404040, 'Mr pepe', 'Peposo'),
(615124, 'Rodrigo', 'Leon'),
(11111111, 'Rodrigo', 'Leon');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchases`
--

CREATE TABLE `purchases` (
  `id_purchase` int(11) NOT NULL,
  `ticket_quantity` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `date` date NOT NULL,
  `total` int(11) NOT NULL,
  `FK_dni` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `purchases`
--

INSERT INTO `purchases` (`id_purchase`, `ticket_quantity`, `discount`, `date`, `total`, `FK_dni`) VALUES
(1, 4, 0, '2019-11-17', 120, 11111111),
(2, 3, 0, '2019-11-17', 90, 11111111),
(3, 2, 0, '2019-11-17', 60, 11111111),
(4, 2, 0, '2019-11-17', 60, 11111111),
(5, 2, 0, '2019-11-17', 60, 11111111),
(6, 2, 0, '2019-11-17', 60, 11111111),
(7, 2, 0, '2019-11-17', 60, 11111111),
(8, 2, 0, '2019-11-17', 60, 11111111),
(9, 3, 0, '2019-11-17', 90, 11111111),
(10, 5, 0, '2019-11-17', 250, 11111111),
(11, 5, 0, '2019-11-17', 250, 11111111),
(12, 3, 0, '2019-11-17', 150, 11111111),
(13, 3, 0, '2019-11-17', 150, 11111111),
(14, 3, 0, '2019-11-17', 150, 11111111),
(15, 3, 0, '2019-11-17', 150, 11111111),
(16, 3, 0, '2019-11-17', 150, 11111111),
(17, 3, 0, '2019-11-17', 90, 11111111),
(18, 2, 0, '2019-11-17', 60, 0),
(19, 1, 0, '2019-11-17', 30, 11111111),
(20, 159, 0, '2019-11-17', 4770, 11111111),
(21, 3, 0, '2019-11-17', 45, 11111111),
(22, 3, 0, '2019-11-17', 45, 11111111),
(23, 10, 0, '2019-11-17', 500, 11111111),
(24, 4, 0, '2019-11-18', 60, 11111111),
(25, 3, 0, '2019-11-18', 90, 11111111),
(26, 2, 0, '2019-11-18', 60, 11111111),
(27, 5, 0, '2019-11-19', 150, 615124);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `description`) VALUES
(0, 'user'),
(1, 'administrator');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shows`
--

CREATE TABLE `shows` (
  `id` int(11) NOT NULL,
  `FK_id_cinemaRoom` int(11) DEFAULT NULL,
  `FK_id_movie` int(11) DEFAULT NULL,
  `date_start` date NOT NULL,
  `time_start` time NOT NULL,
  `date_end` date NOT NULL,
  `time_end` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `shows`
--

INSERT INTO `shows` (`id`, `FK_id_cinemaRoom`, `FK_id_movie`, `date_start`, `time_start`, `date_end`, `time_end`) VALUES
(1, 12, 480105, '2019-12-31', '23:59:00', '2020-01-01', '01:44:00'),
(2, 12, 521777, '2020-01-01', '00:10:00', '2020-01-01', '01:54:00'),
(3, 12, 480105, '2019-12-28', '15:00:00', '2019-12-28', '16:45:00'),
(5, 11, 475557, '2019-12-24', '21:00:00', '2019-12-24', '23:17:00'),
(6, 14, 475557, '2019-12-31', '13:00:00', '2019-12-31', '15:17:00'),
(9, 13, 338967, '2019-12-31', '00:00:00', '2019-12-31', '00:00:00'),
(10, 13, 77, '2019-12-26', '00:00:00', '2019-12-26', '00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `ticket_number` int(11) NOT NULL,
  `QR` int(11) NOT NULL,
  `FK_id_purchase` int(11) NOT NULL,
  `FK_id_show` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `tickets`
--

INSERT INTO `tickets` (`ticket_number`, `QR`, `FK_id_purchase`, `FK_id_show`) VALUES
(33, 0, 12, 5),
(34, 0, 12, 5),
(35, 0, 12, 5),
(36, 0, 13, 5),
(37, 0, 13, 5),
(38, 0, 13, 5),
(39, 0, 14, 5),
(40, 0, 14, 5),
(41, 0, 14, 5),
(42, 0, 15, 5),
(43, 0, 15, 5),
(44, 0, 15, 5),
(45, 0, 16, 5),
(46, 0, 16, 5),
(47, 0, 16, 5),
(48, 0, 17, 2),
(49, 0, 17, 2),
(50, 0, 17, 2),
(51, 0, 18, 1),
(52, 0, 18, 1),
(53, 0, 19, 3),
(54, 0, 20, 3),
(55, 0, 20, 3),
(56, 0, 20, 3),
(57, 0, 20, 3),
(58, 0, 20, 3),
(59, 0, 20, 3),
(60, 0, 20, 3),
(61, 0, 20, 3),
(62, 0, 20, 3),
(63, 0, 20, 3),
(64, 0, 20, 3),
(65, 0, 20, 3),
(66, 0, 20, 3),
(67, 0, 20, 3),
(68, 0, 20, 3),
(69, 0, 20, 3),
(70, 0, 20, 3),
(71, 0, 20, 3),
(72, 0, 20, 3),
(73, 0, 20, 3),
(74, 0, 20, 3),
(75, 0, 20, 3),
(76, 0, 20, 3),
(77, 0, 20, 3),
(78, 0, 20, 3),
(79, 0, 20, 3),
(80, 0, 20, 3),
(81, 0, 20, 3),
(82, 0, 20, 3),
(83, 0, 20, 3),
(84, 0, 20, 3),
(85, 0, 20, 3),
(86, 0, 20, 3),
(87, 0, 20, 3),
(88, 0, 20, 3),
(89, 0, 20, 3),
(90, 0, 20, 3),
(91, 0, 20, 3),
(92, 0, 20, 3),
(93, 0, 20, 3),
(94, 0, 20, 3),
(95, 0, 20, 3),
(96, 0, 20, 3),
(97, 0, 20, 3),
(98, 0, 20, 3),
(99, 0, 20, 3),
(100, 0, 20, 3),
(101, 0, 20, 3),
(102, 0, 20, 3),
(103, 0, 20, 3),
(104, 0, 20, 3),
(105, 0, 20, 3),
(106, 0, 20, 3),
(107, 0, 20, 3),
(108, 0, 20, 3),
(109, 0, 20, 3),
(110, 0, 20, 3),
(111, 0, 20, 3),
(112, 0, 20, 3),
(113, 0, 20, 3),
(114, 0, 20, 3),
(115, 0, 20, 3),
(116, 0, 20, 3),
(117, 0, 20, 3),
(118, 0, 20, 3),
(119, 0, 20, 3),
(120, 0, 20, 3),
(121, 0, 20, 3),
(122, 0, 20, 3),
(123, 0, 20, 3),
(124, 0, 20, 3),
(125, 0, 20, 3),
(126, 0, 20, 3),
(127, 0, 20, 3),
(128, 0, 20, 3),
(129, 0, 20, 3),
(130, 0, 20, 3),
(131, 0, 20, 3),
(132, 0, 20, 3),
(133, 0, 20, 3),
(134, 0, 20, 3),
(135, 0, 20, 3),
(136, 0, 20, 3),
(137, 0, 20, 3),
(138, 0, 20, 3),
(139, 0, 20, 3),
(140, 0, 20, 3),
(141, 0, 20, 3),
(142, 0, 20, 3),
(143, 0, 20, 3),
(144, 0, 20, 3),
(145, 0, 20, 3),
(146, 0, 20, 3),
(147, 0, 20, 3),
(148, 0, 20, 3),
(149, 0, 20, 3),
(150, 0, 20, 3),
(151, 0, 20, 3),
(152, 0, 20, 3),
(153, 0, 20, 3),
(154, 0, 20, 3),
(155, 0, 20, 3),
(156, 0, 20, 3),
(157, 0, 20, 3),
(158, 0, 20, 3),
(159, 0, 20, 3),
(160, 0, 20, 3),
(161, 0, 20, 3),
(162, 0, 20, 3),
(163, 0, 20, 3),
(164, 0, 20, 3),
(165, 0, 20, 3),
(166, 0, 20, 3),
(167, 0, 20, 3),
(168, 0, 20, 3),
(169, 0, 20, 3),
(170, 0, 20, 3),
(171, 0, 20, 3),
(172, 0, 20, 3),
(173, 0, 20, 3),
(174, 0, 20, 3),
(175, 0, 20, 3),
(176, 0, 20, 3),
(177, 0, 20, 3),
(178, 0, 20, 3),
(179, 0, 20, 3),
(180, 0, 20, 3),
(181, 0, 20, 3),
(182, 0, 20, 3),
(183, 0, 20, 3),
(184, 0, 20, 3),
(185, 0, 20, 3),
(186, 0, 20, 3),
(187, 0, 20, 3),
(188, 0, 20, 3),
(189, 0, 20, 3),
(190, 0, 20, 3),
(191, 0, 20, 3),
(192, 0, 20, 3),
(193, 0, 20, 3),
(194, 0, 20, 3),
(195, 0, 20, 3),
(196, 0, 20, 3),
(197, 0, 20, 3),
(198, 0, 20, 3),
(199, 0, 20, 3),
(200, 0, 20, 3),
(201, 0, 20, 3),
(202, 0, 20, 3),
(203, 0, 20, 3),
(204, 0, 20, 3),
(205, 0, 20, 3),
(206, 0, 20, 3),
(207, 0, 20, 3),
(208, 0, 20, 3),
(209, 0, 20, 3),
(210, 0, 20, 3),
(211, 0, 20, 3),
(212, 0, 20, 3),
(213, 0, 22, 6),
(214, 0, 22, 6),
(215, 0, 22, 6),
(216, 0, 23, 5),
(217, 0, 23, 5),
(218, 0, 23, 5),
(219, 0, 23, 5),
(220, 0, 23, 5),
(221, 0, 23, 5),
(222, 0, 23, 5),
(223, 0, 23, 5),
(224, 0, 23, 5),
(225, 0, 23, 5),
(226, 0, 24, 6),
(227, 0, 24, 6),
(228, 0, 24, 6),
(229, 0, 24, 6),
(230, 0, 25, 1),
(231, 0, 25, 1),
(232, 0, 25, 1),
(233, 0, 26, 1),
(234, 0, 26, 1),
(235, 0, 27, 1),
(236, 0, 27, 1),
(237, 0, 27, 1),
(238, 0, 27, 1),
(239, 0, 27, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `FK_dni` int(11) NOT NULL,
  `FK_id_role` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`mail`, `password`, `FK_dni`, `FK_id_role`) VALUES
('user@user.com', '123', 0, 0),
('admin@admin.com', '123', 11111111, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cinemas`
--
ALTER TABLE `cinemas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cinema_rooms`
--
ALTER TABLE `cinema_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_id_cinema` (`FK_id_cinema`) USING BTREE;

--
-- Indices de la tabla `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `genres_x_movies`
--
ALTER TABLE `genres_x_movies`
  ADD KEY `FK_gm_id_movie` (`FK_id_movie`) USING BTREE,
  ADD KEY `FK_gm_id_genre` (`FK_id_genre`) USING BTREE;

--
-- Indices de la tabla `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `profile_users`
--
ALTER TABLE `profile_users`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id_purchase`),
  ADD KEY `FK_dni_purchase` (`FK_dni`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `shows`
--
ALTER TABLE `shows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_id_cinemaRoom_show` (`FK_id_cinemaRoom`),
  ADD KEY `FK_id_movie` (`FK_id_movie`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_number`),
  ADD KEY `FK_id_purchase` (`FK_id_purchase`),
  ADD KEY `FK_id_show` (`FK_id_show`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`FK_dni`),
  ADD UNIQUE KEY `mail` (`mail`),
  ADD KEY `FK_id_role` (`FK_id_role`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cinemas`
--
ALTER TABLE `cinemas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `cinema_rooms`
--
ALTER TABLE `cinema_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id_purchase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `shows`
--
ALTER TABLE `shows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cinema_rooms`
--
ALTER TABLE `cinema_rooms`
  ADD CONSTRAINT `FK_id_cinema_room` FOREIGN KEY (`FK_id_cinema`) REFERENCES `cinemas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `genres_x_movies`
--
ALTER TABLE `genres_x_movies`
  ADD CONSTRAINT `FK_gm_id_genre` FOREIGN KEY (`FK_id_genre`) REFERENCES `genres` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_gm_id_movie` FOREIGN KEY (`FK_id_movie`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `FK_dni_purchase` FOREIGN KEY (`FK_dni`) REFERENCES `profile_users` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `shows`
--
ALTER TABLE `shows`
  ADD CONSTRAINT `FK_id_cinemaRoom_show` FOREIGN KEY (`FK_id_cinemaRoom`) REFERENCES `cinema_rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_id_movie` FOREIGN KEY (`FK_id_movie`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `FK_id_purchase` FOREIGN KEY (`FK_id_purchase`) REFERENCES `purchases` (`id_purchase`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_id_show` FOREIGN KEY (`FK_id_show`) REFERENCES `shows` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_dni` FOREIGN KEY (`FK_dni`) REFERENCES `profile_users` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_id_role` FOREIGN KEY (`FK_id_role`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
