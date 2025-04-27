<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__);

return (new PhpCsFixer\Config())
    ->setRules([
        'declare_strict_types' => true,
        '@PSR12' => true,
        '@PER-CS' => true,
        'array_syntax' => ['syntax' => 'short'],
        'binary_operator_spaces' => ['default' => 'align_single_space_minimal'],
        'blank_line_before_statement' => ['statements' => ['return']],
        'class_attributes_separation' => ['elements' => ['method' => 'one']],
        'concat_space' => ['spacing' => 'one'],
        'declare_equal_normalize' => ['space' => 'single'],
        'function_typehint_space' => true,
        'lowercase_cast' => true,
        'method_argument_space' => ['on_multiline' => 'ignore'],
        'no_extra_blank_lines' => ['tokens' => ['throw', 'use']],
        'no_trailing_comma_in_singleline_array' => true,
        'no_unused_imports' => true,
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'phpdoc_align' => ['align' => 'left'],
        'phpdoc_order' => true,
        'single_quote' => true,
        'ternary_operator_spaces' => true,
        'trim_array_spaces' => true,
        'unary_operator_spaces' => true,
        'whitespace_after_comma_in_array' => true,
    ])
    ->setFinder($finder);