<?php

function scriptWithIsNull(?string $exampleVar): string
{
    if (is_null($exampleVar)) {
        return 'is null';
    }

    return $exampleVar;
}
