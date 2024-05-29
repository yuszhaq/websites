<?php

const BASE_PATH = __DIR__ . '/../';

require BASE_PATH . 'function.php';

spl_autoload_register(function ($class) {
  require base_path("Core/{$class}.php");
});

require base_path('router.php');
