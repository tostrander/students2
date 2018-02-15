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

//Define a default route
$f3->route('GET|POST /add', function($f3, $params) {

    /*
    [sid] => 3333
    [last] => Iqbal
    [first] => Shahbaz
    [birthdate] => 2000-05-05
    [gpa] => 4.0
    [advisor] => 2
    [submit] => Submit
    */

    if (isset($_POST['submit'])) {

        //get the form data
        $sid = $_POST['sid'];
        $last = $_POST['last'];
        $first = $_POST['first'];
        $birthdate = $_POST['birthdate'];
        $gpa = $_POST['gpa'];
        $advisor = $_POST['advisor'];

        //validate data

        //insert the student into the db
        $result = insertStudent($sid, $last, $first, $birthdate, $gpa, $advisor);

        //redirect to home page
        $f3->reroute('/');
    }


    //load a template
    $template = new Template();
    echo $template->render('views/add-student.html');

});

//Run fat free
$f3->run();
