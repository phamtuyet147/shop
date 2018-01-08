CREATE TABLE categories (
  id        INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  title     VARCHAR(255) NOT NULL,
  short_tag VARCHAR(255) NOT NULL,
  id_parent INT UNSIGNED,
  INDEX (short_tag, id_parent)
);

CREATE TABLE products (
  id          INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  id_category INT UNSIGNED NOT NULL,
  title       VARCHAR(255) NOT NULL,
  short_tag   VARCHAR(255) NOT NULL,
  price       INT UNSIGNED NOT NULL,
  short_desc  TEXT,
  `desc`      TEXT,
  thumnnail   VARCHAR(255),
  dt_create   DATETIME     NOT NULL,
  dt_modified DATETIME     NOT NULL,
  INDEX (short_tag, dt_create)
);

CREATE TABLE orders (
  id            INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  id_cus        INT UNSIGNED NOT NULL,
  id_receiver   INT UNSIGNED NOT NULL,
  state         TINYINT                  DEFAULT 0,
  total_pricing INT UNSIGNED NOT NULL,
  dt_create     DATETIME     NOT NULL
);

CREATE TABLE order_detail (
  id_order   INT UNSIGNED NOT NULL,
  id_product INT UNSIGNED NOT NULL,
  amount     INT UNSIGNED DEFAULT 1,
  note       TEXT,
  PRIMARY KEY (id_order, id_product)
);

CREATE TABLE customers (
  id      INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name    VARCHAR(255) NOT NULL,
  gender  ENUM ('male', 'female'),
  address VARCHAR(255) NOT NULL
);

CREATE TABLE cus_login (
  id_cus   INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  phone    VARCHAR(15) NOT NULL UNIQUE,
  email    VARCHAR(80) NOT NULL UNIQUE,
  password VARCHAR(80) NOT NULL,
  INDEX (phone, email)
);

CREATE TABLE managers (
  id       INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(80) NOT NULL,
  password VARCHAR(80) NOT NULL
)