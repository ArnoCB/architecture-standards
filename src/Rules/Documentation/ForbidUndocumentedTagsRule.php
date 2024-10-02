<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Documentation;

use ArchitectureStandards\Rules\AbstractBaseRule;
use ArchitectureStandards\Traits\WithClassTypeChecks;
use Closure;
use phpDocumentor\Reflection\DocBlock\Tag;
use phpDocumentor\Reflection\DocBlockFactory;
use PhpParser\Comment\Doc;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleError;

class ForbidUndocumentedTagsRule extends AbstractBaseRule
{
    /**
     * This is a list of known PHPDoc tags from PSR-19, the PHPDoc reference and some unofficial tags.
     *
     * @var array<int<0, max>, string>
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
        'phpstan-param',
        'phpstan-return',
        'phpstan-template',
        'phpstan-type',
        'psalm-return',
        'template',
        // ide (PhpStorm)
        'noinspection',
        'mixin',
        // php mess detector
        'SuppressWarnings',
        // phpunit code coverage
        'codeCoverageIgnore',
    ];

    use WithClassTypeChecks;

    public const ERROR_MESSAGE = 'Unknown tag %s in PHPDoc.';

    public function getNodeType(): string
    {
        return Node::class;
    }

    /**
     * @return array<RuleError>
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) $scope
     *
     * @todo make separate Rules for all visitors, since not all phpdoc tags are allowed at each
     *       node type anyway.
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $docComment = $node->getDocComment();

        if ($docComment === null || !$this->isInstanceOfClasses(
            $node,
            [
                'PhpParser\Node\Stmt\ClassLike',
                'PhpParser\Node\Stmt\Function_',
                'PhpParser\Node\Stmt\ClassMethod'
            ]
        )
        ) {
            return [];
        }

        $tagErrorArray = array_map($this->giveErrorIfUnknownTagClosure(), $this->getTags($docComment));

        return array_values(array_filter($tagErrorArray));
    }

    /**
     * @return array<int<0, max>, string>
     */
    private function getTags(Doc $docComment): array
    {
        return array_map(
            static fn (Tag $tag): string => $tag->getName(),
            DocBlockFactory::createInstance()->create($docComment->getText())->getTags()
        );
    }

    /**
     * @return Closure
     */
    private function giveErrorIfUnknownTagClosure(): Closure
    {
        return fn (string $tag): ?RuleError => !in_array($tag, self::KNOWN_TAGS, true)
            ? $this->formattedError("@$tag")
            : null;
    }
}
