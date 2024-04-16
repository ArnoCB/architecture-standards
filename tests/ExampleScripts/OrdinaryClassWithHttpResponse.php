<?php

declare(strict_types=1);

namespace Tests\ExampleScripts;

use Illuminate\Http\Response;

class OrdinaryClassWithHttpResponse
{
    public function ordinaryClassIndex(): Response
    {
        return new Response('Hello World', 200);
    }
}
