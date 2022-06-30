
<!--PHP Code-->
<?php
    $number = $_POST["Generate"];

    

    function Generate(){
       //Arrays
        $Names = array("Asher","Jeremy","Hezekiahx","Grant","Kirsten","Brennen",
        "Lyric","Tori","Emanuel","Yosef","Brielle","Cassie","Diana","Dante",
        "Delaney","Alaina","David","Asia","Coby","Emerson");

        $Surnames = array("Humphrey","Powell","Powell","Abbott","Fernandez",
        "Hatfield","Beck","Lamb","Weeks","Conrad","Smith","Morrow","Berger",
        "Flynn","Booker", "Callahan","Montes","Mahoney","Stewart","Zhang");
        
        //random name
        $first_name = $Names[array_rand($Names)];
        $last_name = $Surnames[array_rand($Surnames)];
        
        //random age and initial
        $age = random_int(15,70);
        $initials = substr($first_name, 0, 1);

        //random birth date
        $random = rand(strtotime("70 years ago"),strtotime("18 years ago"));
        $date_of_birth = date("d/m/Y",$random);
        $x = 0;
        $data = array(
            ["Id"=> $x,"name" => $first_name,"surname" => $last_name,"initials" => $initials, "age" => $age,"dob" => $date_of_birth] 
        );

        return $data;
    }   
        

    // print_r(Generate());
    
    

    function createCSV($numVariations){
        
        $fp = fopen('output\\output.csv', 'a');
        $y = 0;
        $header =  array(
            ['Id','Name','Surname','Initial','Age','Date_Of_Birth']
        );
        foreach($header as $fields){
            fputcsv($fp, $fields);
        }
        for($i = 0; $i < $numVariations; $i++){
            $y++;
            $array = Generate();
            $array[0]["Id"] = $y;

            foreach($array as $field){
                fputcsv($fp, $field);
            }
            
        }

        fclose($fp);
    }
    
    createCSV(100);

 
  
    
    

 ?>
