<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Documentation;

use ArchitectureStandards\Helpers\ErrorFormatter;
use phpDocumentor\Reflection\DocBlock\Tag;
use phpDocumentor\Reflection\DocBlockFactory;
use PhpParser\Comment\Doc;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\ShouldNotHappenException;

/**
 * @implements Rule<Node>
 */
class ForbidUndocumentedTagsRule implements Rule
{
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

        if ($docComment === null
            || (!$node instanceof Node\Stmt\ClassLike
                && !$node instanceof Node\Stmt\Function_
                && !$node instanceof Node\Stmt\ClassMethod))
        {
            return [];
        }

        $messages = [];

        $tagNames = $this->getTags($docComment);

        foreach ($tagNames as $tag) {
            if (!in_array($tag, self::KNOWN_TAGS, true)) {
                $messages[] = ErrorFormatter::format(self::ERROR_MESSAGE, "@$tag");
            }
        }

        return $messages;
    }

    /**
     * @return array<string>
     */
    public function getTags(Doc $docComment): array
    {
        $docBlockFactory = DocBlockFactory::createInstance();
        $tags = $docBlockFactory->create($docComment->getText())->getTags();
        return array_map(static fn (Tag $tag) => $tag->getName(), $tags);
    }
}
