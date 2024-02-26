/*
Created: 11. 02. 2024
Modified: 26. 02. 2024
Model: Afna
Database: MySQL 8.0
*/

-- Create tables section -------------------------------------------------

-- Table tab_users

CREATE TABLE `tab_users`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `first_name` Varchar(100) NOT NULL,
  `last_name` Varchar(100) NOT NULL,
  `password` Varchar(255) NOT NULL,
  `email` Varchar(100) NOT NULL,
  `telephone` Varchar(50),
  `description` Varchar(255),
  `relationship_status` Int(1) NOT NULL,
  `gender` Int(1) NOT NULL,
  PRIMARY KEY (`id`)
)
;

-- Table tab_posts

CREATE TABLE `tab_posts`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `description` Varchar(255),
  `date_add` Datetime NOT NULL,
  `user_id` Int,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship3` ON `tab_posts` (`user_id`)
;

-- Table tab_pictures

CREATE TABLE `tab_pictures`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `url` Varchar(255) NOT NULL,
  `description` Varchar(255),
  `post_id` Int NOT NULL,
  `user_id` Int NOT NULL,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship4` ON `tab_pictures` (`post_id`)
;

CREATE INDEX `IX_Relationship7` ON `tab_pictures` (`user_id`)
;

-- Table tab_comments

CREATE TABLE `tab_comments`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `content` Varchar(255) NOT NULL,
  `date_add` Datetime NOT NULL,
  `post_id` Int NOT NULL,
  `user_id` Int NOT NULL,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship5` ON `tab_comments` (`post_id`)
;

CREATE INDEX `IX_Relationship12` ON `tab_comments` (`user_id`)
;

-- Table tab_user_follower

CREATE TABLE `tab_user_follower`
(
  `user_id` Int,
  `follower_id` Int,
  `id` Int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship8` ON `tab_user_follower` (`user_id`)
;

CREATE INDEX `IX_Relationship10` ON `tab_user_follower` (`follower_id`)
;

-- Create functions section -------------------------------------------------

CREATE FUNCTION `is_follower`
(p_user_following INTEGER, p_user_followed INTEGER)
RETURNS  tinyint(1)
SQL SECURITY DEFINER
BEGIN
    DECLARE w_vrni BOOLEAN;
    
    SELECT TRUE INTO w_vrni
    FROM tab_user_follower
    WHERE follower_id = p_user_following
      AND user_id = p_user_followed;
    
    RETURN nvl(w_vrni,0);
end
;

CREATE FUNCTION `profile_picture`
(p_user_id INTEGER)
RETURNS varchar(2000)
SQL SECURITY DEFINER
BEGIN
    DECLARE w_vrni VARCHAR(2000); 
    declare w_gender integer;
    
    SELECT url INTO w_vrni
    FROM tab_pictures
    WHERE user_id = p_user_id
    ORDER BY id DESC
    LIMIT 1;
   
   if (w_vrni is null) then
     select gender into w_gender from tab_users where id = p_user_id;
     
    if (w_gender = 0) then
      select '/img/male_avatar.jpg' into w_vrni from dual;
    else
      select '/img/woman_avatar.png' into w_vrni from dual;
    end if;
   end if;
    
    RETURN w_vrni;
end
;

CREATE FUNCTION `num_comments`
(p_post_id INTEGER)
RETURNS INTEGER
SQL SECURITY DEFINER
BEGIN
    DECLARE w_vrni INTEGER;
    
    SELECT count(*) INTO w_vrni
    FROM tab_comments
    WHERE post_id = p_post_id;
    
    RETURN w_vrni;
END
;

-- Create views section -------------------------------------------------

CREATE VIEW `v_posts` AS
  select a.user_id, c.first_name, c.last_name, a.description, a.date_add, profile_picture(a.user_id) profile_pic, num_comments(a.id) num_comments
    from tab_posts a
    join tab_users c
      on c.id = a.user_id  
   order by a.date_add desc
;

-- Create foreign keys (relationships) section -------------------------------------------------

ALTER TABLE `tab_posts` ADD CONSTRAINT `tab_users__tab_posts` FOREIGN KEY (`user_id`) REFERENCES `tab_users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `tab_pictures` ADD CONSTRAINT `tab_posts__tab_pictures` FOREIGN KEY (`post_id`) REFERENCES `tab_posts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `tab_comments` ADD CONSTRAINT `tab_posts__tab_comments` FOREIGN KEY (`post_id`) REFERENCES `tab_posts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `tab_pictures` ADD CONSTRAINT `tab_users__tab_pictures` FOREIGN KEY (`user_id`) REFERENCES `tab_users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `tab_user_follower` ADD CONSTRAINT `tab_users__tab_user_follower` FOREIGN KEY (`user_id`) REFERENCES `tab_users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `tab_user_follower` ADD CONSTRAINT `tab_user_follower__tab_users` FOREIGN KEY (`follower_id`) REFERENCES `tab_users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `tab_comments` ADD CONSTRAINT `tab_users__tab_comments` FOREIGN KEY (`user_id`) REFERENCES `tab_users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

