<?php

$pdo = new PDO('mysql:host=localhost; dbname=db_starwars', 'taric', 'taric');

$pdo->exec("
        INSERT INTO tags (name) VALUES ('chewbacca'), ('Sabre Laser'), ('LucasArts');

        INSERT INTO categories (title, description) VALUES ('accessories', 'accessories for men, women, children'), ('games', 'starwars games'), ('decorations', 'home decorations from star wars world');

        INSERT INTO products (title, abstract, price) VALUES ('light saber', 'sabre laser de collection, acier', 199.99), ('cuddly toy', 'little chewbacca', 15.99), ('RISK StarWars', 'RISK jeu de plateau', 40.00);

        INSERT INTO product_tag (product_id, tag_id) VALUES (2, 1), (1, 2), (2, 3);

        INSERT INTO images (product_id, uri) VALUES (1, 'sabre.jpg'), (2, 'peluche-chewbacca.jpg');
    ");