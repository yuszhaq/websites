<?php

use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

$currentUserId = 1;

//find the corresponding note
$note = $db->query('SELECT * FROM notes WHERE id = :id', [
  'id' => $_POST['id']
])->findOrFail();

//authorize the the current user can edit the note
authorize($note['user_id'] === $currentUserId);

//vallidate the form

$errors = [];

if (!Validator::string($_POST['body'], 1, 1000)) {
  $errors['body'] = 'A body of no more than 1,000 characters is required.';
}

//if no validation errors, update the record in the notes database table.
if (count($errors)) {
  return view("notes/edit.view.php", [
    'heading' => 'Edit Note',
    'errors' => $errors,
    'note'  => $note
  ]);
}

$db->query('UPDATE notes SET body = :body WHERE id = :id', [
  'id' => $_POST['id'],
  'body' => $_POST['body']
]);

//redirect the huser
header('location: /notes');
die();
