<?php

declare(strict_types=1);

use JetBrains\PhpStorm\Pure;

include_once "board.php";

const BOARD_SIZE = 10;
const CELLS_COUNT = BOARD_SIZE * BOARD_SIZE;
const BOMBS_AMOUNT = 20;

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

#[Pure] function render_status(): string {
    // TODO: implement rendering of status
    return "TODO: Implement rendering of status";
}