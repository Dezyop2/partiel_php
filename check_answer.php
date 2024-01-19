<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reponse_utilisateur = $_POST["reponse"];
    $question_id = $_POST["question_id"];

    // Récupération de la réponse attendue depuis la base de données
    $sql = "SELECT reponse_attendue, message_succes, message_mauvaise_reponse, tentatives_totales, tentatives_reussies FROM questions WHERE id = $question_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $reponse_attendue = $row["reponse_attendue"];
        $message_succes = $row["message_succes"];
        $message_mauvaise_reponse = $row["message_mauvaise_reponse"];
        $tentatives_totales = $row["tentatives_totales"];
        $tentatives_reussies = $row["tentatives_reussies"];

        // Incrémentation des tentatives totales
        $tentatives_totales++;

        if ($reponse_utilisateur == $reponse_attendue) {
            // Incrémentation des tentatives réussies si la réponse est correcte
            $tentatives_reussies++;
            echo "Bonne réponse : " . $message_succes;
        } else {
            echo "Mauvaise réponse : " . $message_mauvaise_reponse;
        }

        // Mise à jour des tentatives dans la base de données
        $sqlUpdate = "UPDATE questions SET tentatives_totales = $tentatives_totales, tentatives_reussies = $tentatives_reussies WHERE id = $question_id";
        $conn->query($sqlUpdate);
    } else {
        echo "Aucune question trouvée.";
    }
} else {
    echo "Mauvaise méthode de requête.";
}

$conn->close();
?>
