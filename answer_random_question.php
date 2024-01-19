<?php
session_start();
include 'config.php';

// Vérifie si l'ID de la question est déjà stocké dans la session
if (!isset($_SESSION['question_id'])) {
    // Sélection aléatoire d'une question si l'ID n'est pas déjà défini
    $sql = "SELECT id, question, taux_reussite FROM questions ORDER BY RAND() LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $question_id = $row["id"];
        $_SESSION['question_id'] = $question_id;
        $question = $row["question"];
        $taux_reussite = $row["taux_reussite"];
    } else {
        // Gérer le cas où aucune question n'est trouvée
        echo "Aucune question trouvée.";
        exit();
    }
} else {
    // Récupérer l'ID de la question depuis la session
    $question_id = $_SESSION['question_id'];

    // Récupérer la question en fonction de l'ID
    $sql = "SELECT question, taux_reussite FROM questions WHERE id = $question_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $question = $row["question"];
        $taux_reussite = $row["taux_reussite"];
    } else {
        // Gérer le cas où aucune question n'est trouvée
        echo "Aucune question trouvée.";
        exit();
    }
}

// Variables pour le traitement du formulaire
$message = '';
$form_visible = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reponse_utilisateur = $_POST["reponse"];

    // Récupération de la réponse attendue depuis la base de données
    $sql = "SELECT reponse_attendue, message_succes, message_mauvaise_reponse FROM questions WHERE id = $question_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $reponse_attendue = $row["reponse_attendue"];
        $message_succes = $row["message_succes"];
        $message_mauvaise_reponse = $row["message_mauvaise_reponse"];

        if ($reponse_utilisateur == $reponse_attendue) {
            $message = "<div class='alert alert-success' role='alert'>" . $message_succes . "</div>";
            $form_visible = false;

            // Mettez à jour le taux de réussite en appelant la fonction
            updateTauxReussite($question_id, true);
        } else {
            $message = "<div class='alert alert-danger' role='alert'>" . $message_mauvaise_reponse . "</div>";

            // Mettez à jour le taux de réussite en appelant la fonction
            updateTauxReussite($question_id, false);
        }
    }
}

// Fonction pour mettre à jour le pourcentage de réussite
function updateTauxReussite($question_id, $reponse_correcte)
{
    global $conn;

    // Récupération du nombre total de tentatives et du nombre de tentatives réussies
    $sql = "SELECT tentatives_totales, tentatives_reussies FROM questions WHERE id = $question_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $tentatives_totales = $row["tentatives_totales"];
        $tentatives_reussies = $row["tentatives_reussies"];

        // Mise à jour des compteurs
        $tentatives_totales++;
        if ($reponse_correcte) {
            $tentatives_reussies++;
        }

        // Calcul du nouveau pourcentage de réussite
        $nouveau_taux_reussite = ($tentatives_reussies / $tentatives_totales) * 100;

        // Mise à jour du pourcentage de réussite dans la base de données
        $sqlUpdate = "UPDATE questions SET taux_reussite = $nouveau_taux_reussite, tentatives_totales = $tentatives_totales, tentatives_reussies = $tentatives_reussies WHERE id = $question_id";

        if ($conn->query($sqlUpdate) === TRUE) {
            return $nouveau_taux_reussite;
        } else {
            echo "Erreur lors de la mise à jour du taux de réussite: " . $conn->error;
        }
    }

    return 0; // En cas d'erreur
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Répondre à une question</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Répondre à une question</h2>
        <p>Question: <?php echo $question; ?></p>
        <?php echo $message; ?>

        <?php if ($form_visible) : ?>
            <form method="post" action="">
                <div class="form-group">
                    <label for="reponse">Réponse:</label>
                    <input type="text" class="form-control" id="reponse" name="reponse" required>
                </div>
                <button type="submit" class="btn btn-primary">Valider</button>
            </form>
        <?php endif; ?>

        <p>Pourcentage de réussite: <?php echo $taux_reussite; ?>%</p>
        <form action="list_questions.php" method="post">
            <button type="submit" class="btn btn-primary">Quitter</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>
