<?php

use Core\App;
use Core\Database;
use Core\Validator;

$email = $_POST['email'];
$password = $_POST['password'];

//validate the form input.
$errors = [];
if (!Validator::email($email)) {
  $errors['email'] = 'Please provide a valid email address';
}

if (!Validator::string($password, 7, 255)) {
  $errors['password'] = 'Please provide a password of atleast seven characters';
}

if (!empty($errors)) {
  return view('registration/create.view.php', [
    'errors' => $errors
  ]);
}

$db = App::resolve(Database::class);

//check if the account already exist
$user = $db->query('SELECT * FROM users WHERE email = :email', [
  'email' => $email
])->find();

if ($user) {
  //then someone with email already exist and has a account.
  //if yes, redirect to login page.
  header('location: /');
  exit();
} else {
  //if not login, save one, and then log the user in, and redirect.
  $db->query('INSERT INTO users(email, password) VALUES(:email, :password)', [
    'email' => $email,
    'password' => password_hash($password, PASSWORD_DEFAULT) // NEVER store database passwords in clear text.
  ]);

  //mark that the user has logged in.
  $_SESSION['user'] = [
    'email' => $email
  ];
  header('location: /');
  die();
}
