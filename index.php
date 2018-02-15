<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);

//Required files
require_once 'vendor/autoload.php';
require_once '/home/tostrand/config.php';
require_once 'model/db-functions.php';

//Create an instance of the Base class
$f3 = Base::instance();
$f3->set('DEBUG', 3);

//Connect to database
$dbh = connect();

//Define a default route
$f3->route('GET /', function($f3, $params) {

    $students = getStudents();
    $f3->set("students", $students);

    //load a template
    $template = new Template();
    echo $template->render('views/all-students.html');

});

//Run fat free
$f3->run();
