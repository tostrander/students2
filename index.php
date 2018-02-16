<?php

//Required files
require_once 'vendor/autoload.php';
require_once '/home/tostrand/config.php';
require_once 'model/db-functions.php';

//Create an instance of the Base class
$f3 = Base::instance();

require_once '/home/tostrand/public_html/debug.php';

session_start();

//Connect to database
$dbh = connect();

//Define a default route
$f3->route('GET /', function($f3, $params) {

    print_r($_SESSION);

    $students = getStudents();
    $f3->set("students", $students);

    //load a template
    $template = new Template();
    echo $template->render('views/all-students.html');

});

//Define an add route
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

        //instantiate a student object
        $student = new Student($sid, $last, $first, $birthdate, $gpa, $advisor);

        //add student object to session array
        $_SESSION['student'] = $student;

        //redirect to summary page
        $f3->reroute('/summary');
    }

    //load a template
    $template = new Template();
    echo $template->render('views/add-student.html');

});

//Define a summary route
$f3->route('GET /summary', function() {

    //load a template
    $template = new Template();
    echo $template->render('views/view-student.html');

});

//Run fat free
$f3->run();
