<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Panel\Assets\Tests\Support\assetBundles;

use BeastBytes\Yii\Tracy\Panel\Assets\Tests\Support\TestAsset;

class SecondAsset extends TestAsset
{
    public ?string $sourcePath = '@resources/assets';

    public array $css = [
        'second/css.css',
    ];

    public array $js = [
        'second/js.js',
    ];

    public array $depends = [
        FirstAsset::class
    ];
}