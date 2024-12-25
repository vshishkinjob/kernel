<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude([
        'ArtifactsGenerator',
        'build',
        'hooks',
        'OpenApi',
        'runtime',
        'scripts',
        'tests',
        'vendor'
    ]);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        '@PSR2' => true
    ])->setFinder($finder);