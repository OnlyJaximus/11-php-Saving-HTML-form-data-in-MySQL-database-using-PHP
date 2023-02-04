<?php

echo "<pre>";
// print_r($_POST);

// Array
// (
//     [name] => Branko 
//     [priority] => 3
//     [type] => 2
//     [terms] => on
// )


// All values in the post array will be strings, as that's how the data is sent in the request  
// To get these as numbers we can use the filter input functionm again

$name =  $_POST['name'];
$message = $_POST['message'];

// $priority = $_POST['priority'];  // "3"  Ovako je string (linija 32)
$priority = filter_input(INPUT_POST, "priority", FILTER_VALIDATE_INT);  // int(2)

// $type = $_POST['type'];  //  "1" Ovako je string (linija 33)
$type = filter_input(INPUT_POST, "type", FILTER_VALIDATE_INT); // int(1)

// $terms = $_POST['terms'];
$terms =  filter_input(INPUT_POST, "terms", FILTER_VALIDATE_BOOL);

// Ne dobija se vise warning i ako nije otkaceno, dobila se vrednost NULL 
// Ako je otkaceno, dobijamo TRUE

// echo "<pre>";
// var_dump($name, $message, $priority, $type, $terms);
// string(7) "Branko "
// string(7) "Zdravo!"
// string(1) "3"
// string(1) "1"
// string(2) "on"  // bool(true)  // NULL


// string(7) "Branko "
// string(7) "Zdravo!"
// int(2)
// int(1)
// bool(true)  // Ako nije otkaceno NULL

if (!$terms) {
    die("Terms must be accepted");
}

// echo "<pre>";
// var_dump($name, $message, $priority, $type, $terms);

$host = "localhost";
$dbName = "comp_login";
$username = "root";
$password = "";

$conn = mysqli_connect(
    hostname: $host,
    username: $username,
    password: $password,
    database: $dbName
);

if (mysqli_connect_errno()) {
    die("Connection error! " . mysqli_connect_error());
}

$sql = "INSERT INTO message(name, body, priority, type) 
        VALUES (?,?,?,?)";

$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
    die(mysqli_errno($conn));
}

mysqli_stmt_bind_param($stmt, "ssii", $name, $message, $priority, $type);

mysqli_stmt_execute($stmt);
echo "Record saved.";
