<?php

use JetBrains\PhpStorm\Pure;

require_once "cell.php";
require_once "utils.php";

#[Pure] function create_empty_real_board(int $cell_count): string {
    $range = arrange(0, $cell_count);
    $cells = array_map(function($number) {
        return create_cell($number, CELL_UNREVEALED);
    }, $range);
    return implode("", $cells);
}

#[Pure] function generate_bombs(int $board_size, int $bombs_amount): array {
    $size_range = arrange(0, $board_size);
    $positions = cross_product($size_range, $size_range);
    return sample($positions, $bombs_amount);
}