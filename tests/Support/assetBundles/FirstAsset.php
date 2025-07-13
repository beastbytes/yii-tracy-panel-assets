<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Panel\Assets\Tests\Support\assetBundles;

use BeastBytes\Yii\Tracy\Panel\Assets\Tests\Support\TestAsset;

class FirstAsset extends TestAsset
{
    public ?string $sourcePath = '@resources/assets';

    public array $css = [
        'first/css.css',
    ];

    public array $js = [
        'first/js.js',
    ];
}