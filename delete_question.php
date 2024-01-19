<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $question_id = $_GET["id"];

    $sql = "DELETE FROM questions WHERE id = $question_id";
    $conn->query($sql);
}

$conn->close();

header("Location: list_questions.php");
exit();
?>
