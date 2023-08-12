<?php include_once("includes/render.php") ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minesweeper</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<main class="tic-tac-toe">
    <?= render_board() ?>
</main>

<h1><?= render_status() ?></h1>

</body>
</html>
