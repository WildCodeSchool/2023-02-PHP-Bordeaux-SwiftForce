<?php

//Model (for connexion data, see unversionned db.php)
define('DB_USER', getenv('DB_USER') ? getenv('DB_USER') : APP_DB_USER);
define('DB_PASSWORD', getenv('DB_PASSWORD') ? getenv('DB_PASSWORD') : APP_DB_PASSWORD);
define('DB_HOST', getenv('DB_HOST') ? getenv('DB_HOST') : APP_DB_HOST);
define('DB_NAME', getenv('DB_NAME') ? getenv('DB_NAME') : APP_DB_NAME);

//View
define('APP_VIEW_PATH', __DIR__ . '/../src/View/');

// database dump file path for automatic import
define('DB_DUMP_PATH', __DIR__ . '/../database.sql');


// clé secrète API stripe
$clientSecret = 'sk_test_51IcYHgFO2dD49mLEk6Hev967fXvMhUYuckmY8ZYZ6E934g8rNZLkPzzXOhAQ1uNcjbTI90EL4VJa8N6101Aykgn500Hs0cOXEm';
