<!DOCTYPE html>
<?php 
    include 'connectie.php'

    session_start(); 

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
            
        } else {
            die("CSRF token validation failed. Sluit en heropen de pagina om opnieuw te proberen.");
        }
    }
?>

<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inlogpagina</title>
    <link rel="stylesheet" href="style_registreren.css">
</head>

<body>
    <main id = "registreren_main">
        <div>
            <form id = "registreren_form" action="Registreren.php" method="post">

                <header><h1>Registreren</h1></header>

                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" >

                <label for="email_invul_registreren">E-mail</label>
                <input type="email" name="email_invul_registreren" id="email_invul_registreren" maxlength = "50" size = "30">

                <label for="Voornaam">Voornaam</label>
                <input type="text" name = "voornaam_invul_registreren" maxlength = "20" size = "20">

                <label for="achternaam">Achternaam</label>
                <input type="text" name = "achternaam_invul_registreren" maxlength = "20" size = "20">

                <label for="klas">Klas</label>
                <input type="text" name="klas_invul_registreren" maxlength = "15" size = "15">


                <label for="wachtwoord_invul_registreren">Wachtwoord</label>
                <input type="password" name="wachtwoord_invul_registreren" id="wachtwoord_invul" maxlength = "100" size = "30">

                <label for="wachtwoord_invul_registreren">Wachtwoord herhalen</label>
                <input type="password" name="wachtwoord_invul_registreren" id="wachtwoord_invul" maxlength = "100" size = "30">
                <input type="submit" name="submit" id="submit_button" <?php if  ($if_Error == true) { ?> disabled <?php } ?> >
            </form>
        </div>
            <span id = "Db_error_tonen"><?php echo $Tekst_Error ?></span>
        <div id="inloggen">
                <span>Al een account? dan: </span>
                <a href="index.php"><button>Inloggen</button></a>
        </div>
    </main>
</body>
</html>