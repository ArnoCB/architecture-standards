<?php

use Rules\Functions\ForbidEmptyRule;
use PhpParser\Node\Expr\Empty_;
use PhpParser\Node\Expr\Variable;
use PHPStan\ShouldNotHappenException;

it( 'forbids the use of empty()',
    /**
     * @throws ShouldNotHappenException
     * @throws PHPUnit\Framework\MockObject\Exception
     */
    function () {
        $rule = new ForbidEmptyRule();
        $expression = new Variable('myVar');
        $node = new Empty_($expression);

        $scope = $this->createMock(PHPStan\Analyser\Scope::class);
        $errors = $rule->processNode($node, $scope);

        expect($errors[0]->getMessage())->toBe('Usage of empty() is forbidden.');
    }
);
