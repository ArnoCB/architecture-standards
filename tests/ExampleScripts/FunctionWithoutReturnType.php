<?php

function test(): void
{
    array_map(static fn (int $i) => $i + 1, [1, 2, 3]);
}
