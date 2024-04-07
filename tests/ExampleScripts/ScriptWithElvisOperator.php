<?php

function scriptWithElvisOperator(?string $exampleVar): string
{
    return $exampleVar ?: 'is null';
}
