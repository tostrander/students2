<?php

function connect()
{
    try {
        //Instantiate a database object
        $dbh = new PDO(DB_DSN, DB_USERNAME,
            DB_PASSWORD );
        //echo "Connected to database!!!";
        return $dbh;
    }
    catch (PDOException $e) {
        echo $e->getMessage();
        return;
    }
}

function getStudents()
{
    global $dbh;

    //1. Define the query
    $sql = "SELECT * FROM student ORDER BY last, first";

    //2. Prepare the statement
    $statement = $dbh->prepare($sql);

    //3. Bind parameters

    //4. Execute the query
    $statement->execute();

    //5. Get the results
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    //print_r($result);
    return $result;

}