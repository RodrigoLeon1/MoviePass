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
	`name` VARCHAR(255) NOT NULL,
	`address` VARCHAR(255) NOT NULL
);

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

DROP procedure IF EXISTS `cinemas_getByName`;
DELIMITER $$
CREATE PROCEDURE cinemas_getByName (IN name VARCHAR (255))
BEGIN
	SELECT * FROM `cinemas` WHERE `cinemas`.`name` = name;
END$$

DROP procedure IF EXISTS `cinemas_GetAll`;
DELIMITER $$
CREATE PROCEDURE cinemas_GetAll ()
BEGIN
	SELECT * FROM `cinemas`;
END$$

DROP procedure IF EXISTS `cinemas_modify`;
DELIMITER $$
CREATE PROCEDURE cinemas_modify (	IN id int,
									IN name VARCHAR (255),									
									IN address VARCHAR (255)
								)
BEGIN
	UPDATE cinemas SET cinemas.name = name, cinemas.address = address WHERE cinemas.id = id;
END$$
DELIMITER ;


DROP procedure IF EXISTS `cinemas_hasShows`;
DELIMITER $$
CREATE PROCEDURE cinemas_hasShows(IN id_cinema INT)
BEGIN
	SELECT *
	FROM cinemas
	INNER JOIN shows ON cinemas.id = shows.FK_id_cinema
	WHERE cinemas.id = id_cinema;
END$$


----------------------------- CINEMA ROOM -----------------------------

CREATE TABLE cinema_rooms (
	`id` INT AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(255) NOT NULL,
	`price` INT NOT NULL,
	`capacity` INT NOT NULL,
	`FK_id_cinema` INT NOT NULL,
	CONSTRAINT `FK_id_cinema_room` FOREIGN KEY (`FK_id_cinema`) REFERENCES `cinemas` (`id`)
);


DROP procedure IF EXISTS `cinemaRooms_deleteById`;
DELIMITER $$
CREATE PROCEDURE cinemaRooms_deleteById (IN id INT)
BEGIN
	DELETE FROM `cinema_rooms` WHERE `cinema_rooms`.`id` = id;
END$$

DROP procedure IF EXISTS `cinemaRooms_getById`;
DELIMITER $$
CREATE PROCEDURE cinemaRooms_getById (IN id INT)
BEGIN
	SELECT * FROM `cinema_rooms` WHERE `cinema_rooms`.`id` = id;
END$$

DROP procedure IF EXISTS `cinemaRooms_getByNameAndCinema`;
DELIMITER $$
CREATE PROCEDURE cinemaRooms_getByNameAndCinema (IN name VARCHAR(255),
												 IN id_cinema INT
												)
BEGIN
	SELECT * FROM `cinema_rooms` WHERE `cinema_rooms`.`name` = `name` AND `cinema_rooms`.`FK_id_cinema` = `id_cinema`;
END$$

DROP procedure IF EXISTS `cinemaRooms_getByName`;
DELIMITER $$
CREATE PROCEDURE cinemaRooms_getByName (IN name VARCHAR (255))
BEGIN
	SELECT * FROM `cinema_rooms` WHERE `cinema_rooms`.`name` = name;
END$$

DROP procedure IF EXISTS `cinemaRooms_GetAll`;
DELIMITER $$
CREATE PROCEDURE cinemaRooms_GetAll ()
BEGIN
	SELECT 
		cinema_rooms.id as cinema_room_id,
		cinema_rooms.name as cinema_room_name,
		cinema_rooms.capacity as cinema_room_capacity,
		cinema_rooms.price as cinema_room_price,
		cinemas.id as cinema_id,
		cinemas.name as cinema_name,
		cinemas.address as cinema_address
	FROM cinema_rooms
	INNER JOIN cinemas ON cinema_rooms.FK_id_cinema = cinemas.id;
END$$

DROP procedure IF EXISTS `cinemaRooms_modify`;
DELIMITER $$
CREATE PROCEDURE cinemaRooms_modify (	IN id int,
									IN name VARCHAR (255),
									IN capacity int,
									IN price int
								)
BEGIN
	UPDATE cinema_rooms SET cinema_rooms.name = name, cinema_rooms.address = address,cinema_rooms.capacity = capacity, cinema_rooms.price = price  WHERE cinema_rooms.id = id;
END$$
DELIMITER ;

DROP procedure IF EXISTS `cinemaRooms_hasShows`;
DELIMITER $$
CREATE PROCEDURE cinemaRooms_hasShows(IN id INT)
BEGIN
	SELECT *
	FROM cinema_rooms
	INNER JOIN shows ON cinema_rooms.id = shows.FK_id_cinemaRoom
	WHERE cinema_rooms.id = id;
END$$


----------------------------- MOVIES -----------------------------

CREATE TABLE movies (
	`id` int NOT NULL PRIMARY KEY,
	`popularity` VARCHAR (255) NOT NULL,
	`vote_count` VARCHAR (255) NOT NULL,
	`video` VARCHAR (255) NOT NULL,
	`poster_path` VARCHAR (255) NOT NULL,
	`adult` VARCHAR (255) NOT NULL,
	`backdrop_path` VARCHAR (255) NOT NULL,
	`original_language` VARCHAR (255) NOT NULL,
	`original_title` VARCHAR (255) NOT NULL,
	`genre_ids` VARCHAR (255) NULL,
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

DROP procedure IF EXISTS `movies_getByTitle`;
DELIMITER $$
CREATE PROCEDURE movies_getByTitle (IN title VARCHAR(255))
BEGIN
	SELECT * FROM `movies` WHERE `movies`.`title` = title;
END$$

DROP procedure IF EXISTS `movies_getAll`;
DELIMITER $$
CREATE PROCEDURE movies_getAll ()
BEGIN
	SELECT * FROM `movies` ORDER BY title ASC;
END$$

DROP procedure IF EXISTS `movies_add_runtime`;
DELIMITER $$
CREATE PROCEDURE movies_add_runtime (IN id INT, IN runtime INT)
BEGIN
	UPDATE movies
	SET movies.runtime = runtime
	WHERE movies.id = id;
END$$

DROP procedure IF EXISTS `movies_add_details`;
DELIMITER $$
CREATE PROCEDURE movies_add_details (
								IN id INT,
								IN popularity VARCHAR(255),
								IN vote_count VARCHAR(255),
								IN video VARCHAR (255),
								IN poster_path VARCHAR(255),
								IN adult VARCHAR(255),
 								IN backdrop_path VARCHAR (255),
								IN original_language VARCHAR(255),
								IN original_title VARCHAR(255),								
								IN title VARCHAR(255),
								IN vote_average VARCHAR(255),
 								IN overview VARCHAR (255),
								IN release_date DATE,
								IN runtime INT)
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
			movies.title,
			movies.vote_average,
			movies.overview,
			movies.release_date,
			movies.runtime
	)
    VALUES
        (id, popularity, vote_count, video, poster_path, adult, backdrop_path, original_language, original_title, title, vote_average, overview, release_date, runtime);
END$$

DROP procedure IF EXISTS `movies_deleteById`;
DELIMITER $$
CREATE PROCEDURE movies_deleteById (IN id INT)
BEGIN
	DELETE FROM `movies` WHERE `movies`.`id` = id;
END$$

DROP procedure IF EXISTS `movies_hasShows`;
DELIMITER $$
CREATE PROCEDURE movies_hasShows(IN id_movie INT)
BEGIN
	SELECT *
	FROM movies
	INNER JOIN shows ON movies.id = shows.FK_id_movie
	WHERE movies.id = id_movie;
END$$

----------------------------- SHOWS	 -----------------------------

CREATE TABLE shows (
	`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`FK_id_cinemaRoom` int,
	`FK_id_movie` int,
	`date_start` DATE NOT NULL,
	`time_start` TIME NOT NULL,
	`date_end` DATE NOT NULL,
	`time_end` TIME NOT NULL,
	CONSTRAINT `FK_id_cinemaRoom_show` FOREIGN KEY (`FK_id_cinemaRoom`) REFERENCES `cinema_rooms` (`id`),
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
			cinema_rooms.id AS cinema_rooms_id,
			cinema_rooms.name AS cinema_rooms_name
	FROM `shows`
	INNER JOIN movies ON movies.id = shows.FK_id_movie
	INNER JOIN cinema_rooms ON cinema_rooms.id = shows.FK_id_cinemaRoom
	ORDER BY movies.title ASC;
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
            movies.backdrop_path AS movies_backdrop_path,
			cinema_rooms.id AS cinema_room_id,
			cinema_rooms.name AS cinema_rooms_name,
            cinema_rooms.capacity AS cinema_rooms_capacity,
            cinema_rooms.price AS cinema_rooms_price
	FROM `shows`
	INNER JOIN movies ON movies.id = shows.FK_id_movie
	INNER JOIN cinema_rooms ON cinema_rooms.id = shows.FK_id_cinemaRoom
	WHERE (shows.id = id);
END$$

DROP procedure IF EXISTS `shows_modify`;
DELIMITER $$
CREATE PROCEDURE shows_modify (		IN id int,
									IN id_cinemaRoom INT,
									IN id_movie INT,
									IN date_start DATE,
									IN time_start TIME,
									IN date_end DATE,
									IN time_end TIME)
BEGIN
	UPDATE shows SET shows.	FK_id_cinemaRoom = id_cinemaRoom, shows.FK_id_movie = id_movie, shows.date_start = date_start, shows.time_start = time_start, shows.date_end = date_end, shows.time_end = time_end WHERE shows.id = id;
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

DROP procedure IF EXISTS `shows_getByCinemaRoomId`;
DELIMITER $$
CREATE PROCEDURE shows_getByCinemaRoomId (IN id_cinemaRoom INT)
BEGIN
	SELECT 	*
	FROM `shows`
	WHERE (shows.FK_id_cinemaRoom = id_cinemaRoom);
END$$

DROP procedure IF EXISTS `shows_getShowsOfMovie`;
DELIMITER $$
CREATE PROCEDURE shows_getShowsOfMovie (IN id_movie INT)
BEGIN
	SELECT 
		shows.id as show_id,
		shows.date_start as show_date_start,
		shows.time_start as show_time_start,
		cinema_rooms.name as cinema_rooms_name
	FROM shows 
	INNER JOIN 
		movies ON shows.FK_id_movie = movies.id
	INNER JOIN 
		cinema_rooms ON cinema_rooms.id = shows.FK_id_cinemaRoom
	WHERE ( (shows.FK_id_movie = id_movie) AND (shows.date_start >= curdate()) ) 
	ORDER BY shows.date_start ASC, shows.time_start ASC;
END$$

----------------------------- PURCHASE -----------------------------

CREATE TABLE purchases (
	`id_purchase` int AUTO_INCREMENT NOT NULL PRIMARY KEY,
	`ticket_quantity` int NOT NULL,
	`discount` int NOT NULL,
	`date` date NOT NULL,
	`total` int NOT NULL,
	`FK_dni` int NOT NULL,
	CONSTRAINT `FK_dni_purchase` FOREIGN KEY (`FK_dni`) REFERENCES `profile_users` (`dni`)
)

DROP PROCEDURE IF EXISTS `purchases_Add`;
DELIMITER $$
CREATE PROCEDURE purchases_Add(IN ticket_quantity int, IN discount int, IN date DATE, IN total int, IN dni_user int, OUT id int)
BEGIN
    INSERT INTO purchases(purchases.ticket_quantity, purchases.discount, purchases.date, purchases.total, purchases.FK_dni)
    VALUES (ticket_quantity, discount, date, total, dni_user);	
END$$


DROP PROCEDURE IF EXISTS 'purchases_GetByData';
DELIMITER $$
CREATE PROCEDURE purchases_GetByData(IN ticket_quantity int, IN discount int, IN date DATE, IN total int, IN dni_user int)
BEGIN 
    SELECT purchases.id_purchase AS purchases_id_purchase,
    FROM purchases
    WHERE(purchases.ticket_quantity = ticket_quantity AND purchases.discount = discount AND purchases.date = date AND purchases.total = total AND purchases.FK_dni = dni_user );
END$$


DROP PROCEDURE IF EXISTS 'purchases_GetById';
DELIMITER $$
CREATE PROCEDURE purchases_GetById(IN id int)
BEGIN 
    SELECT purchases.id_purchase AS purchases_id_purchase,
           purchases.ticket_quantity AS purchases_ticket_quantity,
           purchases.discount AS purchases_discount,
           purchases.date AS purchases_date,
           purchases.total AS purchases_total,
           purchases.FK_dni AS purchases_FK_dni
    FROM purchases
    WHERE(purchases.id_purchases = id);
END$$

-- NO ME ANDA
DROP PROCEDURE IF EXISTS `purchases_GetAll`;
DELIMITER $$
CREATE PROCEDURE purchases_GetAll()
BEGIN
	SELECT purchases.id_purchase AS purchases_id_purchase,
           purchases.ticket_quantity AS purchases_ticket_quantity,
           purchases.discount AS purchases_discount,
           purchases.date AS purchases_date,
           purchases.total AS purchases_total,
           purchases.FK_dni AS purchases_FK_dni
	FROM purchases;
END$$

DROP PROCEDURE IF EXISTS `purchases_GetByDni`;
DELIMITER $$
CREATE PROCEDURE purchases_GetByDni(IN dni int)
BEGIN 
    SELECT purchases.id_purchase AS purchases_id_purchase,
           purchases.ticket_quantity AS purchases_ticket_quantity,
           purchases.discount AS purchases_discount,
           purchases.date AS purchases_date,
           purchases.total AS purchases_total,
           purchases.FK_dni AS purchases_FK_dni
    FROM purchases
    WHERE(purchases.FK_dni = dni);
END$$

----------------------------- TICKET -----------------------------

CREATE TABLE tickets (
	`ticket_number` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`QR` int NOT NULL,
	`FK_id_purchase` int NOT NULL,
	`FK_id_show` int NOT NULL,
	CONSTRAINT `FK_id_purchase` FOREIGN KEY (`FK_id_purchase`) REFERENCES `purchases` (`id_purchase`),
	CONSTRAINT `FK_id_show` FOREIGN KEY (`FK_id_show`) REFERENCES `shows` (`id`)
);

DROP PROCEDURE IF EXISTS `tickets_Add`;
DELIMITER $$
CREATE PROCEDURE tickets_Add(IN qr int, IN id_purchase int, IN id_show int)
BEGIN
    INSERT INTO tickets(tickets.qr, tickets.FK_id_purchase, tickets.FK_id_show)
    VALUES (qr, id_purchase, id_show);
END$$

DROP PROCEDURE IF EXISTS `tickets_GetByNumber`;
DELIMITER $$
CREATE PROCEDURE tickets_GetByNumber(IN number int)
BEGIN
    SELECT tickets.ticket_number AS tickets_ticket_number,
           tickets.QR AS tickets_QR,
           tickets.FK_id_purchase AS tickets_FK_id_purchase,
           shows.FK_id_show AS shows_FK_id_show
    FROM tickets
    WHERE(tickets.ticket_number = number);
END$$

-- NO ME ANDA
DROP PROCEDURE IF EXISTS `tickets_GetAll`;
DELIMITER $$
CREATE PROCEDURE tickets_GetAll()
BEGIN
	SELECT tickets.ticket_number AS tickets_ticket_number,
           tickets.QR AS tickets_QR,
           tickets.FK_id_purchase AS tickets_FK_id_purchase,
           tickets.FK_id_show AS tickets_FK_id_show
	FROM tickets;
END$$

DROP PROCEDURE IF EXISTS `tickets_GetByShowId`;
DELIMITER $$
CREATE PROCEDURE tickets_GetByShowId(IN id_show int)
BEGIN
    SELECT *
    FROM tickets
    WHERE(tickets.FK_id_show = id_show);
END$$



----------------------------- GENRE -----------------------------

CREATE TABLE genres (
	`id` int NOT NULL PRIMARY KEY,
	`name` VARCHAR (255) NOT NULL
);

DROP PROCEDURE IF EXISTS `genres_GetAll`;
DELIMITER $$
CREATE PROCEDURE genres_GetAll()
BEGIN
    SELECT * 
    FROM genres 
	ORDER BY name ASC; 
END$$

DROP PROCEDURE IF EXISTS `genres_getById`;
DELIMITER $$
CREATE PROCEDURE genres_getById(IN id int)
BEGIN
    SELECT * 
    FROM genres 
	WHERE(genres.id = id); 
END$$

----------------------------- GENRE X MOVIE -----------------------------

CREATE TABLE genres_x_movies (
	`FK_id_genre` int NOT NULL,
	`FK_id_movie` int NOT NULL,
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
	INNER JOIN movies ON genres_x_movies.FK_id_movie = movies.id 
	INNER JOIN shows ON movies.id = shows.FK_id_movie
	WHERE (genres_x_movies.FK_id_genre = id_genre)
	GROUP BY movies.id;
END$$

DROP procedure IF EXISTS `genresxmovies_getByDate`;					    
DELIMITER $$
CREATE PROCEDURE genresxmovies_getByDate (IN date_show DATE)
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
	INNER JOIN movies ON FK_id_movie = movies.id 
	INNER JOIN shows ON movies.id = shows.FK_id_movie
	WHERE (shows.date_start = date_show)
	GROUP BY movies.id;
END$$

DROP procedure IF EXISTS `genresxmovies_getByGenreAndDate`;					    
DELIMITER $$
CREATE PROCEDURE genresxmovies_getByGenreAndDate (IN id_genre INT, IN date_show DATE)
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
	INNER JOIN movies ON FK_id_movie = movies.id 
	INNER JOIN shows ON movies.id = shows.FK_id_movie
	WHERE (FK_id_genre = id_genre AND shows.date_start = date_show)
	GROUP BY movies.id;
END$$

DROP procedure IF EXISTS `genresxmovies_getGenresOfMovie`;					    
DELIMITER $$
CREATE PROCEDURE genresxmovies_getGenresOfMovie (IN id_movie INT)
BEGIN
	SELECT 	*
	FROM genres_x_movies
	INNER JOIN movies ON movies.id = FK_id_movie
	INNER JOIN genres ON FK_id_genre = genres.id						
	WHERE (FK_id_movie = id_movie);
END$$

DROP procedure IF EXISTS `genresxmovies_getGenresOfShows`;					    
DELIMITER $$
CREATE PROCEDURE genresxmovies_getGenresOfShows ()
BEGIN
	SELECT 	genres.name, genres.id
	FROM genres_x_movies
	INNER JOIN movies ON movies.id = genres_x_movies.FK_id_movie
	INNER JOIN genres ON genres_x_movies.FK_id_genre = genres.id
	INNER JOIN shows ON shows.FK_id_movie = genres_x_movies.FK_id_movie						
	WHERE (genres_x_movies.FK_id_movie = shows.FK_id_movie)
	GROUP BY genres.name;
END$$


----------------------------- ROOMS -----------------------------
