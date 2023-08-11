<?php
declare(strict_types=1);
include_once("includes/board.php");
?>
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
    <?php
    const CELL_COUNT = 100;
    echo create_empty_real_board(CELL_COUNT);
    ?>
</main>

</body>
</html>
