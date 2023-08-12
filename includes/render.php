<?php

declare(strict_types=1);

use JetBrains\PhpStorm\Pure;

include_once "board.php";

const BOARD_SIZE = 10;
const CELL_COUNT = BOARD_SIZE * BOARD_SIZE;

#[Pure] function render_board(): string {
    return match (isset($_GET["touched"])) {
        false => create_empty_real_board(CELL_COUNT),
        default => (function() {
            $abstract_board = create_abstract_board(BOARD_SIZE);
            return create_real_board_from_abstract($abstract_board);
        })()
    };
}

#[Pure] function render_status(): string {
    // TODO: implement rendering of status
    return "TODO: Implement rendering of status";
}