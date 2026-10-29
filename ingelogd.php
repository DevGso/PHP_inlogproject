<!DOCTYPE html>

<?php 
include 'connectie.php';

    session_start();

    if (!isset($_SESSION['Gebruiker_email'])) {
        header('Location: index.php');
        exit;
    }
    if($_SESSION['Gebruiker_rol'] === "Admin"){ ?>
        <style>
            body {
                background-color: green;
            }
        </style>
    <?php } else if ($_SESSION['Gebruiker_rol'] === "Gebruiker") { ?>
        <style>
            body {
                background-color: blue;
            }
        </style>
    <?php }

    function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);

        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }

    function ophalen_gebruikers($conn) {

        $gebruikers_data_query = "SELECT Gebruiker.email, Gebruiker.voornaam, Gebruiker.achternaam, Gebruiker.klas, Gebruiker.rolld, Rol.ID, Rol.naam 
                                FROM Gebruiker 
                                JOIN Rol on Gebruiker.rolld = Rol.ID";

        $stmt = $conn->prepare($gebruikers_data_query);
        $stmt->execute();

        $data = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

?>

<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inlogpagina</title>
    <link rel="stylesheet" href="style_ingelogd.css">
</head>

<body>
    <main>
        <table>
            <tr>
                <th>E-mail</th>
                <th>voornaam</th>
                <th>achternaam</th>
                <th>klas</th>
                <th>rol</th>
            </tr>
            
                <?php 
                $gebruikers_data = ophalen_gebruikers($conn);
                foreach ($gebruikers_data as $gebruikers) { ?>
                <tr>
                    <td> <?php echo htmlspecialchars($gebruikers['email']); ?> </td>
                    <td> <?php echo htmlspecialchars($gebruikers['voornaam']); ?> </td>
                    <td> <?php echo htmlspecialchars($gebruikers['achternaam']); ?> </td>
                    <td> <?php echo htmlspecialchars($gebruikers['klas']); ?> </td>
                    <td> <?php echo htmlspecialchars($gebruikers['naam']); ?> </td>
                </tr>
                <?php } ?>
            
        </table>
        <span id = "Db_error_tonen"><?php echo $Tekst_Error; ?></span>
    </main>
</body>
</html>