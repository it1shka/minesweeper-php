<?php

declare(strict_types=1);

function arrange(int $start, int $end): array {
    return match (true) {
        $start >= $end => [],
        default => (function () use ($start, $end) {
            $head = $start;
            $tail = arrange($start + 1, $end);
            return [$head, ...$tail];
        })()
    };
}

function flatten(array $original, bool $shallow = false): array {
    return array_reduce($original, function ($acc, $elem) use ($shallow) {
        return match(gettype($elem)) {
            "array" => [...$acc, ...($shallow
                ? $elem
                : flatten($elem))],
            default => [...$acc, $elem]
        };
    }, []);
}

function sample(array $original, int $sample_size): array {
    return match($sample_size) {
        0 => [],
        default => (function () use (&$original, $sample_size) {
            $index = rand(0, count($original) - 1);
            $head = $original[$index];
            $next_array = array_filter($original, fn($i) => $i !== $index, ARRAY_FILTER_USE_KEY);
            $tail = sample(array_values($next_array), $sample_size - 1);
            return [$head, ...$tail];
        })()
    };
}

function array_foreach(array $original, callable $func): void {
    if (count($original) <= 0) return;
    [$head, $tail] = [$original[0], array_slice($original, 1)];
    $func($head);
    array_foreach($tail, $func);
}

function cross_product(array $first, array $second): array {
    $output = array_map(function ($a) use (&$second) {
        return array_map(fn ($b) => [$a, $b], $second);
    }, $first);
    return flatten($output, true);
}
