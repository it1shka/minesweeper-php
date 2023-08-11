<?php

use JetBrains\PhpStorm\Pure;

#[Pure] function arrange(int $start, int $end): array {
    return match (true) {
        $start >= $end => [],
        default => (function() use ($start, $end) {
            $head = $start;
            $tail = arrange($start + 1, $end);
            return [$head, ...$tail];
        })()
    };
}