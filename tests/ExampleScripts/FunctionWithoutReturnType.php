<?php

function test(): void
{
    $test = array_map(static fn (int $i) => $i + 1, [1, 2, 3]);
}
