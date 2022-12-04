<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__.'/');

$config = new PhpCsFixer\Config();
return $config
    ->setRules([
        '@PSR12' => true,
        'new_with_braces' => false,
        'array_indentation' => true,
        'array_syntax' => ['syntax' => 'short'],
        'combine_consecutive_unsets' => true,
        'multiline_whitespace_before_semicolons' => true,
        'single_quote' => true,
        'blank_line_before_statement' => true,
        'braces' => [
            'allow_single_line_closure' => true,
        ],
        'declare_equal_normalize' => true,
        'function_typehint_space' => true,
        'include' => true,
        'lowercase_cast' => true,
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_spaces_around_offset' => true,
        'no_unused_imports' => true,
        'no_whitespace_before_comma_in_array' => true,
        'no_whitespace_in_blank_line' => true,
        'object_operator_without_whitespace' => true,
        'single_blank_line_before_namespace' => true,
        'ternary_operator_spaces' => true,
        'trailing_comma_in_multiline' => true,
        'trim_array_spaces' => true,
        'unary_operator_spaces' => true,
        'binary_operator_spaces' => true,
        'whitespace_after_comma_in_array' => true,
        'single_trait_insert_per_statement' => false,
        'phpdoc_align' => ['align' => 'vertical'],
        'phpdoc_indent' => true,
        'phpdoc_no_access' => true,
        'phpdoc_no_package' => true,
        'phpdoc_no_useless_inheritdoc' => true,
        'phpdoc_order' => true,
        'phpdoc_scalar' => true,
        'phpdoc_separation' => true,
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_summary' => true,
        'phpdoc_to_comment' => true,
        'phpdoc_trim' => true,
        'phpdoc_types' => true,
        'phpdoc_var_without_name' => true,
    ])
    ->setLineEnding("\n")
    ->setCacheFile(__DIR__.'\.php-cs-fixer.cache')
    ->setFinder($finder);