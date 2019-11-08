DROP DATABASE moviepass;

CREATE DATABASE moviepass;

USE moviepass;

----------------------------- ROLES -----------------------------

CREATE TABLE roles (
	`id` int NOT NULL PRIMARY KEY,
	`description` VARCHAR (255) NOT NULL
);

INSERT INTO `roles` (`id`, `description`)
	VALUES 	('1', 'administrator'),
			('0', 'user');


DROP procedure IF EXISTS `roles_getById`;
DELIMITER $$
CREATE PROCEDURE roles_getById (IN id INT)
BEGIN
	SELECT roles.id, roles.description
    FROM roles
    WHERE (roles.id = id);
END$$


----------------------------- PROFILE USERS -----------------------------

CREATE TABLE profile_users (
	`dni` int NOT NULL PRIMARY KEY,
	`first_name` VARCHAR (255) NOT NULL,
	`last_name` VARCHAR (255) NOT NULL
);

INSERT INTO `profile_users` (`dni`, `first_name`, `last_name`)
	VALUES 	('11111111', 'admin', 'admin'),
	 		('00000000', 'user', 'user');


----------------------------- USERS -----------------------------

CREATE TABLE users (
	`mail` VARCHAR (255) NOT NULL UNIQUE,
	`password` VARCHAR (255) NOT NULL,
	`FK_dni` int PRIMARY KEY,
	`FK_id_role` int,
	CONSTRAINT `FK_dni` FOREIGN KEY (`FK_dni`) REFERENCES `profile_users` (`dni`),
	CONSTRAINT `FK_id_role` FOREIGN KEY (`FK_id_role`) REFERENCES `roles` (`id`)
);

INSERT INTO `users` (`mail`, `password`, `FK_dni`, `FK_id_role`)
	VALUES	('admin@admin.com', '123', '11111111', '1'),
			('user@user.com', '123', '00000000', '0');


DROP procedure IF EXISTS `users_getByMail`;
DELIMITER $$
CREATE PROCEDURE users_getByMail (IN mail VARCHAR(255))
BEGIN
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

DROP procedure IF EXISTS `users_getAll`;
DELIMITER $$
CREATE PROCEDURE users_getAll ()
BEGIN
	SELECT 	users.mail,
			users.password,
			users.FK_id_role,
			profile_users.dni,
			profile_users.first_name,
			profile_users.last_name
	FROM users
	INNER JOIN profile_users ON users.FK_dni = profile_users.dni
	ORDER By profile_users.dni;
END $$

DROP procedure IF EXISTS `users_deleteByDni`;
DELIMITER $$
CREATE PROCEDURE users_deleteByDni (IN dni INT)
BEGIN
	DELETE FROM `users` WHERE `users`.`FK_dni` = dni;
END$$

----------------------------- CINEMAS -----------------------------

CREATE TABLE cinemas (
	`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR (255) NOT NULL,
	`capacity` int NOT NULL,
	`address` VARCHAR (255) NOT NULL,
	`ticket_value` int NOT NULL
);

INSERT INTO `cinemas` (`name`, `capacity`, `address`, `ticket_value`)
VALUES	('Paseo Aldrey', '1500', 'Sarmiento 2685', '300'),
		('Ambassador', '1400', 'Cordoba DVi', '290'),
		('CinemaCenter', '1300', 'Diagonal Pueyrredon 3050', '280'),
		('Cinema II', '1200', 'Los Gallegos Shopping', '270'),
		('Cine del Paseo', '1100', 'Diagonal Pueyrredon', '260');

DROP procedure IF EXISTS `cinemas_deleteById`;
DELIMITER $$
CREATE PROCEDURE cinemas_deleteById (IN id INT)
BEGIN
	DELETE FROM `cinemas` WHERE `cinemas`.`id` = id;
END$$

DROP procedure IF EXISTS `cinemas_getById`;
DELIMITER $$
CREATE PROCEDURE cinemas_getById (IN id INT)
BEGIN
	SELECT * FROM `cinemas` WHERE `cinemas`.`id` = id;
END$$

DROP procedure IF EXISTS `cinemas_modify`;
DELIMITER $$
CREATE PROCEDURE cinemas_modify (	IN id int,
									IN name VARCHAR (255),
									IN capacity INT,
									IN address VARCHAR (255),
									IN ticket_value INT)
BEGIN
	UPDATE cinemas SET cinemas.name = name, cinemas.capacity = capacity, cinemas.address = address, cinemas.ticket_value = ticket_value WHERE cinemas.id = id;
END$$
DELIMITER ;

DROP procedure IF EXISTS `cinemas_getById`;
DELIMITER $$
CREATE PROCEDURE cinemas_getById (IN id INT)
BEGIN
	SELECT * FROM `cinemas` WHERE `movies`.`id` = id;
END$$


----------------------------- MOVIES -----------------------------

CREATE TABLE movies (
	`id` int NOT NULL UNIQUE PRIMARY KEY,
	`popularity` VARCHAR (255) NOT NULL,
	`vote_count` VARCHAR (255) NOT NULL,
	`video` VARCHAR (255) NOT NULL,
	`poster_path` VARCHAR (255) NOT NULL,
	`adult` VARCHAR (255) NOT NULL,
	`backdrop_path` VARCHAR (255) NOT NULL,
	`original_language` VARCHAR (255) NOT NULL,
	`original_title` VARCHAR (255) NOT NULL,
	`genre_ids` VARCHAR (255) NOT NULL,
	`title` VARCHAR (255) NOT NULL,
	`vote_average` VARCHAR (255) NOT NULL,
	`overview` TEXT NOT NULL,
	`release_date` DATE NOT NULL,
	`runtime` INT
);

DROP procedure IF EXISTS `movies_add`;
DELIMITER $$
CREATE PROCEDURE movies_add (
								IN id INT,
								IN popularity VARCHAR(255),
								IN vote_count VARCHAR(255),
								IN video VARCHAR (255),
								IN poster_path VARCHAR(255),
								IN adult VARCHAR(255),
 								IN backdrop_path VARCHAR (255),
								IN original_language VARCHAR(255),
								IN original_title VARCHAR(255),
								IN genre_ids VARCHAR (255),
								IN title VARCHAR(255),
								IN vote_average VARCHAR(255),
 								IN overview VARCHAR (255),
								IN release_date DATE)
BEGIN
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

DROP procedure IF EXISTS `movies_getById`;
DELIMITER $$
CREATE PROCEDURE movies_getById (IN id INT)
BEGIN
	SELECT * FROM `movies` WHERE `movies`.`id` = id;
END$$

DROP procedure IF EXISTS `movies_add_runtime`;
DELIMITER $$
CREATE PROCEDURE movies_add_runtime (IN id INT, IN runtime INT)
BEGIN
	UPDATE movies
	SET movies.runtime = runtime
	WHERE movies.id = id;
END$$


----------------------------- SHOWS	 -----------------------------

CREATE TABLE shows (
	`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`FK_id_cinema` int,
	`FK_id_movie` int,
	`date_start` DATE NOT NULL,
	`time_start` TIME NOT NULL,
	`date_end` DATE NOT NULL,
	`time_end` TIME NOT NULL,
	CONSTRAINT `FK_id_cinema` FOREIGN KEY (`FK_id_cinema`) REFERENCES `cinemas` (`id`),
	CONSTRAINT `FK_id_movie` FOREIGN KEY (`FK_id_movie`) REFERENCES `movies` (`id`)
);

DROP procedure IF EXISTS `shows_getAll`;
DELIMITER $$
CREATE PROCEDURE shows_getAll ()
BEGIN
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

DROP procedure IF EXISTS `shows_deleteById`;
DELIMITER $$
CREATE PROCEDURE shows_deleteById (IN id INT)
BEGIN
	DELETE FROM `shows` WHERE `shows`.`id` = id;
END$$

DROP procedure IF EXISTS `shows_getById`;
DELIMITER $$
CREATE PROCEDURE shows_getById (IN id INT)
BEGIN
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

DROP procedure IF EXISTS `shows_modify`;
DELIMITER $$
CREATE PROCEDURE shows_modify (		IN id int,
									IN id_cinema INT,
									IN id_movie INT,
									IN date_start DATE,
									IN time_start TIME,
									IN date_end DATE,
									IN time_end TIME)
BEGIN
	UPDATE shows SET shows.	FK_id_cinema = id_cinema, shows.FK_id_movie = id_movie, shows.date_start = date_start, shows.time_start = time_start, shows.date_end = date_end, shows.time_end = time_end WHERE shows.id = id;
END$$
DELIMITER ;

DROP procedure IF EXISTS `shows_getByMovieId`;
DELIMITER $$
CREATE PROCEDURE shows_getByMovieId (IN id_movie INT)
BEGIN
	SELECT 	*
	FROM `shows`
	WHERE (shows.FK_id_movie = id_movie);
END$$

DROP procedure IF EXISTS `shows_getByCinemaId`;
DELIMITER $$
CREATE PROCEDURE shows_getByCinemaId (IN id_movie INT)
BEGIN
	SELECT 	*
	FROM `shows`
	WHERE (shows.FK_id_cinema = id_movie);
END$$


----------------------------- PURCHASE -----------------------------

CREATE TABLE purchases (
	`id_purchase` int AUTO_INCREMENT NOT NULL PRIMARY KEY,
	`ticket_quantity` int NOT NULL,
	`discount` int NOT NULL,
	`date` date NOT NULL,
	`total` int NOT NULL,
	`FK_dni` int,
	CONSTRAINT `FK_dni` FOREIGN KEY ('FK_dni') REFERENCES `profile_user` (`dni`);
)

DROP PROCEDURE IF EXISTS 'purchases_Add';
DELIMITER$$
CREATE PROCEDURE tickets_Add(IN ticket_quantity int, IN discount int, IN date DATE, IN total int, IN dni_user int)
BEGIN
    INSERT INTO purchases(purchases.ticket_quantity, purchases.discount, purchases.date, purchases.total, purchases.FK_dni)
    VALUES (ticket_quantity, discount, date, total, dni_user);
END$$

DROP PROCEDURE IF EXISTS 'purchases_GetById';
DELIMITER$$
CREATE PROCEDURE purchases_GetById(IN id int)
BEGIN 
    SELECT purchases.id_purchases AS purchases.id_purchases,
           purchases.ticket_quantity AS purchases.ticket_quantity,
           purchases.discount AS purchases.discount,
           purchases.date AS purchases.date,
           purchases.total AS purchases.total,
           profile_users.dni AS profile_users.dni
    FROM purchases
    INNER JOIN profile_users ON profile_users.dni = purchases.FK_dni
    WHERE(purchases.id_purchases = id);
END$$

DROP PROCEDURE IF EXISTS 'purchases_GetAll';
DELIMITER$$
CREATE PROCEDURE purchases_GetAll()
BEGIN
	SELECT purchases.id_purchases AS purchases.id_purchases,
           purchases.ticket_quantity AS purchases.ticket_quantity,
           purchases.discount AS purchases.discount,
           purchases.date AS purchases.date,
           purchases.total AS purchases.total,
           profile_users.dni AS profile_users.dni
		   FROM purchases
    INNER JOIN profile_users ON profile_users.dni = purchases.FK_dni;
END$$







----------------------------- TICKET -----------------------------

CREATE TABLE tickets (
	`ticket_number` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`QR` int NOT NULL AUTO_INCREMENT,
	`FK_id_purchase` int NOT NULL,
	`FK_id_show` int NOT NULL,
	CONSTRAINT `FK_id_purchase` FOREIGN KEY (`FK_id_purchase`) REFERENCES `purchase` (`id_purchase`),
	CONSTRAINT `FK_id_show` FOREIGN KEY (`FK_id_show`) REFERENCES `show` (`id_show`)
);

DROP PROCEDURE IF EXISTS 'tickets_Add';
DELIMITER$$
CREATE PROCEDURE tickets_Add(IN id_purchase int, IN id_show int)
BEGIN
    INSERT INTO tickets(tickets.FK_id_purchase, tickets.FK_id_show)
    VALUES (id_purchase, id_show);
END$$

DROP PROCEDURE IF EXISTS 'tickets_GetByNumber';
DELIMITER$$
CREATE PROCEDURE tickets_GetByNumber(IN number int)
BEGIN
    SELECT tickets.ticket_number AS tickets.ticket_number,
           tickets.QR AS tickets.QR,
           purchases.FK_id_purchase AS purchases.FK_id_purchase,
           shows.FK_id_show AS shows.FK_id_show, 
    FROM tickets
    WHERE(tickets.ticket_number = number);
END$$

DROP PROCEDURE IF EXISTS 'tickets_GetAll';
DELIMITER$$
CREATE PROCEDURE tickets_GetAll()
BEGIN
	SELECT tickets.ticket_number AS tickets.ticket_number,
           tickets.QR AS tickets.QR,
           purchases.FK_id_purchase AS purchases.FK_id_purchase,
           shows.FK_id_show AS shows.FK_id_show,
	FROM tickets
END$$



----------------------------- GENRE -----------------------------

CREATE TABLE genres (
	`id` int NOT NULL PRIMARY KEY,
	`name` VARCHAR (255) NOT NULL,
);


----------------------------- GENRE X MOVIE -----------------------------

CREATE TABLE genres_x_movies (
	`FK_id_genre` int,
	`FK_id_movie` int,
	CONSTRAINT `FK_gm_id_genre` FOREIGN KEY (`FK_id_genre`) REFERENCES `genres` (`id`),
	CONSTRAINT `FK_gm_id_movie` FOREIGN KEY (`FK_id_movie`) REFERENCES `movies` (`id`)
);


DROP procedure IF EXISTS `genresxmovies_getByGenre`;					      
DELIMITER $$
CREATE PROCEDURE genresxmovies_getByGenre (IN id_genre INT)
BEGIN
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
	INNER JOIN movies ON genres_x_movies.FK_gm_id_movies = movies.id
    WHERE (genres_x_movies.id_genre = movies.genre_ids);
END$$




