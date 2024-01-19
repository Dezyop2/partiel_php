<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $question_id = $_GET["id"];

    $sql = "SELECT * FROM questions WHERE id = $question_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $question = $row["question"];
        $taux_reussite = $row["taux_reussite"];
        $message_succes = $row["message_succes"];
        $message_mauvaise_reponse = $row["message_mauvaise_reponse"];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Répondre à la question</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2><?php echo $question; ?></h2>
        <form method="post" action="check_answer.php">
            <div class="form-group">
                <label for="reponse">Votre réponse:</label>
                <input type="text" class="form-control" id="reponse" name="reponse" required>
            </div>
            <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
            <button type="submit" class="btn btn-primary">Valider</button>
        </form>
        <p>Pourcentage de réussite: <?php echo $taux_reussite; ?>%</p>
        <div id="result"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>
