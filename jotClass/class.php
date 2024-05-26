<?php
class Person
{
  public $name;
  public $age;

  public function breathe()
  {
    echo $this->name . ' is breathing!';
  }
}

$person = new Person();

$person->name = 'John Doe';
$person->age = 25;


$person->breathe();
