<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Documentation;

use ArchitectureStandards\Rules\AbstractBaseRule;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleError;
use PHPStan\ShouldNotHappenException;

/**
 * The use of primitive type synonyms is forbidden, because although they are valid in PHP, they don't
 * work in phpdoc type hints. This would lead to confusion.
 */
class ForbidPrimitiveTypeSynonymsRule extends AbstractBaseRule
{
    protected const ERROR_MESSAGE = 'Use of primitive type synonym %s is forbidden.';

    private const FORBIDDEN_SYNONYMS = [
        'boolean',
        'integer',
        'real',
        'double'
    ];

    private const REGEX_FOR_PHPDOC_TAGS = [
        'param'  => '/@param\s+(\S+)\s+\$(\S+)/',
        'return' => '/@return\s+(\S+)/',
    ];

    /**
     * @var array<RuleError>
     */
    public array $messages = [];

    public function getNodeType(): string
    {
        return ClassMethod::class;
    }

    /**
     * @param  ClassMethod $node
     * @return array<RuleError>
     * @throws ShouldNotHappenException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) $scope
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if ($node->getDocComment() === null) {
            return [];
        }

        $docComment = $node->getDocComment()->getText();

        $this->checkTypeForTag($docComment, self::REGEX_FOR_PHPDOC_TAGS['param']);
        $this->checkTypeForTag($docComment, self::REGEX_FOR_PHPDOC_TAGS['return']);

        return $this->messages;
    }

    /**
     * @throws ShouldNotHappenException
     */
    private function checkTypeForTag(string $docComment, string $regex): void
    {
        preg_match_all($regex, $docComment, $matches);
        $this->findForbiddenTypes($matches);
    }

    /**
     * @param  array<array<string>> $matches
     * @return void
     * @throws ShouldNotHappenException
     */
    private function findForbiddenTypes(array $matches): void
    {
        foreach ($matches[1] as $match) {
            if (str_contains($match, '<') || str_contains($match, '{')) {
                $this->checkComplexType($match);
                continue;
            }

            $this->checkPrimitiveType($match);
        }
    }

    /**
     * @throws ShouldNotHappenException
     */
    private function checkComplexType(string $match): void
    {
        foreach (self::FORBIDDEN_SYNONYMS as $forbiddenType) {
            if (str_contains($match, $forbiddenType)) {
                $this->messages[] = $this->formattedError("$forbiddenType in $match");
            }
        }
    }

    /**
     * @throws ShouldNotHappenException
     */
    private function checkPrimitiveType(string $match): void
    {
        if (in_array($match, self::FORBIDDEN_SYNONYMS)) {
            $this->messages[] = $this->formattedError($match);
        }
    }
}
