DROP DATABASE moviepass;

CREATE DATABASE moviepass;

USE moviepass;



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




CREATE TABLE profile_users (
	`dni` int NOT NULL PRIMARY KEY,
	`first_name` VARCHAR (255) NOT NULL,
	`last_name` VARCHAR (255) NOT NULL
);

INSERT INTO `profile_users` (`dni`, `first_name`, `last_name`)
	VALUES 	('11111111', 'admin', 'admin'),
	 		('00000000', 'user', 'user');




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
	SELECT users.mail, users.password, users.FK_dni, users.FK_id_role
    FROM users
    WHERE (users.mail = mail);
END$$

DROP procedure IF EXISTS `profile_users_getByDNI`;
DELIMITER $$
CREATE PROCEDURE profile_users_getByDNI (IN dni INT)
BEGIN
	SELECT profile_users.dni, profile_users.first_name, profile_users.last_name
    FROM profile_users
    WHERE (profile_users.dni = dni);
END$$




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




CREATE TABLE purchases (
	`id_purchase` int NOT NULL PRIMARY KEY,
	`ticket_quantity` int NOT NULL,
	`discount` int NOT NULL,
	`date` date NOT NULL,
	`total` int NOT NULL,
	`FK_dni` int,
	CONSTRAINT `FK_dni` FOREIGN KEY ('FK_dni') REFERENCES `profile_user` (`dni`);
)

--Modificada
CREATE TABLE purchases (
	`id_purchase` int NOT NULL PRIMARY KEY,
	`ticket_quantity` int NOT NULL,
	`discount` int NOT NULL,
	`date` date NOT NULL,
	`total` int NOT NULL,
	`FK_dni` int,
	CONSTRAINT `FK_dni_purchase` FOREIGN KEY (`FK_dni`) REFERENCES `profile_users` (`dni`)
);

--Tabla movie


CREATE TABLE shows (
	`id_show` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`date` DATE NOT NULL,
	`FK_id_cinema` int,
	`FK_id_movie` int,
	CONSTRAINT `FK_id_cinema` FOREIGN KEY ('FK_id_cinema') REFERENCES `cinema` (`id_cinema`),
	CONSTRAINT `FK_id_movie` FOREIGN KEY (`FK_id_movie`) REFERENCES `movie` (`id_movie`)
);


CREATE TABLE tickets (
	`ticket_number` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`QR` int NOT NULL AUTO_INCREMENT,
	`FK_id_purchase` int NOT NULL,
	`FK_id_show` int NOT NULL,
	CONSTRAINT `FK_id_purchase` FOREIGN KEY (`FK_id_purchase`) REFERENCES `purchase` (`id_purchase`),
	CONSTRAINT `FK_id_show` FOREIGN KEY (`FK_id_show`) REFERENCES `show` (`id_show`)
);



CREATE TABLE genres (
	`id_genre` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`description` VARCHAR (255) NOT NULL,
);




CREATE TABLE genres_x_movies (
	`FK_id_genre` int,
	`FK_id_movie` int,
	CONSTRAINT `FK_id_genre` FOREIGN KEY (`FK_id_genre`) REFERENCES `genre` (`id_genre`),
	CONSTRAINT `FK_id_movie` FOREIGN KEY (`FK_id_movie`) REFERENCES `movie` (`id_movie`)
);
