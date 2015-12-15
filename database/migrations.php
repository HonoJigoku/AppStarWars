<?php

$pdo = new PDO('mysql:host=localhost;dbname=db_starwars', 'taric', 'taric');

$pdo->exec("
    CREATE TABLE IF NOT EXISTS users(
      id INT UNSIGNED NOT NULL AUTO_INCREMENT,
      username VARCHAR(20),
      password VARCHAR(100),
      PRIMARY KEY(id)
    )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
");


$pdo->exec("
  CREATE TABLE IF NOT EXISTS categories (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    title VARCHAR(100),
    description TEXT,
    PRIMARY KEY (id)
  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
  ");

$pdo->exec("
  CREATE TABLE IF NOT EXISTS products (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    category_id INT UNSIGNED,
    title VARCHAR(100),
    abstract TEXT,
    content TEXT,
    price DECIMAL(5,2),
    published_at DATETIME,
    `status` ENUM('published','unpublished') NOT NULL DEFAULT 'unpublished',
    PRIMARY KEY (id),
    CONSTRAINT products_category_id_categories_foreign FOREIGN KEY(category_id) REFERENCES categories(id) ON DELETE SET NULL
  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
  ");

$pdo->exec("
  CREATE TABLE IF NOT EXISTS tags (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(20),
    PRIMARY KEY (id)
  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
  ");

$pdo->exec("
  CREATE TABLE IF NOT EXISTS product_tag (
    product_id INT UNSIGNED,
    tag_id INT UNSIGNED,
    CONSTRAINT product_tag_product_id_products_foreign FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE,
    CONSTRAINT product_tag_tag_id_tags_foreign FOREIGN KEY(tag_id) REFERENCES tags(id) ON DELETE CASCADE
  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
  ");



$pdo->exec("
  CREATE TABLE IF NOT EXISTS images (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    product_id INT UNSIGNED,
    uri VARCHAR(200),
    `size` INT NOT NULL,
     PRIMARY KEY(id),
    CONSTRAINT images_product_id_product_foreign FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE
  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
  ");

$pdo->exec("
  CREATE TABLE IF NOT EXISTS histories (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    product_id INT UNSIGNED,
    price DECIMAL (5,2),
    total DECIMAL(5,2),
    commanded_at DATETIME,
    quantity INT UNSIGNED,
    status ENUM('done' , 'todo') NOT NULL DEFAULT 'todo',
    PRIMARY KEY(id),
    CONSTRAINT histories_product_id_product_foreign FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE
  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
  ");

$pdo->exec("
  CREATE TABLE IF NOT EXISTS customers (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    email VARCHAR(100),
    address TEXT,
    `number` VARCHAR(100),
    number_command INT UNSIGNED,
    PRIMARY KEY(id)
  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
  ");