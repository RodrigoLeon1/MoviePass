-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 02-11-2019 a las 20:18:02
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.10

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
CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemas_deleteById` (IN `id` INT)  BEGIN
	DELETE FROM `cinemas` WHERE `cinemas`.`id` = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemas_getById` (IN `id` INT)  BEGIN
	SELECT * FROM `cinemas` WHERE `movies`.`id` = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cinemas_modify` (IN `id` INT, IN `name` VARCHAR(255), IN `capacity` INT, IN `address` VARCHAR(255), IN `ticket_value` INT)  BEGIN
	UPDATE cinemas SET cinemas.name = name, cinemas.capacity = capacity, cinemas.address = address, cinemas.ticket_value = ticket_value WHERE cinemas.id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `genreMovie_add` (IN `FK_gxm_id_genre` INT, IN `FK_gxm_id_movie` INT)  BEGIN
	INSERT INTO genres_x_movies (
			genres_x_movies.FK_gxm_id_genre,
			genres_x_movies.FK_gxm_id_movie)
    VALUES
        (FK_gxm_id_genre, FK_gxm_id_movie);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `genres_getById` (IN `id` INT)  BEGIN
	SELECT 	genre.name,
			genre.id
	FROM genre
    WHERE (genres.id = id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `genres_getByName` (IN `name` VARCHAR(255))  BEGIN
	SELECT 	genre.name,
			genre.id
	FROM genre
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
	INNER JOIN movies ON genres_x_movies.FK_id_movies = movies.id
    WHERE (genres_x_movies.id_genre = id_genre);
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `movies_add_runtime` (IN `id` INT, IN `runtime` INT)  BEGIN
	UPDATE movies
	SET movies.runtime = runtime
	WHERE movies.id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movies_getById` (IN `id` INT)  BEGIN
	SELECT * FROM `movies` WHERE `movies`.`id` = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `roles_getById` (IN `id` INT)  BEGIN
	SELECT roles.id, roles.description
    FROM roles
    WHERE (roles.id = id);
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
			cinemas.id AS cinemas_id,
			cinemas.name AS cinemas_name
	FROM `shows`
	INNER JOIN movies ON movies.id = shows.FK_id_movie
	INNER JOIN cinemas ON cinemas.id = shows.FK_id_cinema;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `shows_getByCinemaId` (IN `id_movie` INT)  BEGIN
	SELECT 	*
	FROM `shows`
	WHERE (shows.FK_id_cinema = id_movie);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `shows_getById` (IN `id` INT)  BEGIN
	SELECT 	shows.id AS shows_id,
			shows.date_start AS shows_date_start,
			shows.time_start AS shows_time_start,
			shows.date_end AS shows_date_end,
			shows.time_end AS shows_time_end,
			movies.id AS movies_id,
			movies.title AS movies_title,
			cinemas.id AS cinemas_id,
			cinemas.name AS cinemas_name
	FROM `shows`
	INNER JOIN movies ON movies.id = shows.FK_id_movie
	INNER JOIN cinemas ON cinemas.id = shows.FK_id_cinema
	WHERE (shows.id = id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `shows_getByMovieId` (IN `id_movie` INT)  BEGIN
	SELECT 	*
	FROM `shows`
	WHERE (shows.FK_id_movie = id_movie);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `shows_modify` (IN `id` INT, IN `id_cinema` INT, IN `id_movie` INT, IN `date_start` DATE, IN `time_start` TIME, IN `date_end` DATE, IN `time_end` TIME)  BEGIN
	UPDATE shows SET shows.	FK_id_cinema = id_cinema, shows.FK_id_movie = id_movie, shows.date_start = date_start, shows.time_start = time_start, shows.date_end = date_end, shows.time_end = time_end WHERE shows.id = id;
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
  `capacity` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `ticket_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cinemas`
--

INSERT INTO `cinemas` (`id`, `name`, `capacity`, `address`, `ticket_value`) VALUES
(1, 'Paseo Aldrey', 1500, 'Sarmiento 2685', 300),
(2, 'Ambassador', 1400, 'Cordoba DVi', 290),
(3, 'CinemaCenter', 1300, 'Diagonal Pueyrredon 3050', 280),
(4, 'Cinema II', 1200, 'Los Gallegos Shopping', 270),
(5, 'Cine del Paseo', 1100, 'Diagonal Pueyrredon', 260);

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
(28, 603),
(878, 603),
(28, 578189),
(80, 578189),
(18, 578189),
(27, 694),
(53, 694);

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
  `genre_ids` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `vote_average` varchar(255) NOT NULL,
  `overview` text NOT NULL,
  `release_date` date NOT NULL,
  `runtime` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `movies`
--

INSERT INTO `movies` (`id`, `popularity`, `vote_count`, `video`, `poster_path`, `adult`, `backdrop_path`, `original_language`, `original_title`, `genre_ids`, `title`, `vote_average`, `overview`, `release_date`, `runtime`) VALUES
(2, '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '0000-00-00', NULL),
(603, '38.692', '15394', '', '/lZpWprJqbIFpEV5uoHfoK0KCnTW.jpg', '', '/icmmSD4vTTDKOq2vvdulafOGw93.jpg', 'en', 'The Matrix', 'Array', 'The Matrix', '8.1', 'Set in the 22nd century, The Matrix tells the story of a computer hacker who joins a group of underground insurgents fighting the vast and powerful computers who now rule the earth.', '1999-03-30', NULL),
(694, '73.45', '9414', '', '/9fgh3Ns1iRzlQNYuJyK0ARQZU7w.jpg', '', '/h4DcDCOkQBENWBJZjNlPv3adQfM.jpg', 'en', 'The Shining', 'Array', 'The Shining', '8.2', 'Jack Torrance accepts a caretaker job at the Overlook Hotel, where he, along with his wife Wendy and their son Danny, must live isolated from the rest of the world for the winter. But they aren\'t prepared for the madness that lurks within.', '1980-05-23', NULL),
(290859, '315.137', '159', '', '/vqzNJRH4YyquRiWxCCOH0aXggHI.jpg', '', '/a6cDxdwaQIFjSkXf7uskg78ZyTq.jpg', 'en', 'Terminator: Dark Fate', 'Array', 'Terminator: Dark Fate', '6.6', 'More than two decades have passed since Sarah Connor prevented Judgment Day, changed the future, and re-wrote the fate of the human race. Dani Ramos is living a simple life in Mexico City with her brother and father when a highly advanced and deadly new T', '2019-11-01', NULL),
(338967, '99.847', '213', '', '/pIcV8XXIIvJCbtPoxF9qHMKdRr2.jpg', '', '/jCCdt0e8Xe9ttvevD4S3TSMNdH.jpg', 'en', 'Zombieland: Double Tap', 'Array', 'Zombieland: Double Tap', '7.5', 'The group will face a new zombie threat as a new breed of zombie has developed. This new super-zombie type is faster, bigger, and stronger than the previous strain of zombies and harder to kill. These super-zombies have started grouping up into a horde go', '2019-10-18', NULL),
(398978, '53.593', '7', '', '/eXH2w0Ylh706Rwj6CHFm1FKRBXG.jpg', '', '/aZ1ZqJ4uO1RK5gU5jRsO4qG7rJo.jpg', 'en', 'The Irishman', 'Array', 'The Irishman', '8.9', 'World War II veteran and mob hitman Frank \"The Irishman\" Sheeran recalls his possible involvement with the slaying of union leader Jimmy Hoffa.', '2019-11-01', NULL),
(417384, '90.103', '484', '', '/q5298SICFzqMcKtQoBktk8p6FH.jpg', '', '/qBI3Spq93lNxGzecdGpbwV5lOvU.jpg', 'en', 'Scary Stories to Tell in the Dark', 'Array', 'Scary Stories to Tell in the Dark', '6.3', 'Mill Valley, Pennsylvania, Halloween night, 1968. After playing a joke on a school bully, Sarah and her friends decide to sneak into a supposedly haunted house that once belonged to the powerful Bellows family, unleashing dark forces that they will be una', '2019-08-09', NULL),
(420809, '230.948', '579', '', '/tBuabjEqxzoUBHfbyNbd8ulgy5j.jpg', '', '/skvI4rYFrKXS73BJxWGH54Omlvv.jpg', 'en', 'Maleficent: Mistress of Evil', 'Array', 'Maleficent: Mistress of Evil', '7.3', 'Maleficent and her goddaughter Aurora begin to question the complex family ties that bind them as they are pulled in different directions by impending nuptials, unexpected allies, and dark new forces at play.', '2019-10-18', NULL),
(453405, '94.626', '442', '', '/uTALxjQU8e1lhmNjP9nnJ3t2pRU.jpg', '', '/c3F4P2oauA7IQmy4hM0OmRt2W7d.jpg', 'en', 'Gemini Man', 'Array', 'Gemini Man', '5.8', 'Henry Brogen, an aging assassin tries to get out of the business but finds himself in the ultimate battle: fighting his own clone who is 25 years younger than him and at the peak of his abilities.', '2019-10-11', NULL),
(454640, '59.76', '224', '', '/ebe8hJRCwdflNQbUjRrfmqtUiNi.jpg', '', '/k7sE3loFwuU2mqf7FbZBeE3rjBa.jpg', 'en', 'The Angry Birds Movie 2', 'Array', 'The Angry Birds Movie 2', '6.5', 'Red, Chuck, Bomb and the rest of their feathered friends are surprised when a green pig suggests that they put aside their differences and unite to fight a common threat. Aggressive birds from an island covered in ice are planning to use an elaborate weap', '2019-08-14', NULL),
(458156, '60.831', '3085', '', '/ziEuG1essDuWuC5lpWUaw1uXY2O.jpg', '', '/stemLQMLDrlpfIlZ5OjllOPT8QX.jpg', 'en', 'John Wick: Chapter 3 - Parabellum', 'Array', 'John Wick: Chapter 3 - Parabellum', '7.1', 'Super-assassin John Wick returns with a $14 million price tag on his head and an army of bounty-hunting killers on his trail. After killing a member of the shadowy international assassin’s guild, the High Table, John Wick is excommunicado, but the world’s', '2019-05-17', NULL),
(474350, '108.576', '1800', '', '/zfE0R94v1E8cuKAerbskfD3VfUt.jpg', '', '/8moTOzunF7p40oR5XhlDvJckOSW.jpg', 'en', 'It Chapter Two', 'Array', 'It Chapter Two', '6.9', '27 years after overcoming the malevolent supernatural entity Pennywise, the former members of the Losers\' Club, who have grown up and moved away from Derry, are brought back together by a devastating phone call.', '2019-09-06', NULL),
(475557, '470.723', '4556', '', '/udDclJoHjfjb8Ekgsd4FDteOkCU.jpg', '', '/n6bUvigpRFqSwmPp1m2YADdbRBc.jpg', 'en', 'Joker', 'Array', 'Joker', '8.5', 'During the 1980s, a failed stand-up comedian is driven insane and turns to a life of crime and chaos in Gotham City while becoming an infamous psychopathic crime figure.', '2019-10-04', NULL),
(480105, '96.279', '121', '', '/g4z7mDmJmx23vsVg6XNWcnXb6gc.jpg', '', '/3uG3aOhEzFCjcQulsJQiAzLSrw8.jpg', 'en', '47 Meters Down: Uncaged', 'Array', '47 Meters Down: Uncaged', '5.2', 'A group of backpackers diving in a ruined underwater city discover that they have stumbled into the territory of the ocean\'s deadliest shark species.', '2019-08-16', NULL),
(481084, '80.361', '111', '', '/uaXNjRkDdjfxfVuKHo25wkA6CiA.jpg', '', '/ur4NTeFGZmQ6Hz5uEkAMgPI3WRg.jpg', 'en', 'The Addams Family', 'Array', 'The Addams Family', '5.9', 'The Addams family\'s lives begin to unravel when they face-off against a treacherous, greedy crafty reality-TV host while also preparing for their extended family to arrive for a major celebration.', '2019-10-11', NULL),
(501170, '92.496', '59', '', '/p69QzIBbN06aTYqRRiCOY1emNBh.jpg', '', '/4D4Ic9N4tnwaW4x241LGb1XOi7O.jpg', 'en', 'Doctor Sleep', 'Array', 'Doctor Sleep', '6.9', 'A traumatized, alcoholic Dan Torrance meets Abra, a kid who also has the ability to \"shine.\" He tries to protect her from the True Knot, a cult whose goal is to feed off people like them in order to remain immortal.', '2019-11-08', NULL),
(515195, '64.828', '880', '', '/1rjaRIAqFPQNnMtqSMLtg0VEABi.jpg', '', '/t5Kp02Jzixl0KfpwthHp9ZUex9t.jpg', 'en', 'Yesterday', 'Array', 'Yesterday', '6.7', 'Jack Malik is a struggling singer-songwriter in an English seaside town whose dreams of fame are rapidly fading, despite the fierce devotion and support of his childhood best friend, Ellie. After a freak bus accident during a mysterious global blackout, J', '2019-06-28', NULL),
(521777, '91.718', '279', '', '/tximyCXMEnWIIyOy9STkOduUprG.jpg', '', '/jTwUkBa6BOPypqCx4KcvrYIlAcI.jpg', 'en', 'Good Boys', 'Array', 'Good Boys', '6.5', 'A group of young boys on the cusp of becoming teenagers embark on an epic quest to fix their broken drone before their parents get home.', '2019-08-16', NULL),
(559969, '119.825', '1227', '', '/ePXuKdXZuJx8hHMNr2yM4jY2L7Z.jpg', '', '/ijiE9WoGSwSzM16zTxvUneJ8RXc.jpg', 'en', 'El Camino: A Breaking Bad Movie', 'Array', 'El Camino: A Breaking Bad Movie', '7.1', 'In the wake of his dramatic escape from captivity, Jesse Pinkman must come to terms with his past in order to forge some kind of future.', '2019-10-11', NULL),
(568012, '126.478', '60', '', '/4E2lyUGLEr3yH4q6kJxPkQUhX7n.jpg', '', '/iGnCzXEx0cFlUbpyAMeHwHWhPhx.jpg', 'ja', 'ワンピーススタンピード', 'Array', 'One Piece: Stampede', '7.6', 'One Piece: Stampede is a stand-alone film that celebrates the anime\'s 20th Anniversary and takes place outside the canon of the \"One Piece\" TV series. Monkey D. Luffy and his Straw Hat pirate crew are invited to a massive Pirate Festival that brings many ', '2019-10-24', NULL),
(578189, '49.778', '39', '', '/fjmMu9fpqMMF17mCyLhNfkagKB0.jpg', '', '/zBAoNL50oFRCAJvEEQEKD8M48pV.jpg', 'en', 'Black and Blue', 'Array', 'Black and Blue', '5.4', 'Exposure follows a rookie Detroit African-American female cop who stumbles upon corrupt officers who are murdering a drug dealer, an incident captured by her body cam. They pursue her through the night in an attempt to destroy the footage, but to make mat', '2019-10-25', NULL);

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
(11111111, 'admin', 'admin');

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
  `FK_id_cinema` int(11) DEFAULT NULL,
  `FK_id_movie` int(11) DEFAULT NULL,
  `date_start` date NOT NULL,
  `time_start` time NOT NULL,
  `date_end` date NOT NULL,
  `time_end` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `shows`
--

INSERT INTO `shows` (`id`, `FK_id_cinema`, `FK_id_movie`, `date_start`, `time_start`, `date_end`, `time_end`) VALUES
(1, 1, 603, '2019-12-12', '21:45:00', '1970-01-01', '01:15:00'),
(2, 5, 475557, '2019-10-10', '09:45:00', '1970-01-01', '01:15:00'),
(3, 1, 290859, '2019-12-11', '09:45:00', '1970-01-01', '01:15:00'),
(4, 2, 501170, '2019-08-04', '02:45:00', '1970-01-01', '01:15:00'),
(5, 3, 474350, '2019-05-22', '21:45:00', '1970-01-01', '01:15:00'),
(6, 4, 694, '2019-07-12', '23:45:00', '1970-01-01', '01:15:00');

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
-- Indices de la tabla `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `genres_x_movies`
--
ALTER TABLE `genres_x_movies`
  ADD KEY `FK_gxm_id_genre` (`FK_id_genre`),
  ADD KEY `FK_gxm_id_movie` (`FK_id_movie`);

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
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `shows`
--
ALTER TABLE `shows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_id_cinema` (`FK_id_cinema`),
  ADD KEY `FK_id_movie` (`FK_id_movie`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `shows`
--
ALTER TABLE `shows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `genres_x_movies`
--
ALTER TABLE `genres_x_movies`
  ADD CONSTRAINT `FK_gxm_id_genre` FOREIGN KEY (`FK_id_genre`) REFERENCES `genres` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `FK_gxm_id_movie` FOREIGN KEY (`FK_id_movie`) REFERENCES `movies` (`id`) ON DELETE NO ACTION;

--
-- Filtros para la tabla `shows`
--
ALTER TABLE `shows`
  ADD CONSTRAINT `FK_id_cinema` FOREIGN KEY (`FK_id_cinema`) REFERENCES `cinemas` (`id`),
  ADD CONSTRAINT `FK_id_movie` FOREIGN KEY (`FK_id_movie`) REFERENCES `movies` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_dni` FOREIGN KEY (`FK_dni`) REFERENCES `profile_users` (`dni`),
  ADD CONSTRAINT `FK_id_role` FOREIGN KEY (`FK_id_role`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
