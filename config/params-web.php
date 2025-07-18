<?php

declare(strict_types=1);

use BeastBytes\Yii\Tracy\Panel\Assets\Panel as AssetsPanel;
use Yiisoft\Assets\AssetLoaderInterface;
use Yiisoft\Assets\Debug\AssetCollector;
use Yiisoft\Assets\Debug\AssetLoaderInterfaceProxy;
use Yiisoft\Definitions\Reference;

return [
    'beastbytes/yii-tracy' => [
        'panelConfig' => [
            'assets' => [
                'class' => AssetsPanel::class,
                '__construct()' => [
                    Reference::to(AssetCollector::class),
                    [
                        AssetLoaderInterface::class => Reference::to(AssetLoaderInterfaceProxy::class),
                    ],
                ],
            ],
        ],
    ],
];
