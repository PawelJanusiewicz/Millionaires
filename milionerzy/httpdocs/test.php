<?php

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

$config = new Configuration();

    $connectionParams = array(
        'dbname' => 'database',
        'user' => 'user',
        'password' => 'password',
        'host' => 'localhost',
        'port' => 3306,
        'charset' => 'utf8',
        'driver' => 'pdo_mysql',
    );
    $dbh = DriverManager::getConnection($connectionParams, $config);


    // Pobieranie pojedynczego rekordu
    $sth = $dbh->query('SELECT * FROM users WHERE id = 1');
    $user = $sth->fetch();

    // Pobieranie wszystkich rekordów
    $sth = $dbh->query('SELECT * FROM users');
    $users = $sth->fetchAll();

    // Pobieranie pojedynczej wartości dla jednej kolumny jako skalar
    $sth = $dbh->query('SELECT email FROM users WHERE id = 1');
    $email = $sth->fetchColumn();

    // Pobieranie wartości jednej kolumny dla wszystkich rekordów jako tablica wartości skalarnych
    $sth = $dbh->query('SELECT email FROM users');
    $emails = $sth->fetchAll(PDO::FETCH_COLUMN);

    // Pobieranie danych jako tablica asocjacyjna
    $sth = $dbh->query('SELECT id, email FROM users');
    $users = $sth->fetchAll(PDO::FETCH_ASSOC);






    $id = 100;
    $sth = $dbh->prepare('SELECT * FROM users WHERE id = ?');
    $sth->bindValue(1, $id, PDO::PARAM_INT);
    $sth->execute();
    $user = $sth->fetch();


    $id = 123;
    $name = 'John';

    $sth = $dbh->prepare('SELECT * FROM users WHERE name = :somename OR username = :somename AND id > :id');
    $sth->bindValue('somename', $name, PDO::PARAM_STR);
    $sth->bindValue('id', $id, PDO::PARAM_INT);
    $sth->execute();
    $users = $sth->fetchAll();




    $sth = $dbh->executeQuery('SELECT * FROM user WHERE username = ?', array('John'));
    $user = $sth->fetch();

    $users = $dbh->fetchAll('SELECT * FROM user');

    $user = $dbh->fetchArray('SELECT * FROM user WHERE username = ?', array('John'));

    $username = $dbh->fetchColumn('SELECT username FROM user WHERE id = ?', array(1), 0);

    $user = $dbh->fetchAssoc('SELECT * FROM user WHERE username = ?', array('John'));



    $insertedRowNb = $dbh->insert('user', array('username' => 'John'));
    // INSERT INTO user (username) VALUES (?) (John)
    $insertedRowNb = $dbh->executeUpdate('INSERT INTO user (username) VALUES (?)', array('John'));
    $ID = $dbh->lastInsertId();




    $updatedRowNb = $dbh->update('user', array('username' => 'John'), array('id' => 1));
    // UPDATE user (username) VALUES (?) WHERE id = ? (John, 1)
    $updatedRowNb = $dbh->executeUpdate('UPDATE user SET username = ? WHERE id = ?', array('John', 1));




    $deletedRowNb = $dbh->delete('user', array('id' => 1));
    // DELETE FROM user WHERE id = ? (1)
    $deletedRowNb = $dbh->executeUpdate('DELETE FROM user WHERE id = ?', array(1));


    /*
    SELECT u.id, u.name, u.email, p.bio
    FROM users u
    INNER JOIN user_profile p ON (u.id = p.user_id)
    WHERE u.id = 1
    ORDER BY u.name ASC
    */
    $id = 1;
    $query = $dbh->createQueryBuilder();
    $query->select('u.id', 'u.name', 'u.email', 'p.bio')
        ->from('users', 'u')
        ->innerJoin('u', 'user_profile', 'p', 'u.id = p.user_id')
        ->orderBy('u.name', 'ASC')
        ->where('u.id = :id')
        ->setParameter(':id', $id)
    ;
    $sth = $query->execute();
    $user = $sth->fetch(PDO::FETCH_ASSOC);



    /*
      INSERT INTO users (name, password) VALUES (?, ?)
     */
    $username = 'John';
    $password = 's3cr3tP4ssw0rd';
    $query = $dbh->createQueryBuilder();
    $query
        ->insert('users')
        ->setValue('name', '?')
        ->setValue('password', '?')
        ->setParameter(0, $username)
        ->setParameter(1, $password)
    ;
    $sth = $query->execute();


