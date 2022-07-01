<!--PHP Code-->
<?php
        error_reporting (E_ALL ^ E_NOTICE); 
        //-----------------------------------------------------------------------------------create database connection here and then store the inputs from the above html to the database
        $id = $_POST["IDNo"];
        $name = $_POST["FirstName"];
        $surname = $_POST["Surname"];
        $dob = $_POST["DOB"];

         
        isEmpty($id, "ID Number field");
        isEmpty($name, "Name field");
        isEmpty($surname, "Surname field");
        isEmpty($dob, "Date of Birth field");
        lengthOfID($id);
        stringValidation($name, "Name");
        stringValidation($surname, "Surname");


        //-----------------------------------------------------------------------------------validation for empty fields
        function isEmpty($variable, $nameOfVariable){
            if(empty($variable)){
                
                $emptyString ="<script type='text/javascript'>alert('The field {$nameOfVariable} cannot be empty');</script>";
                die($emptyString);
                    
            }
        }


        //-----------------------------------------------------------------------------------check id length and check if its number
        function lengthOfID($idLen){

            if(strlen($idLen) < 13  || strlen($idLen) > 13 || !is_numeric($idLen)){
                
                
                $invalidIDAlert ="<script type='text/javascript'>alert('Invalid ID Number Please Enter A Valid ID Number:  13 digits');</script>";
                echo('<input action="action" type="button" value="Back" onclick="window.history.go(-1); return false;" />');
                die($invalidIDAlert);
                
            }
            
        }

        //-----------------------------------------------------------------------------------Name and Surname validation

        function stringValidation($stringVar, $stmt){

            if(is_numeric($stringVar)){
                echo('<input action="action" type="button" value="Back" onclick="window.history.go(-1); return false;" />');
                $invalidString ="<script type='text/javascript'>alert('The field {$stmt} must contain a string and cannot contain a numeric value.');</script>";
                die($invalidString);
                
            }
            if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $stringVar))
                {
                    echo('<input action="action" type="button" value="Back" onclick="window.history.go(-1); return false;" />');
                    $invalidString ="<script type='text/javascript'>alert('The field {$stmt} must contain a string and cannot contain a character/symbol value.');</script>";
                    die($invalidString);
                }
                
        }

        
        //-----------------------------------------------------------------------------------database variables and connection/saving code
    
        $databaseHost = "localhost";
        $databaseName = "person_db";
        $username = "root";
        $password = "";

        $connection = mysqli_connect($databaseHost, $username, $password, $databaseName);

        if(mysqli_connect_errno()){
            
            die("The connection to the database has failed due to: ". mysqli_connect_error());
        }

        $sqlStatement = "INSERT INTO register (id, name, surname, dob) VALUES(?,?,?,?)";

        $statement = mysqli_stmt_init($connection);

        $check = mysqli_stmt_prepare($statement,$sqlStatement);

        if(!$check){

            die("An error has occured due to: ". mysqli_error($connection));
        }

        mysqli_stmt_bind_param($statement,"isss", $id, $name, $surname,$dob);

        
        //-----------------------------------------------------------------------------------check if id already exist in the database before executing save
        $existQuery =  mysqli_query($connection,"SELECT * FROM `register` WHERE id = '$id'");
        if(mysqli_num_rows($existQuery) > 0){
            echo('<input action="action" type="button" value="Back" onclick="window.history.go(-1); return false;" />');
            $alert ="<script>alert('A record with the ID: {$id} already exist in the database.');</script>";
            echo($alert);

        }
        else{
            echo('<input action="action" type="button" value="Back" onclick="window.history.go(-1); return false;" />');
            mysqli_execute($statement);
            $savedAlert ="<script>alert('The record has been saved successfully.');</script>";
            echo($savedAlert);
        }
         //-----------------------------------------------------------------------------------
?>
