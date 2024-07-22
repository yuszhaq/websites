<?php

use core\App;
use Core\Database;
use core\Validator;

$db = App::resolve(Database::class);

$email = $_POST['email'];
$password = $_POST['password'];

$errors = [];

if (!Validator::email($email)) {
  $errors['email'] = 'Please provide a valid email address';
}

if (!Validator::string($password)) {
  $errors['password'] = 'Please provide a vaild password.';
}

if (!empty($errors)) {
  return view('session/create.view.php', [
    'errors' => $errors
  ]);
}

$user = $db->query('SELECT * FROM users WHERE email = :email', [
  'email' => $email
])->find();

if ($user) {
  if (password_verify($password, $user['password'])) {
    login([
      'email' => $email
    ]);

    header('location: /');
    die();
  }
}
return view('session/create.view.php', [
  'errors' => [
    'email' => 'No matching account found for that email address and password'
  ]
]);
