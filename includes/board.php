<?php

declare(strict_types=1);

use JetBrains\PhpStorm\Pure;

require_once "cell.php";
require_once "utils.php";

function create_empty_real_board(int $cell_count): string {
    $range = arrange(0, $cell_count);
    $cells = array_map(#[Pure] function($number) {
        return create_cell($number, CELL_UNREVEALED);
    }, $range);
    return implode("", $cells);
}

function create_real_board_from_abstract(array $abstract_board): string {
    $cells = array_map(#[Pure] function($value, $number) {
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
        return array_map(#[Pure] fn() => CELL_UNREVEALED, $size_range);
    }, $size_range);
}

function create_bomb_map(int $board_size): array {
    $size_range = arrange(0, $board_size);
    return array_map(function ($i) use (&$size_range, $board_size) {
        return array_map(#[Pure] function ($j) use ($i, $board_size) {
            $number = $i * $board_size + $j;
            return in_array($number, $_GET["bombs"]);
        }, $size_range);
    }, $size_range);
}

function create_abstract_board(int $board_size): array {
    $coords = #[Pure] function ($number) use ($board_size) {
        $number = intval($number);
        $row = intdiv($number, $board_size);
        $col = $number % $board_size;
        return [$row, $col];
    };

    $board = create_empty_abstract_board($board_size);
    $bomb_map = create_bomb_map($board_size);
    $touched = array_map($coords, $_GET["touched"]);

    $recursive_reveal = function(int $row, int $col) use (&$board, &$bomb_map, $board_size, &$recursive_reveal) {
        if ($bomb_map[$row][$col]) return;
        $row_range = arrange($row - 1, $row + 2);
        $col_range = arrange($col - 1, $col + 2);
        $positions = cross_product($row_range, $col_range);
        $valid_positions = array_filter($positions, function($position) use ($row, $col, $board_size) {
           [$i, $j] = $position;
           return match (true) {
               ($i === $row && $j === $col) => false,
               $i < 0, $j < 0, $i >= $board_size, $j >= $board_size => false,
               default => true
           };
        });
        $bomb_count = array_sum(array_map(function ($position) use (&$bomb_map) {
            [$i, $j] = $position;
            return intval($bomb_map[$i][$j]);
        }, $valid_positions));
        $board[$row][$col] = $bomb_count;
        if ($bomb_count > 0) return;
        array_foreach(array_values($valid_positions), function ($position) use (&$recursive_reveal, &$board) {
            [$i, $j] = $position;
            if ($board[$i][$j] !== CELL_UNREVEALED) return;
            $recursive_reveal($i, $j);
        });
    };

    array_foreach($touched, function($touch) use (&$board, &$bomb_map, &$recursive_reveal) {
        [$row, $col] = $touch;
        if ($bomb_map[$row][$col]) {
            $board[$row][$col] = CELL_BOMB;
            return;
        }
        $recursive_reveal($row, $col);
    });

    return flatten($board);
}