<?php
// Tinker with this sql here: https://www.db-fiddle.com/f/hCV8Z547Xf3baMihHmgbHf/4

/******** CONSTANTS ********/

const CREATE_POSTS_TABLE_SQL =<<<EOF
CREATE TABLE IF NOT EXISTS posts(
  id varchar(64) PRIMARY KEY NOT NULL,
  user_id varchar(64) NOT NULL REFERENCES users,
  user_handle varchar(64) NOT NULL,
  body varchar(64) NOT NULL,
  display_name varchar(128) NOT NULL,
  created_date text NOT NULL,
  has_image bool DEFAULT FALSE,
  image_url text DEFAULT NULL,
  comment_count int DEFAULT 0,
  like_count int DEFAULT 0,
  last_modified text
);

INSERT INTO posts("id", "user_id", "user_handle", "body", "display_name", "created_date", "has_image")
VALUES("4c275ca3-70a9-441f-85c3-8abae5ec37e1", "cebca450-45ec-4f2e-9202-2e6a132ba2fe", "@tstark", "Kickin' it old school...", "Tony Stark", "2023-03-10T22:42:23.150Z", FALSE);

INSERT INTO posts("id", "user_id", "user_handle", "body", "display_name", "created_date", "has_image")
VALUES("02ee1207-576b-4a64-b996-470e4df949b4", "cebca450-45ec-4f2e-9202-2e6a132ba2fe", "@tstark", "Are you out there, God? It's me, Margaret...", "Tony Stark", "2023-03-10T22:42:23.150Z", FALSE);
EOF;

const CREATE_USERS_TABLE_SQL = <<<EOF
CREATE TABLE IF NOT EXISTS users(
id varchar(64) PRIMARY KEY NOT NULL,
email text NOT NULL,
handle varchar(64) NOT NULL,
display_name varchar(128) NOT NULL,
created_date text NOT NULL,
follower_count int DEFAULT 0,
motto text,
last_modified text
);

INSERT INTO users("id", "email", "handle", "display_name", "motto", "created_date")
VALUES("cebca450-45ec-4f2e-9202-2e6a132ba2fe", "tstark@avengers.org", "@tstark", "Tony Stark", "Playboy. Billionaire. Genius", "2023-03-10T22:42:23.150Z");

INSERT INTO users("id", "email", "handle", "display_name", "motto", "created_date")
VALUES("bd66c120-5893-4d23-b28d-086d2ab1a838", "thor@asgard.gov", "@thor", "Thor Odinson", "You're probably not worthy...", "2023-03-10T22:42:23.150Z");
EOF;

const CREATE_COMMENTS_TABLE_SQL = <<<EOF
CREATE TABLE IF NOT EXISTS comments(
  id varchar(64) PRIMARY KEY NOT NULL,
  post_id varchar(64) NOT NULL REFERENCES posts,
  user_id varchar(64) NOT NULL REFERENCES users,
  body text NOT NULL,
  created_date text NOT NULL,
  like_count int,
  last_modified text 
);
EOF;

const CREATE_LIKED_POSTS_TABLE_SQL = <<<EOF
CREATE TABLE IF NOT EXISTS liked_posts(
  id varchar(64) PRIMARY KEY NOT NULL,
  user_id varchar(64) NOT NULL REFERENCES users,
  post_id varchar(64) NOT NULL references posts,
  created_date text NOT NULL
);
EOF;



/******** MAIN ********/

$sql_config = new SQL_Configuration();
$sql_config->add_SQL(CREATE_POSTS_TABLE_SQL);
$sql_config->add_SQL(CREATE_USERS_TABLE_SQL);
$sql_config->add_SQL(CREATE_COMMENTS_TABLE_SQL);
$sql_config->add_SQL(CREATE_LIKED_POSTS_TABLE_SQL);


/**
 * Used to house SQL statements for seeding the database
 */
class SQL_Configuration {
  private $sql = array();

  /**
   * Adds SQL statements the configuration
   */
  function add_SQL($sql_string) {
    $this->sql[] = $sql_string;
  }

  /**
   * Extracts the SQL statements from the configuration
   * @return Array
   */
  function get_SQL() {
    return $this->sql;
  }
}

?>