<?php

declare(strict_types=1);

use JetBrains\PhpStorm\Pure;

include_once "board.php";

const BOARD_SIZE = 10;
const CELLS_COUNT = BOARD_SIZE * BOARD_SIZE;
const BOMBS_AMOUNT = 13;

function render_board(): string {
    return match (isset($_GET["touched"])) {
        false => create_empty_real_board(CELLS_COUNT),
        default => (function() {
            if (!isset($_GET["bombs"])) {
                $_GET["bombs"] = generate_bombs(CELLS_COUNT, BOMBS_AMOUNT);
            }
            $abstract_board = create_abstract_board(BOARD_SIZE);
            return create_real_board_from_abstract($abstract_board);
        })()
    };
}

function render_status(): string {
    if (!isset($_GET["touched"])) {
        return "Start the game: press any cell!";
    }

    $failures = array_intersect($_GET["touched"], $_GET["bombs"]);
    $abstract_board = create_abstract_board(BOARD_SIZE);
    $unrevealed = array_filter($abstract_board, #[Pure] fn($cell) => $cell === CELL_UNREVEALED);

    return match (true) {
        count($failures) > 0 => "Well, you exploded " . count($failures) . " bombs",
        count($unrevealed) === BOMBS_AMOUNT => "Well done! Now, just don't touch anything",
        default => "Keep going, keep going..."
    };
}