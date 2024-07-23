<?php

function ScriptUsingFilled(): void
{
    $array = [1, 2, 3];

    if (filled($array)) {
        echo 'Array is filled';
    }
}

function ScriptUsingBlank(): void
{
    $array = [1, 2, 3];

    if (blank($array)) {
        echo 'Array is not filled';
    }
}
