<!DOCTYPE html>
<?php 
    include 'connectie.php';

    session_start(); 

    if (isset($_SESSION['Gebruiker_email'])) {
        header('Location: index.php');
        exit;
    }

    function overeenkomende_wachtwoorden_check($wachtwoord_invul_1, $wachtwoord_invul_2){
        if ($wachtwoord_invul_1 === $wachtwoord_invul_2) {
            return true;
        } else {
            return false;
        }
    }
    
    function get_gebruiker_rolid($conn) {
        $query_get_gebruiker_rolid = "SELECT ID FROM Rol WHERE naam = 'Gebruiker' ";
        $stmt = $conn->prepare($query_get_gebruiker_rolid);
        $stmt->execute();

        $resultaat = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $resultaat;
    }

    function bestaat_gebruiker($registreerende_email, $conn) {

        $ingelogde_gebruiker_data_query = "SELECT COUNT(email) FROM Gebruiker WHERE email = :registreren_email ";
        $stmt = $conn->prepare($ingelogde_gebruiker_data_query);
        $stmt->bindParam(':registreren_email', $registreerende_email, \PDO::PARAM_STR);
        $stmt->execute();

        $resultaat = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $resultaat_int = $resultaat[0];

        if ($resultaat_int["COUNT(email)"] == 0) {
            return false;
        } else {
            return true;
        }
    }

    function wachtwoord_hashen($invul_wachtwoord) {
    return password_hash($invul_wachtwoord, PASSWORD_DEFAULT);
    }

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {

            if (overeenkomende_wachtwoorden_check($_POST['wachtwoord_invul_registreren'], $_POST['wachtwoord_invul_registreren_controle'])) {

                if ((bestaat_gebruiker($_POST['email_invul_registreren'], $conn)) == false){

                    $query_insert_gebruiker = "INSERT INTO Gebruiker (email, wachtwoord, voornaam, achternaam, klas, rolld) VALUES (:email,:wachtwoord,:voornaam,:achternaam,:klas,:rolid)";

                    $hash_wachtwoord = wachtwoord_hashen($_POST['wachtwoord_invul_registreren']);
                    
                    $gebruiker_rolid = intval(get_gebruiker_rolid($conn));

                    $stmt = $conn->prepare($query_insert_gebruiker);

                    $stmt->bindParam(':email', $_POST['email_invul_registreren'], \PDO::PARAM_STR);
                    $stmt->bindParam(':wachtwoord', $hash_wachtwoord, \PDO::PARAM_STR);
                    $stmt->bindParam(':voornaam', $_POST['voornaam_invul_registreren'], \PDO::PARAM_STR);
                    $stmt->bindParam(':achternaam', $_POST['achternaam_invul_registreren'], \PDO::PARAM_STR);
                    $stmt->bindParam(':klas', $_POST['klas_invul_registreren'], \PDO::PARAM_STR);
                    $stmt->bindParam(':rolid', $gebruiker_rolid, \PDO::PARAM_INT);
                    $stmt->execute();

                    ?>
                    <script>
                        alert("Het inloggen is gelukt. Druk op ok om verder te gaan."); 
                        window.location.href = "index.php";
                    </script>
                    <?php

                } else {
                    $Tekst_Error = "Er bestaat al een gebruiker met deze email - gebruik een ander email"; ?>
                    <style>
                    #email_invul_registreren{
                        border-radius: 2px;
                        border-color: red;
                        border-style: solid;
                        border-radius: 3px;
                    }
                </style>
                <?php }
            } else {
                $Tekst_Error = "De gegeven wachtwoorden komen niet overeen"; ?>
                <style>
                    .wachtwoord_invul{
                        border-radius: 2px;
                        border-color: red;
                        border-style: solid;
                        border-radius: 3px;
                    }
                </style>
            <?php }

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
                <input type="email" name="email_invul_registreren" id="email_invul_registreren" maxlength = "50" size = "30" required>

                <label for="Voornaam">Voornaam</label>
                <input type="text" name = "voornaam_invul_registreren" maxlength = "20" size = "20" required>

                <label for="achternaam">Achternaam</label>
                <input type="text" name = "achternaam_invul_registreren" maxlength = "20" size = "20" required>

                <label for="klas">Klas</label>
                <input type="text" name="klas_invul_registreren" maxlength = "15" size = "15" required>


                <label for="wachtwoord_invul_registreren">Wachtwoord</label>
                <input type="password" name="wachtwoord_invul_registreren" class="wachtwoord_invul" maxlength="100" size="30" required>

                <label for="wachtwoord_invul_registreren">Wachtwoord herhalen</label>
                <input type="password" name="wachtwoord_invul_registreren_controle" class="wachtwoord_invul "maxlength="100" size="30" requird>
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