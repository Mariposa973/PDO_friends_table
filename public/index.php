<?php

require_once '../connect.php';
$pdo = new \PDO(DSN, USER, PASS);

if (isset($_GET['submit'])) {
    $data = array_map('trim', $_GET);
    $firstname = $data['firstname'];
    $lastname = $data['lastname'];

    $errors = [];

    // validation process for each input
    if (empty($firstname)) {
        $errors[] = 'The name is mandatory';
    }

    if (empty($lastname)) {
        $errors[] = 'The lastname is mandatory';
    }

    if ($firstname > 45 || $lastname > 45) {
        $errors[] = 'Too long';
    }

    $query = "INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)";
    $statement = $pdo->prepare($query);
    $statement->bindValue(":firstname", $firstname);
    $statement->bindValue(":lastname", $lastname);
    $statement->execute();
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premier Formulaire PDO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <form class="friendAdd" method="GET">
            <legend>Ajouter un ami</legend>

            <div class="mb-3">
                <label class="form-label" for="firstname">Firstname</label>
                <input class="form-control" type="text" name="firstname" id="firstname">
            </div>

            <div class="mb-3">
                <label class="form-label" for="lastname">Lastname</label>
                <input class="form-control" type="text" name="lastname" class="lastname" id="lastname">
            </div>

            <input class="btn btn-primary" type="submit" name="submit" value="Créer" />
        </form>
    </div>

    <h3>Friends list</h3>
    <div>
        <?php
        $query2 = "SELECT firstname, lastname FROM friend ORDER BY lastname ASC";
        $statement2 = $pdo->query($query2);
        $friends = $statement2->fetchAll(PDO::FETCH_ASSOC);
        echo '<table class="table"> <thead> <tr> <th scope="col">Firstname</th> <th scope="col">Lastname</th> </tr> </thead>';
        foreach ($friends as $friend) {
            echo "<tr>";
            echo "<td> $friend[firstname] </td>";
            echo "<td> $friend[lastname] </td>";
            echo "</tr>";
        }
        echo "</table>"
        ?>
    </div>
</body>


</html>