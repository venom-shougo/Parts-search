CREATE TABLE users (
  id INT NOT NULL AUTO_INCREMENT,
  name varchar(16) UNIQUE NOT NULL,
  department varchar (16) NOT NULL,
  number varchar(10)UNIQUE NOT NULL,
  password varchar(64) NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);

CREATE TABLE images (
  id INT NOT NULL AUTO_INCREMENT,
  img_name varchar(32) NOT NULL,
  img_path varchar(255) NOT NULL,
  name varchar(16) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);

CREATE TABLE parts (
  id INT NOT NULL AUTO_INCREMENT,
  partname varchar(64) NOT NULL,
  model varchar(64),
  manufacturer varchar(64) NOT NULL,
  category varchar(32) NOT NULL,
  size varchar(64) NOT NULL,
  price DECIMAL(10,0) NOT NULL,
  supplier varchar(64),
  code varchar(16),
  phone varchar(16),
  image_id INT,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (image_id) REFERENCES images(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE order_history (
  id INT NOT NULL AUTO_INCREMENT,
  user_id INT NOT NULL,
  part_id INT NOT NULL,
  order_part_name varchar(64) NOT NULL,
  order_num varchar(10) NOT NULL,
  order_price varchar(10) NOT NULL,
  judge varchar(10) NOT NULL,
  remarks varchar(255) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE,
  FOREIGN KEY (part_id) REFERENCES parts(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);


CREATE TABLE machines (
  id INT NOT NULL AUTO_INCREMENT,
  part_id INT NOT NULL,
  img_name varchar(32) NOT NULL,
  img_path varchar(255) NOT NULL,
  machine_name varchar(32) NOT NULL,
  machine_number varchar(16) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (part_id) REFERENCES parts(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);


-- MySQLログイン
docker compose exec db bash -c 'mysql -u $MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE'

SHOW TABLES;

DELETE FROM parts;
SHOW COLUMNS FROM parts;
ALTER TABLE parts AUTO_INCREMENT=1;

DELETE FROM images;
SHOW COLUMNS FROM images;
ALTER TABLE images AUTO_INCREMENT=1;

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS images;
DROP TABLE IF EXISTS parts;
DROP TABLE IF EXISTS order_history;

-- 外部キー消す
ALTER TABLE parts DROP FOREIGN KEY `parts_ibfk_1`;
ALTER TABLE order_history DROP FOREIGN KEY `order_history_ibfk_1`;
ALTER TABLE order_history DROP FOREIGN KEY `order_history_ibfk_2`;
-- SELECT * FROM (SELECT id FROM order_history WHERE user_id < 10 ORDER BY user_id DESC LIMIT 1) UNION ALL SELECT * FROM (SELECT id FROM order_history WHERE user_id >= 10 ORDER BY user_id ASC LIMIT 5+1);

-- SELECT id FROM order_history WHERE user_id BETWEEN 10-1 AND 10+5 ORDER BY user_id;

(SELECT id FROM order_history WHERE user_id = 13 ORDER BY id LIMIT 0, 10) UNION ALL (SELECT id FROM order_history WHERE user_id = 13 ORDER BY id LIMIT 10, 20);

SELECT id, DATE_FORMAT(created_at,'%Y%m%d%H%i%s') AS date, order_part_name FROM order_history WHERE user_id = 13 ORDER BY id ASC LIMIT 10;

-- SELECT * FROM order_history WHERE = (SELECT id FROM order_history WHERE = user_id = 13) < 10 ORDER BY id DESC LIMIT 10;
SELECT * FROM order_history WHERE id < 10 ORDER BY id DESC LIMIT 10;

-- 成功
(SELECT * FROM order_history WHERE id <= 10 ORDER BY id DESC LIMIT 1) UNION (SELECT * FROM order_history WHERE id > 10 ORDER BY id DESC LIMIT 11);

SELECT id, DATE_FORMAT(created_at,'%Y%m%d%H%i%s') AS date, order_part_name FROM order_history WHERE user_id = 13 ORDER BY id DESC LIMIT 0,10;
