<?php

function scriptUsingIsEmpty(?string $exampleVar): string
{
    return empty($exampleVar) ? 'is empty' : 'is not empty';
}
