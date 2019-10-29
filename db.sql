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
	`overview` VARCHAR (255) NOT NULL,
	`release_date` DATE NOT NULL,
	`runtime` int NOT NULL
);



CREATE TABLE movies_now_playing (
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
	`overview` VARCHAR (255) NOT NULL,
	`release_date` DATE NOT NULL
);

DROP procedure IF EXISTS `movies_add_now_playing`;
DELIMITER $$
CREATE PROCEDURE movies_add_now_playing (
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
								IN release_date DATE )
BEGIN
	INSERT INTO movies_now_playing (
			movies_now_playing.id,
			movies_now_playing.popularity,
			movies_now_playing.vote_count,
			movies_now_playing.video,
			movies_now_playing.poster_path,
			movies_now_playing.adult,
			movies_now_playing.backdrop_path,
			movies_now_playing.original_language,
			movies_now_playing.original_title,
			movies_now_playing.genre_ids,
			movies_now_playing.title,
			movies_now_playing.vote_average,
			movies_now_playing.overview,
			movies_now_playing.release_date
	)
    VALUES
        (id, popularity, vote_count, video, poster_path, adult, backdrop_path, original_language, original_title, genre_ids, title, vote_average, overview, release_date);
END$$

DROP procedure IF EXISTS `movies_getById`;
DELIMITER $$
CREATE PROCEDURE movies_getById (IN id INT)
BEGIN
	SELECT * FROM `movies_now_playing` WHERE `movies_now_playing`.`id` = id;
END$$


----------------------------- SHOWS	 -----------------------------

CREATE TABLE shows (
	`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`FK_id_cinema` int,
	`FK_id_movie` int,
	`date` DATE NOT NULL,
	`time` TIME NOT NULL,
	CONSTRAINT `FK_id_cinema` FOREIGN KEY (`FK_id_cinema`) REFERENCES `cinemas` (`id`),
	CONSTRAINT `FK_id_movie` FOREIGN KEY (`FK_id_movie`) REFERENCES `movies_now_playing` (`id`)
);

DROP procedure IF EXISTS `shows_getAll`;
DELIMITER $$
CREATE PROCEDURE shows_getAll ()
BEGIN
	SELECT 	shows.id AS shows_id,
			shows.date AS shows_date,
			shows.time AS shows_time,
			movies_now_playing.id AS movies_now_playing_id,
			movies_now_playing.title AS movies_now_playing_title,
			cinemas.id AS cinemas_id,
			cinemas.name AS cinemas_name
	FROM `shows`
	INNER JOIN movies_now_playing ON movies_now_playing.id = shows.FK_id_movie
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
			shows.date AS shows_date,
			shows.time AS shows_time,
			movies_now_playing.id AS movies_now_playing_id,
			movies_now_playing.title AS movies_now_playing_title,
			cinemas.id AS cinemas_id,
			cinemas.name AS cinemas_name
	FROM `shows`
	INNER JOIN movies_now_playing ON movies_now_playing.id = shows.FK_id_movie
	INNER JOIN cinemas ON cinemas.id = shows.FK_id_cinema
	WHERE (shows.id = id);
END$$

DROP procedure IF EXISTS `shows_modify`;
DELIMITER $$
CREATE PROCEDURE shows_modify (		IN id int,
									IN id_cinema INT,
									IN id_movie INT,
									IN dat DATE,
									IN tim TIME)
BEGIN
	UPDATE shows SET shows.	FK_id_cinema = id_cinema, shows.FK_id_movie = id_movie, shows.date = dat, shows.time = tim WHERE shows.id = id;
END$$
DELIMITER ;


----------------------------- PURCHASE -----------------------------

CREATE TABLE purchases (
	`id_purchase` int NOT NULL PRIMARY KEY,
	`ticket_quantity` int NOT NULL,
	`discount` int NOT NULL,
	`date` date NOT NULL,
	`total` int NOT NULL,
	`FK_dni` int,
	CONSTRAINT `FK_dni` FOREIGN KEY ('FK_dni') REFERENCES `profile_user` (`dni`);
)


----------------------------- TICKET -----------------------------

CREATE TABLE tickets (
	`ticket_number` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`QR` int NOT NULL AUTO_INCREMENT,
	`FK_id_purchase` int NOT NULL,
	`FK_id_show` int NOT NULL,
	CONSTRAINT `FK_id_purchase` FOREIGN KEY (`FK_id_purchase`) REFERENCES `purchase` (`id_purchase`),
	CONSTRAINT `FK_id_show` FOREIGN KEY (`FK_id_show`) REFERENCES `show` (`id_show`)
);


----------------------------- GENRE -----------------------------

CREATE TABLE genres (
	`id_genre` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`description` VARCHAR (255) NOT NULL,
);


----------------------------- GENRE X MOVIE -----------------------------

CREATE TABLE genres_x_movies (
	`FK_id_genre` int,
	`FK_id_movie` int,
	CONSTRAINT `FK_id_genre` FOREIGN KEY (`FK_id_genre`) REFERENCES `genre` (`id_genre`),
	CONSTRAINT `FK_id_movie` FOREIGN KEY (`FK_id_movie`) REFERENCES `movie` (`id_movie`)
);
