CREATE TABLE categories (
  id        INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  title     VARCHAR(255) NOT NULL,
  url       VARCHAR(255) NOT NULL,
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
  thumbnail   VARCHAR(255),
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
);

INSERT INTO products (id_category, title, short_tag, price, short_desc, `desc`, thumbnail, dt_create, dt_modified)
VALUES (2, 'San pham 1', 'san-pham-1', 10000, 'Mô tả thông tin ngắn về sản phẩm 1', 'Thông tin chi tiết về sản phẩm 1',
        'https://placehold.it/150x80?text=IMAGE', '2018-01-01 10:00:00', '2018-01-01 10:00:00');
INSERT INTO products (id_category, title, short_tag, price, short_desc, `desc`, thumbnail, dt_create, dt_modified)
VALUES (2, 'San pham 2', 'san-pham-2', 10000, 'Mô tả thông tin ngắn về sản phẩm 2', 'Thông tin chi tiết về sản phẩm 2',
        'https://placehold.it/150x80?text=IMAGE', '2018-01-01 10:02:00', '2018-01-01 10:02:00');
INSERT INTO products (id_category, title, short_tag, price, short_desc, `desc`, thumbnail, dt_create, dt_modified)
VALUES (2, 'San pham 3', 'san-pham-3', 10000, 'Mô tả thông tin ngắn về sản phẩm 3', 'Thông tin chi tiết về sản phẩm 3',
        'https://placehold.it/150x80?text=IMAGE', '2018-01-01 10:05:00', '2018-01-01 10:05:00');
INSERT INTO products (id_category, title, short_tag, price, short_desc, `desc`, thumbnail, dt_create, dt_modified)
VALUES (2, 'San pham 4', 'san-pham-4', 10000, 'Mô tả thông tin ngắn về sản phẩm 4', 'Thông tin chi tiết về sản phẩm 4',
        'https://placehold.it/150x80?text=IMAGE', '2018-01-01 10:10:00', '2018-01-01 10:10:00');
INSERT INTO products (id_category, title, short_tag, price, short_desc, `desc`, thumbnail, dt_create, dt_modified)
VALUES (2, 'San pham 5', 'san-pham-5', 10000, 'Mô tả thông tin ngắn về sản phẩm 5', 'Thông tin chi tiết về sản phẩm 5',
        'https://placehold.it/150x80?text=IMAGE', '2018-01-01 10:15:00', '2018-01-01 10:15:00');
INSERT INTO products (id_category, title, short_tag, price, short_desc, `desc`, thumbnail, dt_create, dt_modified)
VALUES (2, 'San pham 6', 'san-pham-6', 10000, 'Mô tả thông tin ngắn về sản phẩm 6', 'Thông tin chi tiết về sản phẩm 6',
        'https://placehold.it/150x80?text=IMAGE', '2018-01-01 10:20:00', '2018-01-01 10:20:00');
INSERT INTO products (id_category, title, short_tag, price, short_desc, `desc`, thumbnail, dt_create, dt_modified)
VALUES (2, 'San pham 7', 'san-pham-7', 10000, 'Mô tả thông tin ngắn về sản phẩm 7', 'Thông tin chi tiết về sản phẩm 7',
        'https://placehold.it/150x80?text=IMAGE', '2018-01-01 10:25:00', '2018-01-01 10:25:00');
INSERT INTO products (id_category, title, short_tag, price, short_desc, `desc`, thumbnail, dt_create, dt_modified)
VALUES (2, 'San pham 8', 'san-pham-8', 10000, 'Mô tả thông tin ngắn về sản phẩm 8', 'Thông tin chi tiết về sản phẩm 8',
        'https://placehold.it/150x80?text=IMAGE', '2018-01-01 10:30:00', '2018-01-01 10:30:00');
INSERT INTO products (id_category, title, short_tag, price, short_desc, `desc`, thumbnail, dt_create, dt_modified)
VALUES (2, 'San pham 9', 'san-pham-9', 10000, 'Mô tả thông tin ngắn về sản phẩm 9', 'Thông tin chi tiết về sản phẩm 9',
        'https://placehold.it/150x80?text=IMAGE', '2018-01-01 10:35:00', '2018-01-01 10:35:00');