<?php

use JetBrains\PhpStorm\Pure;

#[Pure] function arrange(int $start, int $end): iterable {
    for ($i = $start; $i < $end; $i++) {
        yield $i;
    }
}

#[Pure] function map(iterable $stream, callable $func): iterable {
    foreach ($stream as $key => $value) {
        $result = $func($value, $key);
        yield $result;
    }
}

#[Pure] function reduce(iterable $stream, mixed $start_value, callable $reducer): mixed {
    $output = $start_value;
    foreach ($stream as $key => $value) {
        $output = $reducer($output, $value, $key);
    }
    return $output;
}