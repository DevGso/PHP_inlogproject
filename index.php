<!DOCTYPE html>

<?php 
    include 'connectie.php';

    function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);

        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }

    function check_login ($email_invul, $wachtwoord_invul, $conn) {

        $login_check_query = "SELECT email, wachtwoord FROM Gebruiker where email = :email";
        $stmt = $conn->prepare($login_check_query);
        $stmt->bindParam(':email', $email_invul, \PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        $DB_data = $data[0];
        
            if (empty($data)) {
                return false;
            } 
            if (password_verify($wachtwoord_invul, $DB_data['wachtwoord'])) {
                return true;
            }
    }

    function get_ingelogde_gebruiker_data($email_invul, $conn){

        $ingelogde_gebruiker_data_query = "SELECT Gebruiker.email, Gebruiker.voornaam, Gebruiker.achternaam, Gebruiker.klas, Gebruiker.rolld, Rol.ID, Rol.naam 
                                            FROM Gebruiker 
                                            JOIN Rol on Gebruiker.rolld = Rol.ID AND Gebruiker.email = :email";
        $stmt = $conn->prepare($ingelogde_gebruiker_data_query);
        $stmt->bindParam(':email', $email_invul, \PDO::PARAM_STR);
        $stmt->execute();

        $resultaat = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $gebruiker_data = $resultaat[0];
        
        return $gebruiker_data;
    }



    session_start(); 

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
            $of_login_geslaagd = check_login($_POST["email_invul"], $_POST["wachtwoord_invul"], $conn);

            if ($of_login_geslaagd){
                $ingelogde_gebruiker_data = get_ingelogde_gebruiker_data($_POST['email_invul'], $conn);
                session_regenerate_id();
                $_SESSION['Gebruiker_email'] = $ingelogde_gebruiker_data['email'];
                $_SESSION['Gebruiker_voornaam'] = $ingelogde_gebruiker_data['voornaam'];
                $_SESSION['Gebruiker_achternaam'] = $ingelogde_gebruiker_data['achternaam'];
                $_SESSION['Gebruiker_klas'] = $ingelogde_gebruiker_data['klas'];
                $_SESSION['Gebruiker_naam'] = $ingelogde_gebruiker_data['naam'];
                header("Location: ingelogd.php");
                exit();
            } else {
                $Tekst_Error = "Verkeerde gegevens - Login gefaald";
            }
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
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main id = "index_main">
        <div>
            <form id = "inloggen_form" action="index.php" method="post">

                <header><h1>Inloggen</h1></header>

                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" >

                <label for="email_invul">E-mail</label>
                <input type="email" name="email_invul" id="email_invul" maxlength = "50" size = "30">
                <label for="wachtwoord_invul">wachtwoord</label>
                <input type="password" name="wachtwoord_invul" id="wachtwoord_invul" maxlength = "100" size = "30">
                <input type="submit" name="submit" id="submit_button" <?php if  ($if_Error == true) { ?> disabled <?php } ?> >
            </form>
        </div>
            <span id = "Db_error_tonen"><?php echo $Tekst_Error ?></span>
        <div id="Registreren">
                <span>Nog geen accout? dan: </span>
                <a href="Registreren.php"><button>Registreren</button></a>
        </div>
    </main>
</body>
</html>