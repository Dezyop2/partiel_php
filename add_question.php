<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = $_POST["question"];
    $reponse_attendue = $_POST["reponse_attendue"];
    $message_succes = $_POST["message_succes"];
    $message_mauvaise_reponse = $_POST["message_mauvaise_reponse"];

    // Utilisation d'une requête préparée pour éviter les problèmes de caractères spéciaux
    $sql = "INSERT INTO questions (question, reponse_attendue, message_succes, message_mauvaise_reponse, taux_reussite, tentatives_totales, tentatives_reussies) VALUES (?, ?, ?, ?, 0, 0, 0)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $question, $reponse_attendue, $message_succes, $message_mauvaise_reponse);

    if ($stmt->execute()) {
        echo "Question ajoutée avec succès!";
    } else {
        echo "Erreur lors de l'ajout de la question: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une question</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <?php include_once 'header.html'; ?>
    <div class="container mt-5">
        <h2>Ajouter une question</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="question">Question:</label>
                <input type="text" class="form-control" id="question" name="question" required>
            </div>
            <div class="form-group">
                <label for="reponse_attendue">Réponse attendue:</label>
                <input type="text" class="form-control" id="reponse_attendue" name="reponse_attendue" required>
            </div>
            <div class="form-group">
                <label for="message_succes">Message de succès:</label>
                <input type="text" class="form-control" id="message_succes" name="message_succes" required>
            </div>
            <div class="form-group">
                <label for="message_mauvaise_reponse">Message de mauvaise réponse:</label>
                <input type="text" class="form-control" id="message_mauvaise_reponse" name="message_mauvaise_reponse" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter la question</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>