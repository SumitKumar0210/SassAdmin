<?php

use Spatie\ImageOptimizer\Optimizers\Cwebp;
use Spatie\ImageOptimizer\Optimizers\Gifsicle;
use Spatie\ImageOptimizer\Optimizers\Jpegoptim;
use Spatie\ImageOptimizer\Optimizers\Optipng;
use Spatie\ImageOptimizer\Optimizers\Pngquant;
use Spatie\ImageOptimizer\Optimizers\Svgo;

return [

    'optimizers' => [
        Spatie\ImageOptimizer\Optimizers\Jpegoptim::class => [
            '--strip-all',
            '--max=75', // default jpeg quality (0-100)
            '--all-progressive',
        ],

        Spatie\ImageOptimizer\Optimizers\Pngquant::class => [
            '--quality=60-80',
            '--speed=3',
        ],

        Spatie\ImageOptimizer\Optimizers\Optipng::class => [
            '-i0', '-o2', '-quiet',
        ],

        Spatie\ImageOptimizer\Optimizers\Gifsicle::class => [
            '-b', '-O3',
        ],

        Spatie\ImageOptimizer\Optimizers\Cwebp::class => [
            '-m 6', '-pass 10', '-mt', '-q 75',
        ],
    ],

    'timeout' => 60,
    'log_optimizer_activity' => false,
];

