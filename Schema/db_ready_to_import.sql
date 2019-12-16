-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-12-2019 a las 00:04:52
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemaRooms_disableById` (IN `id` INT)  BEGIN
	UPDATE `cinema_rooms` SET `cinema_rooms`.`is_active` = false WHERE `cinema_rooms`.`id` = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemaRooms_enableById` (IN `id` INT)  BEGIN
	UPDATE `cinema_rooms` SET `cinema_rooms`.`is_active` = true WHERE `cinema_rooms`.`id` = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemaRooms_GetAll` ()  BEGIN
	SELECT 
		cinema_rooms.id as cinema_room_id,
		cinema_rooms.name as cinema_room_name,
		cinema_rooms.capacity as cinema_room_capacity,
		cinema_rooms.price as cinema_room_price,
		cinema_rooms.is_active as cinema_room_is_active,
		cinemas.id as cinema_id,
		cinemas.name as cinema_name,
		cinemas.address as cinema_address
	FROM cinema_rooms
	INNER JOIN cinemas ON cinema_rooms.FK_id_cinema = cinemas.id
	ORDER BY cinemas.name ASC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemaRooms_GetAllActives` ()  BEGIN
	SELECT 
		cinema_rooms.id as cinema_room_id,
		cinema_rooms.name as cinema_room_name,
		cinema_rooms.capacity as cinema_room_capacity,
		cinema_rooms.price as cinema_room_price,
		cinema_rooms.is_active as cinema_room_is_active,
		cinemas.id as cinema_id,
		cinemas.name as cinema_name,
		cinemas.address as cinema_address
	FROM cinema_rooms
	INNER JOIN cinemas ON cinema_rooms.FK_id_cinema = cinemas.id
	WHERE cinema_rooms.is_active = true
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
	UPDATE cinema_rooms SET cinema_rooms.name = name, cinema_rooms.capacity = capacity, cinema_rooms.price = price
	WHERE cinema_rooms.id = id;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemas_disableById` (IN `id` INT)  BEGIN
	UPDATE `cinemas` SET `cinemas`.`is_active` = false WHERE `cinemas`.`id` = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemas_enableById` (IN `id` INT)  BEGIN
	UPDATE `cinemas` SET `cinemas`.`is_active` = true WHERE `cinemas`.`id` = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemas_GetAll` ()  BEGIN
	SELECT * FROM `cinemas` ORDER BY `cinemas`.name;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemas_GetAllActives` ()  BEGIN
	SELECT * FROM `cinemas` WHERE `cinemas`.`is_active` = true ORDER BY `cinemas`.name;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `credit_accounts_Add` (IN `company` VARCHAR(255))  BEGIN
    INSERT INTO credit_accounts 
		(credit_accounts.company)
    VALUES 
		(company);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `credit_accounts_GetAll` ()  BEGIN
    SELECT 
		*
	FROM
		credit_accounts;	
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `genresxmovies_getAll` ()  BEGIN
	SELECT 	*
	FROM genres_x_movies;	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `genresxmovies_getByDate` (IN `date_show` DATE)  BEGIN
	SELECT 	movies.id,			
			movies.poster_path,			
			movies.backdrop_path,						
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
			movies.poster_path,			
			movies.backdrop_path,			
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
	SELECT 	movies.id,			
			movies.poster_path,			
			movies.backdrop_path,			
			movies.title,
			movies.vote_average,
			movies.overview,
			movies.release_date
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
	WHERE (genres_x_movies.FK_id_movie = shows.FK_id_movie) AND (shows.is_active = true)
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `images_add` (IN `name` VARCHAR(100), IN `dni_user` INT)  BEGIN
    INSERT INTO images
    	(name, FK_dni_user)
	VALUES
		(name, dni_user);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `images_getByUser` (IN `dni` INT)  BEGIN
	SELECT *
	FROM images	
    WHERE (images.FK_dni_user = dni);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movies_add` (IN `id` INT, IN `poster_path` VARCHAR(255), IN `backdrop_path` VARCHAR(255), IN `title` VARCHAR(255), IN `vote_average` VARCHAR(255), IN `overview` VARCHAR(255), IN `release_date` DATE)  BEGIN
	INSERT INTO movies (
			movies.id,			
			movies.poster_path,			
			movies.backdrop_path,			
			movies.title,
			movies.vote_average,
			movies.overview,
			movies.release_date
	)
    VALUES
        (id, poster_path, backdrop_path, title, vote_average, overview, release_date);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movies_add_details` (IN `id` INT, IN `poster_path` VARCHAR(255), IN `backdrop_path` VARCHAR(255), IN `title` VARCHAR(255), IN `vote_average` VARCHAR(255), IN `overview` VARCHAR(255), IN `release_date` DATE, IN `runtime` INT)  BEGIN
	INSERT INTO movies (
			movies.id,
			movies.poster_path,			
			movies.backdrop_path,
			movies.title,
			movies.vote_average,
			movies.overview,
			movies.release_date,
			movies.runtime
	)
    VALUES
        (id,poster_path, backdrop_path, title, vote_average, overview, release_date, runtime);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movies_add_runtime` (IN `id` INT, IN `runtime` INT)  BEGIN
	UPDATE movies
	SET movies.runtime = runtime
	WHERE movies.id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movies_deleteById` (IN `id` INT)  BEGIN
	DELETE FROM `movies` WHERE `movies`.`id` = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movies_disableById` (IN `id` INT)  BEGIN
	UPDATE `movies` SET `movies`.`is_active` = false WHERE `movies`.`id` = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movies_enableById` (IN `id` INT)  BEGIN
	UPDATE `movies` SET `movies`.`is_active` = true WHERE `movies`.`id` = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movies_getAll` ()  BEGIN
	SELECT * FROM `movies` ORDER BY title ASC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movies_getAllActives` ()  BEGIN
	SELECT * FROM `movies` WHERE `movies`.`is_active` = true ORDER BY title ASC;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `movies_getId` ()  BEGIN
	SELECT movies.id FROM `movies`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movies_hasShows` (IN `id_movie` INT)  BEGIN
	SELECT *
	FROM movies
	INNER JOIN shows ON movies.id = shows.FK_id_movie
	WHERE movies.id = id_movie;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `payments_credit_card_Add` (IN `code_auth` INT, IN `date` DATE, IN `total` FLOAT, IN `FK_card` INT, OUT `lastId` INT)  BEGIN
    INSERT INTO payments_credit_card 
		(payments_credit_card.code_auth, payments_credit_card.date, payments_credit_card.total, payments_credit_card.FK_card)
    VALUES 
		(code_auth, date, total, FK_card);
	SET lastId = LAST_INSERT_ID();	
	SELECT lastId;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `purchases_Add` (IN `ticket_quantity` INT, IN `discount` INT, IN `date` DATE, IN `total` INT, IN `dni_user` INT, IN `FK_payment_cc` INT, OUT `lastId` INT)  BEGIN
    INSERT INTO purchases(purchases.ticket_quantity, purchases.discount, purchases.date, purchases.total, purchases.FK_dni, purchases.FK_payment_cc)
    VALUES (ticket_quantity, discount, date, total, dni_user, FK_payment_cc);
	SET lastId = LAST_INSERT_ID();	
	SELECT lastId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `purchases_GetAll` ()  BEGIN
	SELECT purchases.id AS purchases_id_purchase,
           purchases.ticket_quantity AS purchases_ticket_quantity,
           purchases.discount AS purchases_discount,
           purchases.date AS purchases_date,
           purchases.total AS purchases_total,
           purchases.FK_dni AS purchases_FK_dni
	FROM purchases;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `purchases_GetByData` (IN `ticket_quantity` INT, IN `discount` INT, IN `date` DATE, IN `total` INT, IN `dni_user` INT)  BEGIN 
    SELECT purchases.id AS purchases_id_purchase
    FROM purchases
    WHERE(purchases.ticket_quantity = ticket_quantity AND purchases.discount = discount AND purchases.date = date AND purchases.total = total AND purchases.FK_dni = dni_user );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `purchases_GetByDni` (IN `dni` INT)  BEGIN 
    SELECT purchases.id AS purchases_id_purchase,
           purchases.ticket_quantity AS purchases_ticket_quantity,
           purchases.discount AS purchases_discount,
           purchases.date AS purchases_date,
           purchases.total AS purchases_total,           
		   movies.title AS movie_title,
		   cinemas.name AS cinema_name,
		   cinema_rooms.name AS cinema_room_name
    FROM purchases
	INNER JOIN tickets ON purchases.id = tickets.FK_id_purchase
	INNER JOIN shows ON tickets.FK_id_show = shows.id
	INNER JOIN movies ON shows.FK_id_movie = movies.id
	INNER JOIN cinema_rooms ON shows.FK_id_cinemaRoom = cinema_rooms.id
	INNER JOIN cinemas ON cinema_rooms.FK_id_cinema = cinemas.id
    WHERE(purchases.FK_dni = dni)
	GROUP BY purchases.id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `purchases_GetById` (IN `id` INT)  BEGIN 
    SELECT purchases.id AS purchases_id_purchase,
           purchases.ticket_quantity AS purchases_ticket_quantity,
           purchases.discount AS purchases_discount,
           purchases.date AS purchases_date,
           purchases.total AS purchases_total,
           purchases.FK_dni AS purchases_FK_dni,
		   movies.title AS movie_title,
		   movies.poster_path AS movie_poster_path,
		   cinemas.name AS cinema_name,
		   cinema_rooms.name AS cinema_room_name
    FROM purchases
	INNER JOIN tickets ON purchases.id = tickets.FK_id_purchase
	INNER JOIN shows ON tickets.FK_id_show = shows.id
	INNER JOIN movies ON shows.FK_id_movie = movies.id
	INNER JOIN cinema_rooms ON shows.FK_id_cinemaRoom = cinema_rooms.id
	INNER JOIN cinemas ON cinema_rooms.FK_id_cinema = cinemas.id
    WHERE(purchases.id = id)
	GROUP BY purchases.id;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `shows_add` (IN `FK_id_cinemaRoom` INT, IN `FK_id_movie` INT, IN `date_start` DATE, IN `time_start` TIME, IN `date_end` DATE, IN `time_end` TIME)  BEGIN
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `shows_disableById` (IN `id` INT)  BEGIN
	UPDATE `shows` SET `shows`.`is_active` = false WHERE `shows`.`id` = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `shows_enableById` (IN `id` INT)  BEGIN
	UPDATE `shows` SET `shows`.`is_active` = true WHERE `shows`.`id` = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `shows_getAll` ()  BEGIN
	SELECT 	shows.id AS shows_id,
			shows.date_start AS shows_date_start,
			shows.time_start AS shows_time_start,
			shows.date_end AS shows_date_end,
			shows.time_end AS shows_time_end,
			shows.is_active AS shows_is_active,
			movies.id AS movies_id,
			movies.title AS movies_title,
			cinema_rooms.id AS cinema_rooms_id,
			cinema_rooms.name AS cinema_rooms_name,
			cinemas.name AS cinema_name,
			cinemas.id AS cinema_id
	FROM `shows`
	INNER JOIN movies ON movies.id = shows.FK_id_movie
	INNER JOIN cinema_rooms ON cinema_rooms.id = shows.FK_id_cinemaRoom
	INNER JOIN cinemas ON cinemas.id = cinema_rooms.FK_id_cinema
	ORDER BY movies.title ASC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `shows_getAllActives` ()  BEGIN
	SELECT 	shows.id AS shows_id,
			shows.date_start AS shows_date_start,
			shows.time_start AS shows_time_start,
			shows.date_end AS shows_date_end,
			shows.time_end AS shows_time_end,
			shows.is_active AS shows_is_active,
			movies.id AS movies_id,
			movies.title AS movies_title,
			cinema_rooms.id AS cinema_rooms_id,
			cinema_rooms.name AS cinema_rooms_name,
			cinemas.name AS cinema_name,
			cinemas.id AS cinema_id
	FROM `shows`
	INNER JOIN movies ON movies.id = shows.FK_id_movie
	INNER JOIN cinema_rooms ON cinema_rooms.id = shows.FK_id_cinemaRoom
	INNER JOIN cinemas ON cinemas.id = cinema_rooms.FK_id_cinema
	WHERE (shows.is_active = true) AND (shows.date_start >= CURDATE()) 
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
			shows.is_active AS shows_is_active,
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
	WHERE ( (shows.FK_id_movie = id_movie) AND (shows.date_start >= curdate()) AND (shows.is_active = true) ) 
	ORDER BY shows.date_start ASC, shows.time_start ASC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `shows_modify` (IN `id` INT, IN `id_cinemaRoom` INT, IN `id_movie` INT, IN `date_start` DATE, IN `time_start` TIME, IN `date_end` DATE, IN `time_end` TIME)  BEGIN
	UPDATE shows SET shows.	FK_id_cinemaRoom = id_cinemaRoom, shows.FK_id_movie = id_movie, shows.date_start = date_start, shows.time_start = time_start, shows.date_end = date_end, shows.time_end = time_end WHERE shows.id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tickets_Add` (IN `qr` INT, IN `id_purchase` INT, IN `id_show` INT)  BEGIN
    INSERT INTO tickets (tickets.qr, tickets.FK_id_purchase, tickets.FK_id_show)
    VALUES (qr, id_purchase, id_show);
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
	INNER JOIN purchases ON tickets.FK_id_purchase = purchases.id
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `tickets_ShowsTickets` ()  BEGIN
	SELECT 
		shows.id AS show_id,
		shows.date_start AS show_date_start,
		shows.time_start AS show_time_start,
		cinemas.name AS cinema_name,
		cinemas.id AS cinema_id,
		cinema_rooms.name AS cinema_room_name,
		movies.title AS movie_title	
	FROM shows 	
	INNER JOIN cinema_rooms ON shows.FK_id_cinemaRoom = cinema_rooms.id
	INNER JOIN cinemas ON cinemas.id = cinema_rooms.FK_id_cinema
	INNER JOIN movies ON shows.FK_id_movie = movies.id
	GROUP BY shows.id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `users_add` (IN `mail` VARCHAR(255), IN `password` VARCHAR(255), IN `FK_dni` INT, IN `FK_id_role` INT)  BEGIN
	INSERT INTO users (
			users.mail,
			users.password,
			users.FK_dni,
			users.FK_id_role
	)
    VALUES
        (mail, password, FK_dni, FK_id_role);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `users_deleteByDni` (IN `dni` INT)  BEGIN
	DELETE FROM `users` WHERE `users`.`FK_dni` = dni;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `users_disableByDni` (IN `dni` INT)  BEGIN
	UPDATE `users` SET users.is_active = false WHERE `users`.`FK_dni` = dni;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `users_enableByDni` (IN `dni` INT)  BEGIN
	UPDATE `users` SET users.is_active = true WHERE `users`.`FK_dni` = dni;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `users_getAll` ()  BEGIN
	SELECT 	users.mail,
			users.password,
			users.FK_id_role,
			users.is_active,
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
			users.is_active,
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
  `address` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cinemas`
--

INSERT INTO `cinemas` (`id`, `name`, `address`, `is_active`) VALUES
(10, 'Paseo Aldrey', 'Sarmiento 2685', 1),
(11, 'Ambassador', 'Cordoba DVi', 1),
(12, 'CinemaCenter', 'Diag. Pueyrredon 3050', 1),
(13, 'Cinema II', 'Los Gallegos Shopping', 1),
(14, 'Cine del Paseo', 'Diagonal Pueyrredon', 1),
(21, 'Cinema disable', 'disable', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cinema_rooms`
--

CREATE TABLE `cinema_rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `price` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `FK_id_cinema` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `cinema_rooms`
--

INSERT INTO `cinema_rooms` (`id`, `name`, `price`, `capacity`, `FK_id_cinema`, `is_active`) VALUES
(11, 'Sala 1', 50, 120, 10, 1),
(12, 'Sala 1', 30, 160, 11, 1),
(13, 'Sala 2', 55, 5, 10, 1),
(14, 'Sala 3', 15, 15, 10, 1),
(21, 'Cinema room disable', 5, 5, 21, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `credit_accounts`
--

CREATE TABLE `credit_accounts` (
  `id` int(11) NOT NULL,
  `company` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `credit_accounts`
--

INSERT INTO `credit_accounts` (`id`, `company`) VALUES
(1, 'Visa'),
(2, 'MasterCard');

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
(53, 77),
(28, 14161),
(12, 14161),
(878, 14161),
(28, 272),
(80, 272),
(18, 272),
(28, 181812),
(12, 181812),
(878, 181812),
(80, 537056),
(16, 537056),
(9648, 537056),
(28, 537056);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `images`
--

CREATE TABLE `images` (
  `imageId` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `FK_dni_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `images`
--

INSERT INTO `images` (`imageId`, `name`, `FK_dni_user`) VALUES
(9, '35017858.jpg', 404040);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `poster_path` varchar(255) NOT NULL,
  `backdrop_path` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `vote_average` varchar(255) NOT NULL,
  `overview` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `release_date` date NOT NULL,
  `runtime` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `movies`
--

INSERT INTO `movies` (`id`, `poster_path`, `backdrop_path`, `title`, `vote_average`, `overview`, `release_date`, `runtime`, `is_active`) VALUES
(77, '/fQMSaP88cf1nz4qwuNEEFtazuDM.jpg', '/q2CtXYjp9IlnfBcPktNkBPsuAEO.jpg', 'Memento', '8.2', 'Leonard Shelby is tracking down the man who raped and murdered his wife. The difficulty of locating his wife\'s killer, however, is compounded by the fact that he suffers from a rare, untreatable form of short-term memory loss. Although he can recall detai', '2000-10-11', 113, 1),
(272, '/dr6x4GyyegBWtinPBzipY02J2lV.jpg', '/9myrRcegWGGp24mpVfkD4zhUfhi.jpg', 'Batman Begins', '7.6', 'Driven by tragedy, billionaire Bruce Wayne dedicates his life to uncovering and defeating the corruption that plagues his home, Gotham City.  Unable to work within the system, he instead creates a new identity, a symbol of fear for the criminal underworld', '2005-06-10', 140, 1),
(14161, '/zf1idF1ys8zuaAzEEzghre5A4m3.jpg', '/ywxrdkfbr8Dg3SBW2gi4kC59qOb.jpg', '2012', '5.7', 'Dr. Adrian Helmsley, part of a worldwide geophysical team investigating the effect on the earth of radiation from unprecedented solar storms, learns that the earth\'s core is heating up. He warns U.S. President Thomas Wilson that the crust of the earth is ', '2009-10-10', 158, 1),
(157336, '/nBNZadXqJSdt05SHLqgT0HuC5Gm.jpg', '/xu9zaAevzQ5nnrsXN6JcahLnG4i.jpg', 'Interstellar', '8.3', 'Interstellar chronicles the adventures of a group of explorers who make use of a newly discovered wormhole to surpass the limitations on human space travel and conquer the vast distances involved in an interstellar voyage.', '2014-11-05', 169, 1),
(181812, '/db32LaOibwEliAmSL2jjDF6oDdj.jpg', '/jOzrELAzFxtMx2I4uDGHOotdfsS.jpg', 'Star Wars: The Rise of Skywalker', '0', 'The next installment in the franchise and the conclusion of the â€œStar Warsâ€œ sequel trilogy as well as the â€œSkywalker Saga.â€œ', '2019-12-18', 141, 1),
(290859, '/vqzNJRH4YyquRiWxCCOH0aXggHI.jpg', '/a6cDxdwaQIFjSkXf7uskg78ZyTq.jpg', 'Terminator: Dark Fate', '6.6', 'More than two decades have passed since Sarah Connor prevented Judgment Day, changed the future, and re-wrote the fate of the human race. Dani Ramos is living a simple life in Mexico City with her brother and father when a highly advanced and deadly new T', '2019-11-01', 128, 1),
(295151, '/tXTccijjTnpXWFEMaHC1gp59cNc.jpg', '/9REB0BCTk2RueTj5PuELYRYJN5e.jpg', 'Let It Snow', '6.3', 'When a huge blizzard (that doesn\'t show signs of stopping) hits, Gracetown is completely snowed in. But even though it\'s cold outside, things are heating up inside, proving that Christmas is magical when it comes to love.', '2019-11-08', 93, 0),
(338967, '/pIcV8XXIIvJCbtPoxF9qHMKdRr2.jpg', '/jCCdt0e8Xe9ttvevD4S3TSMNdH.jpg', 'Zombieland: Double Tap', '7.5', 'The group will face a new zombie threat as a new breed of zombie has developed. This new super-zombie type is faster, bigger, and stronger than the previous strain of zombies and harder to kill. These super-zombies have started grouping up into a horde go', '2019-10-18', 99, 1),
(398978, '/eXH2w0Ylh706Rwj6CHFm1FKRBXG.jpg', '/aZ1ZqJ4uO1RK5gU5jRsO4qG7rJo.jpg', 'The Irishman', '8.9', 'World War II veteran and mob hitman Frank \"The Irishman\" Sheeran recalls his possible involvement with the slaying of union leader Jimmy Hoffa.', '2019-11-01', 209, 1),
(417384, '/q5298SICFzqMcKtQoBktk8p6FH.jpg', '/qBI3Spq93lNxGzecdGpbwV5lOvU.jpg', 'Scary Stories to Tell in the Dark', '6.3', 'Mill Valley, Pennsylvania, Halloween night, 1968. After playing a joke on a school bully, Sarah and her friends decide to sneak into a supposedly haunted house that once belonged to the powerful Bellows family, unleashing dark forces that they will be una', '2019-08-09', 108, 1),
(420809, '/tBuabjEqxzoUBHfbyNbd8ulgy5j.jpg', '/skvI4rYFrKXS73BJxWGH54Omlvv.jpg', 'Maleficent: Mistress of Evil', '7.3', 'Maleficent and her goddaughter Aurora begin to question the complex family ties that bind them as they are pulled in different directions by impending nuptials, unexpected allies, and dark new forces at play.', '2019-10-18', 118, 1),
(453405, '/uTALxjQU8e1lhmNjP9nnJ3t2pRU.jpg', '/c3F4P2oauA7IQmy4hM0OmRt2W7d.jpg', 'Gemini Man', '5.8', 'Henry Brogen, an aging assassin tries to get out of the business but finds himself in the ultimate battle: fighting his own clone who is 25 years younger than him and at the peak of his abilities.', '2019-10-11', 117, 1),
(454640, '/ebe8hJRCwdflNQbUjRrfmqtUiNi.jpg', '/k7sE3loFwuU2mqf7FbZBeE3rjBa.jpg', 'The Angry Birds Movie 2', '6.5', 'Red, Chuck, Bomb and the rest of their feathered friends are surprised when a green pig suggests that they put aside their differences and unite to fight a common threat. Aggressive birds from an island covered in ice are planning to use an elaborate weap', '2019-08-14', 96, 1),
(458156, '/ziEuG1essDuWuC5lpWUaw1uXY2O.jpg', '/stemLQMLDrlpfIlZ5OjllOPT8QX.jpg', 'John Wick: Chapter 3 - Parabellum', '7.1', 'Super-assassin John Wick returns with a $14 million price tag on his head and an army of bounty-hunting killers on his trail. After killing a member of the shadowy international assassin’s guild, the High Table, John Wick is excommunicado, but the world’s', '2019-05-17', 131, 0),
(474350, '/zfE0R94v1E8cuKAerbskfD3VfUt.jpg', '/8moTOzunF7p40oR5XhlDvJckOSW.jpg', 'It Chapter Two', '6.9', '27 years after overcoming the malevolent supernatural entity Pennywise, the former members of the Losers\' Club, who have grown up and moved away from Derry, are brought back together by a devastating phone call.', '2019-09-06', 169, 1),
(475557, '/udDclJoHjfjb8Ekgsd4FDteOkCU.jpg', '/n6bUvigpRFqSwmPp1m2YADdbRBc.jpg', 'Joker', '8.5', 'During the 1980s, a failed stand-up comedian is driven insane and turns to a life of crime and chaos in Gotham City while becoming an infamous psychopathic crime figure.', '2019-10-04', 122, 1),
(480105, '/g4z7mDmJmx23vsVg6XNWcnXb6gc.jpg', '/3uG3aOhEzFCjcQulsJQiAzLSrw8.jpg', '47 Meters Down: Uncaged', '5.2', 'A group of backpackers diving in a ruined underwater city discover that they have stumbled into the territory of the ocean\'s deadliest shark species.', '2019-08-16', 90, 1),
(481084, '/uaXNjRkDdjfxfVuKHo25wkA6CiA.jpg', '/ur4NTeFGZmQ6Hz5uEkAMgPI3WRg.jpg', 'The Addams Family', '5.9', 'The Addams family\'s lives begin to unravel when they face-off against a treacherous, greedy crafty reality-TV host while also preparing for their extended family to arrive for a major celebration.', '2019-10-11', 86, 1),
(501170, '/p69QzIBbN06aTYqRRiCOY1emNBh.jpg', '/4D4Ic9N4tnwaW4x241LGb1XOi7O.jpg', 'Doctor Sleep', '6.9', 'A traumatized, alcoholic Dan Torrance meets Abra, a kid who also has the ability to \"shine.\" He tries to protect her from the True Knot, a cult whose goal is to feed off people like them in order to remain immortal.', '2019-11-08', 152, 1),
(515195, '/1rjaRIAqFPQNnMtqSMLtg0VEABi.jpg', '/t5Kp02Jzixl0KfpwthHp9ZUex9t.jpg', 'Yesterday', '6.7', 'Jack Malik is a struggling singer-songwriter in an English seaside town whose dreams of fame are rapidly fading, despite the fierce devotion and support of his childhood best friend, Ellie. After a freak bus accident during a mysterious global blackout, J', '2019-06-28', 116, 1),
(521777, '/tximyCXMEnWIIyOy9STkOduUprG.jpg', '/jTwUkBa6BOPypqCx4KcvrYIlAcI.jpg', 'Good Boys', '6.5', 'A group of young boys on the cusp of becoming teenagers embark on an epic quest to fix their broken drone before their parents get home.', '2019-08-16', 89, 1),
(537056, '/eiVQORVyVuNNZHPAELuWtlXoQsD.jpg', '/eevJuYAitUe6VwFN29aFwzeyeTr.jpg', 'Batman: Hush', '7', 'A mysterious new villain known only as Hush uses a gallery of villains to destroy Batman\'s crime-fighting career as well as Bruce Wayne\'s personal life, which has been further complicated by a  relationship with Selina Kyle/Catwoman.', '2019-07-19', 82, 1),
(559969, '/ePXuKdXZuJx8hHMNr2yM4jY2L7Z.jpg', '/ijiE9WoGSwSzM16zTxvUneJ8RXc.jpg', 'El Camino: A Breaking Bad Movie', '7.1', 'In the wake of his dramatic escape from captivity, Jesse Pinkman must come to terms with his past in order to forge some kind of future.', '2019-10-11', 123, 1),
(568012, '/4E2lyUGLEr3yH4q6kJxPkQUhX7n.jpg', '/iGnCzXEx0cFlUbpyAMeHwHWhPhx.jpg', 'One Piece: Stampede', '7.6', 'One Piece: Stampede is a stand-alone film that celebrates the anime\'s 20th Anniversary and takes place outside the canon of the \"One Piece\" TV series. Monkey D. Luffy and his Straw Hat pirate crew are invited to a massive Pirate Festival that brings many ', '2019-10-24', 101, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payments_credit_card`
--

CREATE TABLE `payments_credit_card` (
  `id` int(11) NOT NULL,
  `code_auth` int(11) NOT NULL,
  `date` date NOT NULL,
  `total` float NOT NULL,
  `FK_card` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
(101010, 'Usuario', 'Usuario'),
(404040, 'Rodrigo', 'Leon'),
(9592315, 'Pepe', 'Jose');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `ticket_quantity` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `date` date NOT NULL,
  `total` int(11) NOT NULL,
  `FK_dni` int(11) NOT NULL,
  `FK_payment_cc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
  `time_end` time NOT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `shows`
--

INSERT INTO `shows` (`id`, `FK_id_cinemaRoom`, `FK_id_movie`, `date_start`, `time_start`, `date_end`, `time_end`, `is_active`) VALUES
(61, 12, 14161, '2019-12-03', '18:30:00', '2019-12-03', '21:23:00', 1),
(62, 12, 14161, '2019-12-03', '14:00:00', '2019-12-03', '16:53:00', 1);

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `FK_dni` int(11) NOT NULL,
  `FK_id_role` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`mail`, `password`, `FK_dni`, `FK_id_role`, `is_active`) VALUES
('user@user.com', '$2y$10$.wmJ0AtEQHu0SXvZXbYjTeuq.p9e/eSuCHQpUG3BBFzOk8YNPYaWG', 101010, 0, 1),
('admin@admin.com', '$2y$10$dqygmgUiZXOu32nyVRcd9.YzgyZMwoKSQztAjOhwFH4AKwkTSEfMq', 404040, 1, 1),
('pepe@user.com', '$2y$10$vIiWzmu2rRsHD0uhnFCBX.TV8.dj8naTR4OjcS6Oe8dAX0y2Pg9zC', 9592315, 0, 0);

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
-- Indices de la tabla `credit_accounts`
--
ALTER TABLE `credit_accounts`
  ADD PRIMARY KEY (`id`);

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
-- Indices de la tabla `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`imageId`),
  ADD KEY `FK_dni_image` (`FK_dni_user`);

--
-- Indices de la tabla `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `payments_credit_card`
--
ALTER TABLE `payments_credit_card`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_card_company` (`FK_card`);

--
-- Indices de la tabla `profile_users`
--
ALTER TABLE `profile_users`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_dni_purchase` (`FK_dni`),
  ADD KEY `FK_payment_purchase` (`FK_payment_cc`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `cinema_rooms`
--
ALTER TABLE `cinema_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `credit_accounts`
--
ALTER TABLE `credit_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `images`
--
ALTER TABLE `images`
  MODIFY `imageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `payments_credit_card`
--
ALTER TABLE `payments_credit_card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `shows`
--
ALTER TABLE `shows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=306;

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
-- Filtros para la tabla `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `FK_dni_image` FOREIGN KEY (`FK_dni_user`) REFERENCES `profile_users` (`dni`);

--
-- Filtros para la tabla `payments_credit_card`
--
ALTER TABLE `payments_credit_card`
  ADD CONSTRAINT `FK_card_company` FOREIGN KEY (`FK_card`) REFERENCES `credit_accounts` (`id`);

--
-- Filtros para la tabla `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `FK_dni_purchase` FOREIGN KEY (`FK_dni`) REFERENCES `profile_users` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_payment_purchase` FOREIGN KEY (`FK_payment_cc`) REFERENCES `payments_credit_card` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `FK_id_purchase` FOREIGN KEY (`FK_id_purchase`) REFERENCES `purchases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
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
