<?php

declare(strict_types=1);

use JetBrains\PhpStorm\Pure;

const CELL_UNREVEALED = -2;
const CELL_BOMB = -1;

#[Pure] function get_cell_color(int $cell_value): string {
    return match($cell_value) {
        CELL_UNREVEALED => "white",
        CELL_BOMB => "#ff6699",
        default => (#[Pure] function() use ($cell_value) {
            $coefficient = 200 - 150 * $cell_value / 9;
            return "rgb($coefficient, $coefficient, 240)";
        })()
    };
}

#[Pure] function create_unrevealed_cell_link(int $cell_number): string {
    $touched = $_GET["touched"] ?? [];
    $new_touched = [...$touched, $cell_number];
    $new_get = [...$_GET, "touched" => $new_touched];
    $new_get_query = http_build_query($new_get);
    $old_base = $_SERVER["PHP_SELF"];
    return "href='$old_base?$new_get_query'";
}

#[Pure] function create_cell(int $cell_number, int $cell_value): string {
    $color = get_cell_color($cell_value);
    $class = match($cell_value) {
        CELL_UNREVEALED => "unrevealed",
        CELL_BOMB => "bomb",
        default => "revealed"
    };
    [$elem, $link] =
        $cell_value === CELL_UNREVEALED
            ? ["a", create_unrevealed_cell_link($cell_number)]
            : ["div", ""];
    $text =
        $cell_value > 0
            ? "$cell_value"
            : "";
    return (
        "<$elem $link class='cell $class' style='background: $color'>" .
            $text .
        "</$elem>"
    );
}
