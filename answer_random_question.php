<?php
session_start();
include 'config.php';

// Vérifie si l'ID de la question est déjà stocké dans la session
if (!isset($_SESSION['question_id'])) {
    // Si l'ID n'est pas déjà défini, initialisez-le à null
    $_SESSION['question_id'] = null;
}

// Récupération de l'ID de la question actuelle
$question_id = $_SESSION['question_id'];

// Variables pour le traitement du formulaire
$message = '';
$form_visible = false;

// Si l'ID de la question est défini, récupérez les détails de la question
if ($question_id !== null) {
    $sql = "SELECT question, taux_reussite FROM questions WHERE id = $question_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $question = $row["question"];
        $taux_reussite = $row["taux_reussite"];
        $form_visible = true;
    } else {
        // Gérer le cas où la question n'est pas trouvée
        echo "La question n'a pas pu être récupérée.";
        exit();
    }
}

// Traitement du formulaire pour changer de question
if (isset($_POST['change_question'])) {
    // Sélection aléatoire d'une nouvelle question
    $sql = "SELECT id, question, taux_reussite FROM questions ORDER BY RAND() LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $question_id = $row["id"];
        $_SESSION['question_id'] = $question_id;
    }
}

// Traitement du formulaire pour répondre à la question
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si la clé "reponse" existe dans $_POST
    $reponse_utilisateur = isset($_POST["reponse"]) ? $_POST["reponse"] : null;

    if ($question_id !== null) {
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

                // Mettez à jour le taux de réussite en appelant la fonction
                updateTauxReussite($question_id, true);

                // Réinitialiser la session pour permettre une nouvelle sélection aléatoire lors du prochain changement de question
                $_SESSION['question_id'] = null;
            } else {
                $message = "<div class='alert alert-danger' role='alert'>" . $message_mauvaise_reponse . "</div>";

                // Mettez à jour le taux de réussite en appelant la fonction
                updateTauxReussite($question_id, false);
            }
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

        <!-- Formulaire pour changer de question -->
        <form method="post" action="">
            <button type="submit" class="btn btn-primary mb-2" name="change_question">Changer de question</button>
        </form>

        <!-- Affichage de la question si le formulaire est visible -->
        <?php if ($form_visible) : ?>
            <p>Question: <?php echo $question; ?></p>
            <?php echo $message; ?>

            <!-- Formulaire pour répondre à la question -->
            <form method="post" action="">
                <div class="form-group">
                    <label for="reponse">Réponse:</label>
                    <input type="text" class="form-control" id="reponse" name="reponse" required>
                </div>
                <button type="submit" class="btn btn-primary">Valider</button>
            </form>

            <!-- Affichage du pourcentage de réussite -->
            <p>Pourcentage de réussite: <?php echo $taux_reussite; ?>%</p>
        <?php endif; ?>

        <form action="list_questions.php" method="post">
            <button type="submit" class="btn btn-primary">Quitter</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>
