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
        <div>
            <form id = "inloggen_form" action="Inloggen_check.php" method="post">

                <header><h1>Inloggen</h1></header>

                <label for="email_invul">E-mail</label>
                <input type="email" name="email_invul" id="email_invul">
                <label for="wachtwoord_invul">wachtwoord</label>
                <input type="password" name="wachtwoord_invul" id="wachtwoord_invul">
                <input type="submit" name="submit" id="submit_button" <?php if  ($if_Error == true) { ?> disabled <?php } ?> >
            </form>
        </div>
        <?php 
        if  ($if_Error == true) { ?>
            <span id = "Db_error_tonen"><?php echo $Tekst_Error ?></span>
        <?php } ?>
        <div id="Registreren">
                <span>Nog geen accout? dan: </span>
                <a href="Registreren.php"><button>Registreren</button></a>
        </div>
    </main>
</body>
</html>