<!DOCTYPE html>

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

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

    session_start(); 

?>

<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inlogpagina</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main>
ingelogd
    </main>
</body>
</html>