<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Panel\Assets\Tests\Support;

use Yiisoft\Assets\AssetBundle;

class TestAsset extends AssetBundle
{
    public static function instantiate(string $asset): self
    {
        return new $asset;
    }
}