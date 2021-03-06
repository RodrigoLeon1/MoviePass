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

DROP procedure IF EXISTS `roles_getAll`;
DELIMITER $$
CREATE PROCEDURE roles_getAll ()
BEGIN
	SELECT *
    FROM roles;    
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

DROP procedure IF EXISTS `profile_users_add`;
DELIMITER $$
CREATE PROCEDURE profile_users_add (
								IN dni INT,
								IN first_name VARCHAR(255),
								IN last_name VARCHAR(255)
							 )
BEGIN
	INSERT INTO profile_users (
			profile_users.dni,
			profile_users.first_name,
			profile_users.last_name
	)
    VALUES
        (dni, first_name, last_name);
END$$

----------------------------- USERS -----------------------------

CREATE TABLE users (
	`mail` VARCHAR (255) NOT NULL UNIQUE,
	`password` VARCHAR (255) NOT NULL,
	`FK_dni` int PRIMARY KEY,
	`FK_id_role` int,
	`is_active` BOOLEAN NOT NULL DEFAULT TRUE
	CONSTRAINT `FK_dni` FOREIGN KEY (`FK_dni`) REFERENCES `profile_users` (`dni`),
	CONSTRAINT `FK_id_role` FOREIGN KEY (`FK_id_role`) REFERENCES `roles` (`id`)
);

INSERT INTO `users` (`mail`, `password`, `FK_dni`, `FK_id_role`)
	VALUES	('admin@admin.com', '123', '11111111', '1'),
			('user@user.com', '123', '00000000', '0');


DROP procedure IF EXISTS `users_add`;
DELIMITER $$
CREATE PROCEDURE users_add (
								IN mail VARCHAR(255),
								IN password VARCHAR(255),
								IN FK_dni INT,
								IN FK_id_role INT								
							 )
BEGIN
	INSERT INTO users (
			users.mail,
			users.password,
			users.FK_dni,
			users.FK_id_role
	)
    VALUES
        (mail, password, FK_dni, FK_id_role);
END$$

DROP procedure IF EXISTS `users_getByMail`;
DELIMITER $$
CREATE PROCEDURE users_getByMail (IN mail VARCHAR(255))
BEGIN
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

DROP procedure IF EXISTS `users_getAll`;
DELIMITER $$
CREATE PROCEDURE users_getAll ()
BEGIN
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
END $$

DROP procedure IF EXISTS `users_disableByDni`;
DELIMITER $$
CREATE PROCEDURE users_disableByDni (IN dni INT)
BEGIN
	UPDATE `users` SET users.is_active = false WHERE `users`.`FK_dni` = dni;
END$$

DROP procedure IF EXISTS `users_enableByDni`;
DELIMITER $$
CREATE PROCEDURE users_enableByDni (IN dni INT)
BEGIN
	UPDATE `users` SET users.is_active = true WHERE `users`.`FK_dni` = dni;
END$$


----------------------------- IMAGES -----------------------------
CREATE TABLE images (
	`imageId` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`name` VARCHAR(100) NOT NULL,
	`FK_dni_user` INT NOT NULL	
	CONSTRAINT `FK_dni_image` FOREIGN KEY (`FK_dni_user`) REFERENCES `profile_users` (`dni`),
);

DROP procedure IF EXISTS `images_add`;
DELIMITER $$
CREATE PROCEDURE images_add(
							IN name VARCHAR(100),
							IN dni_user INT
							)
BEGIN
    INSERT INTO images
    	(name, FK_dni_user)
	VALUES
		(name, dni_user);
END$$

DROP procedure IF EXISTS `images_getByUser`;
DELIMITER $$
CREATE PROCEDURE images_getByUser (IN dni INT)
BEGIN
	SELECT *
	FROM images	
    WHERE (images.FK_dni_user = dni);
END$$

----------------------------- CINEMAS -----------------------------

CREATE TABLE cinemas (
	`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(255) NOT NULL,
	`address` VARCHAR(255) NOT NULL,
	`is_active` BOOLEAN NOT NULL DEFAULT TRUE
);

DROP procedure IF EXISTS `cinemas_add`;
DELIMITER $$
CREATE PROCEDURE cinemas_add (
								IN name VARCHAR(255),
								IN address VARCHAR(255)
							 )
BEGIN
	INSERT INTO cinemas (
			cinemas.name,
			cinemas.address
	)
    VALUES
        (name, address);
END$$

DROP procedure IF EXISTS `cinemas_disableById`;
DELIMITER $$
CREATE PROCEDURE cinemas_disableById (IN id INT)
BEGIN
	UPDATE `cinemas` SET `cinemas`.`is_active` = false WHERE `cinemas`.`id` = id;
END$$

DROP procedure IF EXISTS `cinemas_enableById`;
DELIMITER $$
CREATE PROCEDURE cinemas_enableById (IN id INT)
BEGIN
	UPDATE `cinemas` SET `cinemas`.`is_active` = true WHERE `cinemas`.`id` = id;
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

DROP procedure IF EXISTS `cinemas_GetAllActives`;
DELIMITER $$
CREATE PROCEDURE cinemas_GetAllActives ()
BEGIN
	SELECT * FROM `cinemas` WHERE `cinemas`.`is_active` = true ORDER BY `cinemas`.name;
END$$

DROP procedure IF EXISTS `cinemas_GetAll`;
DELIMITER $$
CREATE PROCEDURE cinemas_GetAll ()
BEGIN
	SELECT * FROM `cinemas` ORDER BY `cinemas`.name;
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
	INNER JOIN cinema_rooms ON cinemas.id = cinema_rooms.FK_id_cinema
	INNER JOIN shows ON cinema_rooms.id = shows.FK_id_cinemaRoom
	WHERE cinemas.id = id_cinema;
END$$


----------------------------- CINEMA ROOM -----------------------------

CREATE TABLE cinema_rooms (
	`id` INT AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(255) NOT NULL,
	`price` INT NOT NULL,
	`capacity` INT NOT NULL,
	`FK_id_cinema` INT NOT NULL,
	`is_active` BOOLEAN NOT NULL DEFAULT TRUE,
	CONSTRAINT `FK_id_cinema_room` FOREIGN KEY (`FK_id_cinema`) REFERENCES `cinemas` (`id`)
);

DROP procedure IF EXISTS `cinema_rooms_add`;
DELIMITER $$
CREATE PROCEDURE cinema_rooms_add (
								IN name VARCHAR(255),
								IN price INT,
								IN capacity INT,
								IN id_cinema INT
							 )
BEGIN
	INSERT INTO cinema_rooms (
			cinema_rooms.name,
			cinema_rooms.price,
			cinema_rooms.capacity,
			cinema_rooms.FK_id_cinema
	)
    VALUES
        (name, price, capacity, id_cinema);
END$$

DROP procedure IF EXISTS `cinemaRooms_enableById`;
DELIMITER $$
CREATE PROCEDURE cinemaRooms_enableById (IN id INT)
BEGIN
	UPDATE `cinema_rooms` SET `cinema_rooms`.`is_active` = true WHERE `cinema_rooms`.`id` = id;
END$$

DROP procedure IF EXISTS `cinemaRooms_disableById`;
DELIMITER $$
CREATE PROCEDURE cinemaRooms_disableById (IN id INT)
BEGIN
	UPDATE `cinema_rooms` SET `cinema_rooms`.`is_active` = false WHERE `cinema_rooms`.`id` = id;
END$$

DROP procedure IF EXISTS `cinemaRooms_getById`;
DELIMITER $$
CREATE PROCEDURE cinemaRooms_getById (IN id INT)
BEGIN
	SELECT * FROM `cinema_rooms` WHERE `cinema_rooms`.`id` = id;
END$$

DROP procedure IF EXISTS `cinemaRooms_getByIdShow`;
DELIMITER $$
CREATE PROCEDURE cinemaRooms_getByIdShow (IN id INT)
BEGIN
	SELECT * FROM `cinema_rooms`
	INNER JOIN shows ON shows.FK_id_cinemaRoom = cinema_rooms.id
	WHERE shows.id = id;
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
		cinema_rooms.is_active as cinema_room_is_active,
		cinemas.id as cinema_id,
		cinemas.name as cinema_name,
		cinemas.address as cinema_address
	FROM cinema_rooms
	INNER JOIN cinemas ON cinema_rooms.FK_id_cinema = cinemas.id
	ORDER BY cinemas.name ASC;
END$$

DROP procedure IF EXISTS `cinemaRooms_GetAllActives`;
DELIMITER $$
CREATE PROCEDURE cinemaRooms_GetAllActives ()
BEGIN
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

DROP procedure IF EXISTS `cinemaRooms_modify`;
DELIMITER $$
CREATE PROCEDURE cinemaRooms_modify (	IN id int,
									IN name VARCHAR (255),
									IN capacity int,
									IN price int
								)
BEGIN
	UPDATE cinema_rooms SET cinema_rooms.name = name, cinema_rooms.capacity = capacity, cinema_rooms.price = price
	WHERE cinema_rooms.id = id;
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
	`poster_path` VARCHAR (255) NOT NULL,	
	`backdrop_path` VARCHAR (255) NOT NULL,		
	`title` VARCHAR (255) NOT NULL,
	`vote_average` VARCHAR (255) NOT NULL,
	`overview` TEXT NOT NULL,
	`release_date` DATE NOT NULL,
	`runtime` INT,
	`is_active` BOOLEAN NOT NULL DEFAULT TRUE
);

DROP procedure IF EXISTS `movies_add`;
DELIMITER $$
CREATE PROCEDURE movies_add (
								IN id INT,								
								IN poster_path VARCHAR(255),								
 								IN backdrop_path VARCHAR (255),																
								IN title VARCHAR(255),
								IN vote_average VARCHAR(255),
 								IN overview VARCHAR (255),
								IN release_date DATE)
BEGIN
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

DROP procedure IF EXISTS `movies_getId`;
DELIMITER $$
CREATE PROCEDURE movies_getId ()
BEGIN
	SELECT movies.id FROM `movies`;
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
	SELECT
		movies.id AS movie_id,
		movies.title AS movie_title,
		movies.poster_path AS movie_poster_path,
		movies.vote_average AS movie_vote_average,
		movies.overview AS movie_overview
	FROM movies 
	INNER JOIN shows ON movies.id = shows.FK_id_movie
	WHERE movies.title LIKE CONCAT('%', title , '%')
	GROUP BY movies.id;
END$$

DROP procedure IF EXISTS `movies_getAll`;
DELIMITER $$
CREATE PROCEDURE movies_getAll ()
BEGIN
	SELECT * FROM `movies` ORDER BY title ASC;
END$$

DROP procedure IF EXISTS `movies_getAllActives`;
DELIMITER $$
CREATE PROCEDURE movies_getAllActives ()
BEGIN
	SELECT * FROM `movies` WHERE `movies`.`is_active` = true ORDER BY title ASC;
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
								IN poster_path VARCHAR(255),								
 								IN backdrop_path VARCHAR (255),
								IN title VARCHAR(255),
								IN vote_average VARCHAR(255),
 								IN overview VARCHAR (255),
								IN release_date DATE,
								IN runtime INT)
BEGIN
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
        (id, poster_path, backdrop_path, title, vote_average, overview, release_date, runtime);
END$$

DROP procedure IF EXISTS `movies_disableById`;
DELIMITER $$
CREATE PROCEDURE movies_disableById (IN id INT)
BEGIN
	UPDATE `movies` SET `movies`.`is_active` = false WHERE `movies`.`id` = id;
END$$

DROP procedure IF EXISTS `movies_enableById`;
DELIMITER $$
CREATE PROCEDURE movies_enableById (IN id INT)
BEGIN
	UPDATE `movies` SET `movies`.`is_active` = true WHERE `movies`.`id` = id;
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
	`is_active` BOOLEAN NOT NULL DEFAULT TRUE,
	CONSTRAINT `FK_id_cinemaRoom_show` FOREIGN KEY (`FK_id_cinemaRoom`) REFERENCES `cinema_rooms` (`id`),
	CONSTRAINT `FK_id_movie` FOREIGN KEY (`FK_id_movie`) REFERENCES `movies` (`id`)
);

DROP procedure IF EXISTS `shows_add`;
DELIMITER $$
CREATE PROCEDURE shows_add (
								IN FK_id_cinemaRoom INT,
								IN FK_id_movie INT,
								IN date_start DATE,
								IN time_start TIME,
								IN date_end DATE,
								IN time_end TIME
							 )
BEGIN
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

DROP procedure IF EXISTS `shows_getAll`;
DELIMITER $$
CREATE PROCEDURE shows_getAll ()
BEGIN
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

DROP procedure IF EXISTS `shows_getAllActives`;
DELIMITER $$
CREATE PROCEDURE shows_getAllActives ()
BEGIN
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

DROP procedure IF EXISTS `shows_disableById`;
DELIMITER $$
CREATE PROCEDURE shows_disableById (IN id INT)
BEGIN
	UPDATE `shows` SET `shows`.`is_active` = false WHERE `shows`.`id` = id;
END$$

DROP procedure IF EXISTS `shows_enableById`;
DELIMITER $$
CREATE PROCEDURE shows_enableById (IN id INT)
BEGIN
	UPDATE `shows` SET `shows`.`is_active` = true WHERE `shows`.`id` = id;
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

----------------------------- PURCHASE -----------------------------

CREATE TABLE purchases (
	`id` int AUTO_INCREMENT NOT NULL PRIMARY KEY,
	`ticket_quantity` int NOT NULL,
	`discount` int NOT NULL,
	`date` date NOT NULL,
	`total` int NOT NULL,
	`FK_dni` int NOT NULL,
	`FK_payment_cc` int NOT NULL,
	CONSTRAINT `FK_dni_purchase` FOREIGN KEY (`FK_dni`) REFERENCES `profile_users` (`dni`),
	CONSTRAINT `FK_payment_purchase` FOREIGN KEY (`FK_payment_cc`) REFERENCES `payments_credit_card` (`id`)
)

DROP PROCEDURE IF EXISTS `purchases_Add`;
DELIMITER $$
CREATE PROCEDURE purchases_Add(
								IN ticket_quantity int, 
								IN discount int, 
								IN date DATE, 
								IN total int, 
								IN dni_user int, 
								IN FK_payment_cc int,
								OUT lastId int
							)
BEGIN
    INSERT INTO purchases(purchases.ticket_quantity, purchases.discount, purchases.date, purchases.total, purchases.FK_dni, purchases.FK_payment_cc)
    VALUES (ticket_quantity, discount, date, total, dni_user, FK_payment_cc);
	SET lastId = LAST_INSERT_ID();	
	SELECT lastId;
END$$


DROP PROCEDURE IF EXISTS `purchases_GetByData`;
DELIMITER $$
CREATE PROCEDURE purchases_GetByData(IN ticket_quantity int, IN discount int, IN date DATE, IN total int, IN dni_user int)
BEGIN 
    SELECT purchases.id AS purchases_id_purchase
    FROM purchases
    WHERE(purchases.ticket_quantity = ticket_quantity AND purchases.discount = discount AND purchases.date = date AND purchases.total = total AND purchases.FK_dni = dni_user );
END$$

DROP PROCEDURE IF EXISTS `purchases_GetById`;
DELIMITER $$
CREATE PROCEDURE purchases_GetById(IN id int)
BEGIN 
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

DROP PROCEDURE IF EXISTS `purchases_GetAll`;
DELIMITER $$
CREATE PROCEDURE purchases_GetAll()
BEGIN
	SELECT purchases.id AS purchases_id_purchase,
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


----------------------------- Payments Credit Card ----------------------

CREATE TABLE payments_credit_card (
	`id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`code_auth` int NOT NULL,
	`date` DATE NOT NULL,	
	`total` FLOAT NOT NULL,
	`FK_card` INT NOT NULL,
	CONSTRAINT `FK_card_company` FOREIGN KEY (`FK_card`) REFERENCES `credit_accounts` (`id`)
);

DROP PROCEDURE IF EXISTS `payments_credit_card_Add`;
DELIMITER $$
CREATE PROCEDURE payments_credit_card_Add (
							IN code_auth INT, 
							IN date DATE, 
							IN total FLOAT,
							IN FK_card INT,
							OUT lastId INT							
							)
BEGIN
    INSERT INTO payments_credit_card 
		(payments_credit_card.code_auth, payments_credit_card.date, payments_credit_card.total, payments_credit_card.FK_card)
    VALUES 
		(code_auth, date, total, FK_card);
	SET lastId = LAST_INSERT_ID();	
	SELECT lastId;
END$$

----------------------------- CREDIT ACCOUNTS -----------------------------

CREATE TABLE credit_accounts (
	`id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`company` VARCHAR(255) NOT NULL
);

DROP PROCEDURE IF EXISTS `credit_accounts_Add`;
DELIMITER $$
CREATE PROCEDURE credit_accounts_Add (
							IN company VARCHAR(255)
							)
BEGIN
    INSERT INTO credit_accounts 
		(credit_accounts.company)
    VALUES 
		(company);
END$$

DROP PROCEDURE IF EXISTS `credit_accounts_GetAll`;
DELIMITER $$
CREATE PROCEDURE credit_accounts_GetAll ()
BEGIN
    SELECT 
		*
	FROM
		credit_accounts;	
END$$

----------------------------- TICKET -----------------------------

CREATE TABLE tickets (
	`ticket_number` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`QR` int NOT NULL,
	`FK_id_purchase` int NOT NULL,
	`FK_id_show` int NOT NULL,
	CONSTRAINT `FK_id_purchase` FOREIGN KEY (`FK_id_purchase`) REFERENCES `purchases` (`id`),
	CONSTRAINT `FK_id_show` FOREIGN KEY (`FK_id_show`) REFERENCES `shows` (`id`)
);

DROP PROCEDURE IF EXISTS `tickets_Add`;
DELIMITER $$
CREATE PROCEDURE tickets_Add (
							IN qr int, 
							IN id_purchase int, 
							IN id_show int
							)
BEGIN
    INSERT INTO tickets (tickets.qr, tickets.FK_id_purchase, tickets.FK_id_show)
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


-- c) Consultar cantidades vendidas y remanentes de las proyecciones (Película, Cine, Turno)

DROP PROCEDURE IF EXISTS `tickets_GetInfoTicket`;
DELIMITER $$
CREATE PROCEDURE tickets_GetInfoTicket()
BEGIN
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

-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 
DROP PROCEDURE IF EXISTS `tickets_ShowsTickets`;
DELIMITER $$
CREATE PROCEDURE tickets_ShowsTickets()
BEGIN
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


-- Cuento la cantidad de tickets comprados que tiene un show
DROP PROCEDURE IF EXISTS `tickets_getTicketsOfShows`;
DELIMITER $$
CREATE PROCEDURE tickets_getTicketsOfShows(IN id_show INT)
BEGIN
	SELECT
		count(FK_id_show)
	FROM tickets
	WHERE tickets.FK_id_show = id_show;
END$$

-- d) Consultar totales vendidos en pesos (por película ó por cine, entre fechas)

-- Movies sales
DROP PROCEDURE IF EXISTS `tickets_getTicketsOfMovie`;
DELIMITER $$
CREATE PROCEDURE tickets_getTicketsOfMovie(IN id_movie INT)
BEGIN	
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

-- Cinema sales
DROP PROCEDURE IF EXISTS `tickets_getTicketsOfCinema`;
DELIMITER $$
CREATE PROCEDURE tickets_getTicketsOfCinema(IN id_cinema INT)
BEGIN	
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

-- Cinema rooms sales
DROP PROCEDURE IF EXISTS `tickets_getTicketsOfCinemaRoom`;
DELIMITER $$
CREATE PROCEDURE tickets_getTicketsOfCinemaRoom(IN id_cinema_room INT)
BEGIN	
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


----------------------------- GENRE -----------------------------

CREATE TABLE genres (
	`id` int NOT NULL PRIMARY KEY,
	`name` VARCHAR (255) NOT NULL
);

DROP procedure IF EXISTS `genres_add`;
DELIMITER $$
CREATE PROCEDURE genres_add (
								IN id INT,
								IN name VARCHAR(255)
							 )
BEGIN
	INSERT INTO genres (
			genres.id,
			genres.name
	)
    VALUES
        (id, name);
END$$


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

DROP procedure IF EXISTS `genresxmovies_add`;
DELIMITER $$
CREATE PROCEDURE genresxmovies_add (
								IN FK_id_genre INT,
								IN FK_id_movie INT
							 )
BEGIN
	INSERT INTO genres_x_movies (
			genres_x_movies.FK_id_genre,
			genres_x_movies.FK_id_movie
	)
    VALUES
        (FK_id_genre, FK_id_movie);
END$$

DROP procedure IF EXISTS `genresxmovies_getAll`;					    
DELIMITER $$
CREATE PROCEDURE genresxmovies_getAll ()
BEGIN
	SELECT 	*
	FROM genres_x_movies;	
END$$

DROP procedure IF EXISTS `genresxmovies_getByGenre`;					    
DELIMITER $$
CREATE PROCEDURE genresxmovies_getByGenre (IN id_genre INT)
BEGIN
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

DROP procedure IF EXISTS `genresxmovies_getByDate`;					    
DELIMITER $$
CREATE PROCEDURE genresxmovies_getByDate (IN date_show DATE)
BEGIN
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

DROP procedure IF EXISTS `genresxmovies_getByGenreAndDate`;					    
DELIMITER $$
CREATE PROCEDURE genresxmovies_getByGenreAndDate (IN id_genre INT, IN date_show DATE)
BEGIN
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
	WHERE (genres_x_movies.FK_id_movie = shows.FK_id_movie) AND (shows.date_start >= curdate()) AND (shows.is_active = true)	
	GROUP BY genres.name;
END$$

