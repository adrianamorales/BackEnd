<?php
  include("config.inc.php");
  $dbname = $config['db'];
  $user = $config['user'];
  $pass = $config['pass'];
  $conn = new PDO('mysql:host=localhost;dbname='.$dbname, $user, $pass);
  //create user table
  $sql = "CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(64) NOT NULL,
    salt VARCHAR(3) NOT NULL,
    PRIMARY KEY(id)
  );";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $sql = "CREATE TABLE info (
    first VARCHAR(30),
    last VARCHAR(30),
    email VARCHAR(50) NOT NULL UNIQUE,
    phone VARCHAR(12),
    lastSignOn DATETIME NOT NULL DEFAULT 0,
    Primary Key (email),
    Foreign Key (email) references users(email)
  );";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $sql = "CREATE TABLE cal (
    cid INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(80),
    iframe VARCHAR(1024),
    Primary Key (cid)
  );";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $sql = "CREATE TABLE form (
    fid INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(256),
    form VARCHAR(1024),
    excel VARCHAR(1024),
    Primary Key (fid)
  );";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $sql = "CREATE TABLE task (
    tid INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100),
    details VARCHAR(1024),
    priority INT NOT NULL DEFAULT 1,
    Primary Key (tid)
  );";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $sql = "insert into `task` (`tid`, `name`, `details`, `priority`) VALUES(1, 'starting', 'I should probably start this', 1);";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $sql = "insert into `task` (`tid`, `name`, `details`, `priority`) VALUES(2, 'starting', 'I should really probably start this', 2);";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $sql = "insert into `task` (`tid`, `name`, `details`, `priority`) VALUES(3, 'starting', 'I should probably start this', 3);";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  
  
  

?>