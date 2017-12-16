CREATE TABLE users (
  id       VARCHAR(25) PRIMARY KEY,
  username VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE schools (
  id   VARCHAR(25) PRIMARY KEY,
  name VARCHAR(255) NOT NULL
);

CREATE TABLE user_schools (
  id_user   VARCHAR(25) NOT NULL,
  id_school VARCHAR(25) NOT NULL,
  PRIMARY KEY (id_user, id_school)
);

CREATE TABLE report_templates (
  id            VARCHAR(25) PRIMARY KEY,
  name          VARCHAR(255) NOT NULL,
  dt_create     DATETIME     NOT NULL,
  dt_lst_update DATETIME     NOT NULL
);

CREATE TABLE report_columns (
  id_template  VARCHAR(25)  NOT NULL,
  column_key   VARCHAR(255) NOT NULL,
  name         VARCHAR(255) NOT NULL,
  flag_empty   BOOLEAN               DEFAULT FALSE,
  flag_numeric BOOLEAN               DEFAULT TRUE,
  row_span     TINYINT      NOT NULL DEFAULT 1,
  col_span     TINYINT      NOT NULL DEFAULT 1,
  cd_order     TINYINT      NOT NULL,
  PRIMARY KEY (id_template, column_key)
);

CREATE TABLE report_default_rows (
  id_template VARCHAR(25)  NOT NULL,
  cd_row      INT          NOT NULL,
  column_key  VARCHAR(255) NOT NULL,
  value       VARCHAR(255),
  PRIMARY KEY (id_template, cd_row, column_key)
);

CREATE TABLE reports (
  id            VARCHAR(25) PRIMARY KEY,
  id_template   VARCHAR(25)  NOT NULL,
  name          VARCHAR(255) NOT NULL,
  id_year       VARCHAR(25)  NOT NULL,
  id_school     VARCHAR(25)  NOT NULL,
  dt_create     DATETIME     NOT NULL,
  dt_expire     DATETIME     NOT NULL,
  dt_report     DATETIME DEFAULT NULL,
  dt_lst_update DATETIME DEFAULT NULL
);

CREATE TABLE years (
  id         VARCHAR(25) PRIMARY KEY,
  year_value VARCHAR(10) NOT NULL
);

CREATE TABLE report_values (
  id_report  VARCHAR(25)  NOT NULL,
  cd_row     INT          NOT NULL,
  column_key VARCHAR(255) NOT NULL,
  value      VARCHAR(255),
  PRIMARY KEY (id_report, cd_row, column_key)
);