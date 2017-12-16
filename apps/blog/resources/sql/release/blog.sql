CREATE TABLE articles (
  id          VARCHAR(25) PRIMARY KEY,
  title       VARCHAR(255)     NOT NULL,
  content     TEXT             NOT NULL,
  id_author   INT(10) UNSIGNED NOT NULL,
  dt_created  DATETIME         NOT NULL,
  dt_modified DATETIME         NOT NULL,
  short_url   VARCHAR(255)     NOT NULL
);

CREATE TABLE authors (
  id       VARCHAR(25) PRIMARY KEY,
  name     VARCHAR(80)  NOT NULL,
  email    VARCHAR(255) NOT NULL,
  password VARCHAR(60)  NOT NULL,
  avatar   VARCHAR(255) NOT NULL,
  profile  TEXT
);

CREATE TABLE comments (
  id        VARCHAR(25) PRIMARY KEY,
  id_author VARCHAR(25) NOT NULL,
  content   TEXT
);

CREATE TABLE label (
  cd_tag VARCHAR(255) PRIMARY KEY,
  title  VARCHAR(255) NOT NULL
);

CREATE TABLE article_label (
  id_article VARCHAR(25) NOT NULL,
  cd_tag     VARCHAR(25) NOT NULL,
  PRIMARY KEY (id_article, cd_tag)
);

ALTER TABLE articles ADD COLUMN status TINYINT NOT NULL DEFAULT 0;