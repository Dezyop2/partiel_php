<?php
include 'config.php';

// Récupération de l'option de tri depuis la requête GET
$tri = isset($_GET['tri']) ? $_GET['tri'] : 'id';
$order = isset($_GET['ordre']) && $_GET['ordre'] == 'desc' ? 'DESC' : 'ASC';

// Requête SQL pour récupérer les questions triées
$sql = "SELECT * FROM questions ORDER BY $tri $order";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des questions</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <?php include_once 'header.html'; ?>
    <div class="container mt-5">
        <h2>Liste des questions</h2>

        <table class="table">
            <thead>
                <tr>
                    <th><a href="?tri=id&ordre=<?php echo $order == 'ASC' ? 'desc' : 'asc'; ?>">ID</a></th>
                    <th>Question</th>
                    <th><a href="?tri=taux_reussite&ordre=<?php echo $order == 'ASC' ? 'desc' : 'asc'; ?>">Taux de Réussite</a></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo $row["question"]; ?></td>
                        <td><?php echo $row["taux_reussite"] . '%'; ?></td>
                        <td>
                            <a href="delete_question.php?id=<?php echo $row["id"]; ?>" class="btn btn-danger btn-sm">Supprimer</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>