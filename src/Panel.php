<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Panel\Assets;

use BeastBytes\Yii\Tracy\Panel\ProxyCollectorPanel;
use BeastBytes\Yii\Tracy\ViewTrait;

final class Panel extends ProxyCollectorPanel
{
    use ViewTrait;

    private const BINARY_COLUMN = 'binary';

    private const COLOUR_NO_ASSETS = '#404040';
    private const COLOUR_ASSETS = '#0fbfb3';

    private const ICON = <<<ICON
<svg
    xmlns="http://www.w3.org/2000/svg"
    height="24px"
    viewBox="0 -960 960 960"
    width="24px"
    fill="%s"
>
    <path 
        d="M440-183v-274L200-596v274l240 139Zm80 0 240-139v-274L520-457v274Zm-40-343 237-137-237-137-237 137 237 
            137ZM160-252q-19-11-29.5-29T120-321v-318q0-22 10.5-40t29.5-29l280-161q19-11 40-11t40 11l280 161q19 11 29.5 
            29t10.5 40v318q0 22-10.5 40T800-252L520-91q-19 11-40 11t-40-11L160-252Zm320-228Z"
    />
</svg>
ICON;

    private const TITLE = 'Assets';

    private array $tableSchemas = [];

    protected function panelParameters(): array
    {
        return ['bundles' => $this->getCollected()];
    }

    protected function panelTitle(): string
    {
        return self::TITLE;
    }

    protected function tabIcon(array $parameters): string
    {
        return sprintf(
            self::ICON,
            $this->getSummary()['bundles']['total'] > 0 ? self::COLOUR_ASSETS : self::COLOUR_NO_ASSETS,
        );
    }

    protected function tabParameters(): array
    {
        return $this->getSummary();
    }

    protected function tabTitle(): string
    {
        return self::TITLE;
    }
}