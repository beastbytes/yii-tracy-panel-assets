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
        d="M80-160v-160h160v160H80Zm240 0v-160h560v160H320ZM80-400v-160h160v160H80Zm240 
            0v-160h560v160H320ZM80-640v-160h160v160H80Zm240 0v-160h560v160H320Z"
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