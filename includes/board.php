<?php

use JetBrains\PhpStorm\Pure;

require_once "cell.php";
require_once "utils.php";

#[Pure] function create_empty_real_board(int $cell_count): string {
    $range = arrange(0, $cell_count);
    $cells = array_map(fn($i) => create_cell($i, CELL_UNREVEALED), $range);
    return implode("", $cells);
}
