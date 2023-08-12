<?php

declare(strict_types=1);

use JetBrains\PhpStorm\Pure;

require_once "cell.php";
require_once "utils.php";

function create_empty_real_board(int $cell_count): string {
    $range = arrange(0, $cell_count);
    $cells = array_map(function($number) {
        return create_cell($number, CELL_UNREVEALED);
    }, $range);
    return implode("", $cells);
}

function create_real_board_from_abstract(array $abstract_board): string {
    $cells = array_map(function($value, $number) {
        return create_cell($number, $value);
    }, $abstract_board, array_keys($abstract_board));
    return implode("", $cells);
}

function generate_bombs(int $cell_count, int $bombs_amount): array {
    $range = arrange(0, $cell_count);
    $available = array_diff($range, $_GET["touched"]);
    return sample($available, $bombs_amount);
}

function create_empty_abstract_board(int $board_size): array {
    $size_range = arrange(0, $board_size);
    return array_map(function() use (&$size_range) {
        return array_map(fn() => CELL_UNREVEALED, $size_range);
    }, $size_range);
}

function create_abstract_board(int $board_size): array {
    $coords = #[Pure] function ($number) use ($board_size) {
        $row = intdiv($number, $board_size);
        $col = $number % $board_size;
        return [$row, $col];
    };

    $board = create_empty_abstract_board($board_size);
    $bombs = array_map($coords, $_GET["bombs"]);
    $touched = array_map($coords, $_GET["touched"]);
    $recursive_reveal = function($position) {
        // TODO: ...
    };

    array_foreach($touched, function($touch) {
        // TODO: ...
    });
    return flatten($board);
}