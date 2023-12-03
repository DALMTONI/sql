<?php
// Informations de la base de données
$serveur = "51.210.151.13";
$login = "EleveRostand1!";
$pass = "EleveRostand1!";
$base = "nom_de_ta_base"; // Remplace "nom_de_ta_base" par le nom de ta base de données

// Connexion à la base de données avec PDO
try {
    $pdo = new PDO("mysql:host=$serveur;dbname=$base", $login, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie à la base de données\n";

    // Utiliser la méthode prepare pour éviter les attaques par injection SQL
    $login = $pdo->quote($_POST['login']);
    $passwd = $pdo->quote($_POST['passwd']);

    $pdostat = $pdo->prepare("
        SELECT *
        FROM membre
        WHERE login = $login
        AND passwd = $passwd
    ");

    $pdostat->execute();

    echo "Requête exécutée\n";

    // Utiliser fetch() pour obtenir le résultat
    if ($utilisateur = $pdostat->fetch()) {
        echo "Bienvenue {$utilisateur['nom']}\n";
    } else {
        echo "Désolé...\n";
    }
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}

?>
