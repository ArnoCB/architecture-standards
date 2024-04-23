<?php

namespace Tests\ExampleScripts;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ControllerWithNonResponseType extends Controller
{
    public function index(): string
    {
        return 'Hello World';
    }

    /**
     * @return string[]
     */
    public function index2(): array
    {
        return ['Hello World'];
    }

    public function index3(): JsonResponse
    {
        /** @phpstan-ignore-next-line  */
       return response()->json(['Hello World']);
    }
}

