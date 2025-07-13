<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Panel\Assets\Tests\Support\assetBundles;

use BeastBytes\Yii\Tracy\Panel\Assets\Tests\Support\TestAsset;

class ThirdAsset extends TestAsset
{
    public ?string $sourcePath = '@resources/assets';

    public array $css = [
        'third/css.css',
    ];

    public array $js = [
        'third/js.js',
    ];

    public array $depends = [
        FirstAsset::class,
        SecondAsset::class,
    ];
}