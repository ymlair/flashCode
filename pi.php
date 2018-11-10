<?php
// If you installed via composer, just use this code to requrie autoloader on the top of your projects.
require './vendor/autoload.php';

// Using Medoo namespace
use Medoo\Medoo;

$dbConfig = require('./db.php');
// Initialize
$database = new Medoo($dbConfig);

// Enjoy
$data['randstr'] = rand();
#$data['content'] = base64_encode($_POST['content']);
$data['content'] = htmlentities($_POST['content'], ENT_QUOTES,'UTF-8');
$data['expire'] = time()+86400;
$database->insert('pi_content', $data);

#header("Location: getpi.php/{$data['randstr']}");
header("Location: get.php/{$data['randstr']}");
