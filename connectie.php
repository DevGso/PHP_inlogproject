<?php 
    $dbhost = 'localhost';
    $dbname = 'InlogProject_Giel';
    $dbuser = 'InlogProject';
    $dbpass = 'Gilde123!';

    $if_Error = false;
    $Tekst_Error = "";
    
    try {
        $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    } catch (PDOException $e) {
        $if_Error = true;
        $Tekst_Error = "Probeem met de database connectie probeer het later opnieuw. Error:" . $e->getMessage();
    }
?>