<?php

use JetBrains\PhpStorm\Pure;

require_once "cell.php";
require_once "utils.php";

#[Pure] function create_empty_real_board(int $cell_count): string {
    $range = arrange(0, $cell_count);
    $cell_strings = map($range, fn($i) => create_cell($i, CELL_UNREVEALED));
    return reduce($cell_strings, "", fn($a, $b) => $a . $b);
}
