<?php
/**
 * @author Andrey Vinichenko <andrey.vinichenko@gmail.com>
 */

use Contao\EasyCodingStandard\Fixer\MultiLineLambdaFunctionArgumentsFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoSpacesAfterFunctionNameFixer;
use PhpCsFixer\Fixer\FunctionNotation\VoidReturnFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use PhpCsFixer\Fixer\Operator\IncrementStyleFixer;
use PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocOrderFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocScalarFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSeparationFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSummaryFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocToCommentFixer;
use PhpCsFixer\Fixer\ReturnNotation\ReturnAssignmentFixer;
use PhpCsFixer\Fixer\Semicolon\MultilineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Strict\StrictComparisonFixer;
use PhpCsFixer\Fixer\Strict\StrictParamFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use PhpCsFixer\Fixer\Whitespace\MethodChainingIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\NoExtraBlankLinesFixer;
use SlevomatCodingStandard\Sniffs\PHP\UselessParenthesesSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\DisallowArrayTypeHintSyntaxSniff;
use SlevomatCodingStandard\Sniffs\Variables\UnusedVariableSniff;
use SlevomatCodingStandard\Sniffs\Variables\UselessVariableSniff;
use SlevomatCodingStandard\Sniffs\Whitespaces\DuplicateSpacesSniff;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__ . '/vendor/contao/easy-coding-standard/config/default.php');

    $services = $containerConfigurator->services();

    $services
        ->set(HeaderCommentFixer::class)
        ->call('configure', [[
            'header' => '@author Andrey Vinichenko <andrey.vinichenko@gmail.com>',
            'comment_type' => 'PHPDoc'
        ]])
    ;

    $services
        ->set(ConcatSpaceFixer::class)
        ->call('configure', [[
            'spacing' => 'one'
        ]])
    ;

    $services
        ->set(NoExtraBlankLinesFixer::class)
        ->call('configure', [[
            // Remove "throw"
            'tokens' => ['curly_brace_block', 'extra', 'parenthesis_brace_block', 'square_brace_block', 'use'],
        ]])
    ;

    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::SKIP, [
        BinaryOperatorSpacesFixer::class => null,
        DeclareStrictTypesFixer::class => null,
        DisallowArrayTypeHintSyntaxSniff::class => null,
        DuplicateSpacesSniff::class => null,
        IncrementStyleFixer::class => null,
        MethodChainingIndentationFixer::class => null,
        MultiLineLambdaFunctionArgumentsFixer::class => null,
        MultilineWhitespaceBeforeSemicolonsFixer::class => null,
        NoSpacesAfterFunctionNameFixer::class => null,
        NoSuperfluousPhpdocTagsFixer::class => null,
        OrderedClassElementsFixer::class => null,
        PhpdocOrderFixer::class => null,
        PhpdocScalarFixer::class => null,
        PhpdocSeparationFixer::class => null,
        PhpdocSummaryFixer::class => null,
        PhpdocToCommentFixer::class => null,
        ReturnAssignmentFixer::class => null,
        SingleQuoteFixer::class => null,
        StrictComparisonFixer::class => null,
        StrictParamFixer::class => null,
        TrailingCommaInMultilineFixer::class => null,
        UnusedVariableSniff::class => null,
        UselessParenthesesSniff::class => null,
        UselessVariableSniff::class => null,
        VisibilityRequiredFixer::class => null,
        VoidReturnFixer::class => null,
        YodaStyleFixer::class => null,
    ]);
};
