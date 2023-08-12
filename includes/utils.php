<?php

declare(strict_types=1);

use JetBrains\PhpStorm\Pure;

#[Pure] function arrange(int $start, int $end): array {
    return match (true) {
        $start >= $end => [],
        default => (function () use ($start, $end) {
            $head = $start;
            $tail = arrange($start + 1, $end);
            return [$head, ...$tail];
        })()
    };
}

#[Pure] function flatten(array $original): array {
    return array_reduce($original, function ($acc, $elem) {
        return match(gettype($elem)) {
            "array" => [...$acc, ...flatten($elem)],
            default => [...$acc, $elem]
        };
    }, []);
}

#[Pure] function cross_product(array $first, array $second): array {
    $output = array_map(function($x) use (&$second) {
        return array_map(fn($y) => [$x, $y], $second);
    }, $first);
    return flatten($output);
}

#[Pure] function sample(array $original, int $sample_size): array {
    return match($sample_size) {
        0 => [],
        default => (function () use (&$original, $sample_size) {
            $index = rand(0, count($original) - 1);
            $head = $original[$index];
            $next_array = array_filter($original, fn($_, $i) => $i !== $index);
            $tail = sample($next_array, $sample_size - 1);
            return [$head, ...$tail];
        })()
    };
}

