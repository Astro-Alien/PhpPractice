<?php

    //-------------------------------------------------------------------------------------------------------database code
   
    
    //------------------------------------------------------------------------------------create connection to the database
    $databaseHost = "localhost";
    $databaseName = "person_db";
    $username = "root";
    $password = "";

    $connection = mysqli_connect($databaseHost, $username, $password, $databaseName);

    if(mysqli_connect_errno()){
        echo('<input action="action" type="button" value="Back" onclick="window.history.go(-1); return false;" />');
        die("The connection to the database has failed due to: ". mysqli_connect_error());
    }

    //-----------------------------------------------------------------------------------create database table 
    $sqlStatement = "create table IF NOT EXISTS csv_import(
        Id integer NOT NULL,
        Name varchar(50) NOT NULL,
        Surname varchar(50) NOT NULL,
        Initial varchar(1) NOT NULL,
        Age int NOT NULL,
        DateOfBirth varchar(50) NOT NULL,
        PRIMARY KEY (Id)
    )";
    if (mysqli_query($connection, $sqlStatement)) {
        echo('<input action="action" type="button" value="Back" onclick="window.history.go(-1); return false;" />');
        $CompletedString ="<script type='text/javascript'>alert('Table csv_import was created successfully');</script>";
        echo($CompletedString);
    

    } else {
        echo('<input action="action" type="button" value="Back" onclick="window.history.go(-1); return false;" />');
        $failedString ="<script type='text/javascript'>alert('Error creating table csv_import: ');</script>";
        echo($failedString);
    }

    //-----------------------------------------------------------------------------------Save csv data to the database
    if(isset($_POST["submit"])){
        if($_FILES['file']['name'])
        {
            $file_name = explode(".", $_FILES['file']['name']);
            if($file_name[1] == 'csv'){
                $handler = fopen($_FILES['file']['tmp_name'], "r");
                while($data = fgetcsv($handler))
                {
                    $item1 = mysqli_real_escape_string($connection, $data[0]);  
                    $item2 = mysqli_real_escape_string($connection, $data[1]);
                    $item3 = mysqli_real_escape_string($connection,$data[2]);
                    $item4 = mysqli_real_escape_string($connection,$data[3]);
                    $item5 = mysqli_real_escape_string($connection,$data[4]);
                    $item6 = mysqli_real_escape_string($connection,$data[5]);
                    $query = "INSERT into csv_import(Id,Name,Surname,Initial,Age,DateOfBirth) values('$item1','$item2','$item3','$item4','$item5','$item6')";
                    mysqli_query($connection, $query);
                }
                
                fclose($handler);
                echo "<script>alert('Import done');</script>";
            }
        }
    }
    
    mysqli_close($connection);
?>