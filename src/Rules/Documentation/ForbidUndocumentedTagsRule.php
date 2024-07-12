<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Documentation;

use ArchitectureStandards\Helpers\ErrorFormatter;
use ArchitectureStandards\Traits\WithClassTypeChecks;
use phpDocumentor\Reflection\DocBlock\Tag;
use phpDocumentor\Reflection\DocBlockFactory;
use PhpParser\Comment\Doc;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\ShouldNotHappenException;

/**
 * @implements Rule<Node>
 */
class ForbidUndocumentedTagsRule implements Rule
{
    use WithClassTypeChecks;

    /**
     * This is a list of known PHPDoc tags from PSR-19, the PHPDoc reference and some unofficial tags.
     *
     * @var array<int, string>
     */
    public const KNOWN_TAGS = [
        'api',
        'author',
        'copyright',
        'deprecated',
        'example',
        'filesource',
        'generated',
        'ignore',
        'inheritDoc',
        'internal',
        'link',
        'method',
        'package',
        'param',
        'property',
        'property-read',
        'property-write',
        'return',
        'see',
        'since',
        'throws',
        'todo',
        'uses',
        // used-by should be generated, not added manually
        'var',
        'version',
        // unofficial tags (non-PHPDoc or PSR-19)
        // phpstan
        'extends',
        'implements',
        'phpstan-ignore-next-line',
        'phpstan-type',
        'template',
        // ide (PhpStorm)
        'noinspection',
        'mixin',
        // php mess detector
        'SuppressWarnings',
        // phpunit code coverage
        'codeCoverageIgnore',
    ];

    public const ERROR_MESSAGE = 'Unknown tag %s in PHPDoc.';

    public function getNodeType(): string
    {
        return Node::class;
    }

    /**
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $docComment = $node->getDocComment();

        if ($docComment === null || !self::isInstanceOfClasses($node, [
                'PhpParser\Node\Stmt\ClassLike',
                'PhpParser\Node\Stmt\Function_',
                'PhpParser\Node\Stmt\ClassMethod'
            ])) {

            return [];
        }

        return array_values(array_filter(array_map(
            static fn (string $tag): ?RuleError => !in_array($tag, self::KNOWN_TAGS, true)
                ? ErrorFormatter::format(self::ERROR_MESSAGE, "@$tag")
                : null,
            $this->getTags($docComment))));
    }

    /**
     * @return array<string>
     */
    public function getTags(Doc $docComment): array
    {
        return array_map(
            static fn (Tag $tag): string => $tag->getName(),
            DocBlockFactory::createInstance()->create($docComment->getText())->getTags()
        );
    }
}
