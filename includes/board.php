<?php

declare(strict_types=1);

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

#[Pure] function create_real_board_from_abstract(array $abstract_board): array {
    return array_map("create_cell", $abstract_board);
}

#[Pure] function generate_bombs(int $cell_count, int $bombs_amount): array {
    $range = arrange(0, $cell_count);
    $available = array_diff($range, $_GET["touched"]);
    return sample($available, $bombs_amount);
}

#[Pure] function create_empty_abstract_board(int $board_size): array {
    $size_range = arrange(0, $board_size);
    return array_map(function() use (&$size_range) {
        return array_map(fn() => CELL_UNREVEALED, $size_range);
    }, $size_range);
}

#[Pure] function create_abstract_board(int $board_size): array {
    $board = create_empty_abstract_board($board_size);


}