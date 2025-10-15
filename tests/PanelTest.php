<?php

namespace BeastBytes\Yii\Tracy\Panel\Assets\Tests;

use BeastBytes\Yii\Tracy\ContainerProxy;
use BeastBytes\Yii\Tracy\Panel\Assets\Panel;
use BeastBytes\Yii\Tracy\Panel\Assets\Tests\Support\assetBundles\FirstAsset;
use BeastBytes\Yii\Tracy\Panel\Assets\Tests\Support\assetBundles\SecondAsset;
use BeastBytes\Yii\Tracy\Panel\Assets\Tests\Support\assetBundles\ThirdAsset;
use PHPUnit\Framework\Attributes\After;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Assets\AssetLoader;
use Yiisoft\Assets\AssetLoaderInterface;
use Yiisoft\Assets\Debug\AssetCollector;
use Yiisoft\Assets\Debug\AssetLoaderInterfaceProxy;
use Yiisoft\Strings\Inflector;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Translator\IntlMessageFormatter;
use Yiisoft\Translator\CategorySource;
use Yiisoft\Translator\Message\Php\MessageSource;
use Yiisoft\Translator\Translator;
use Yiisoft\View\View;
use Yiisoft\View\WebView;

class PanelTest extends TestCase
{
    private const COLOUR_NO_ASSETS = '#404040';
    private const COLOUR_ASSETS = '#0fbfb3';
    private const PANEL = <<<HTML
<h1>Assets</h1>
<div class="tracy-inner"><div class="tracy-inner-container">
<table>
    <thead>
        <tr>
            <th>Base Path</th>
            <th>Base URL</th>
            <th>Source Path</th>
            <th>CDN</th>
            <th>Depends</th>
            <th>CSS Files</th>
            <th>CSS Strings</th>
            <th>CSS Options</th>
            <th>CSS Position</th>
            <th>JS Files</th>
            <th>JS Strings</th>
            <th>JS Vars</th>
            <th>JS Options</th>
            <th>JS Position</th>
            <th>Export</th>
            <th>Converter Options</th>
            <th>Publish Options</th>
        </tr>
    </thead>
    <tbody>{body}</tbody>
</table>
</div></div>
HTML;
    private const TAB = <<<TAB
<span title="Assets"><svg
    xmlns="http://www.w3.org/2000/svg"
    height="24px"
    viewBox="0 -960 960 960"
    width="24px"
    fill="{iconColour}"
>
    <path 
        d="M440-183v-274L200-596v274l240 139Zm80 0 240-139v-274L520-457v274Zm-40-343 237-137-237-137-237 137 237 
        137ZM160-252q-19-11-29.5-29T120-321v-318q0-22 10.5-40t29.5-29l280-161q19-11 40-11t40 11l280 161q19 11 29.5 
        29t10.5 40v318q0 22-10.5 40T800-252L520-91q-19 11-40 11t-40-11L160-252Zm320-228Z"
    />
</svg><span class="tracy-label">{assetCount}&nbsp;Asset{plural}</span></span>
TAB;

    private const LOCALE = 'en-GB';

    private static Aliases $aliases;
    private static AssetCollector $collector;
    private static ContainerInterface $container;
    private static ContainerInterface $containerProxy;

    private ?Panel $panel = null;

    #[After]
    public function tearDown(): void
    {
        $this->panel->shutdown();
    }

    #[Before]
    public function setUp(): void
    {
        self::$aliases = new Aliases([
            '@root' => __DIR__,
            '@assets' => '@support/published',
            '@resources' => '@support/resources',
            '@support' => '@root/Support',
        ]);

        self::$collector = new AssetCollector();
        self::$container = new SimpleContainer([
            AssetLoaderInterface::class => new AssetLoader(self::$aliases),
                View::class => (new View())
                ->setParameter(
                    'translator',
                    (new Translator())
                        ->withLocale(self::LOCALE)
                        ->addCategorySources(new CategorySource(
                            Panel::MESSAGE_CATEGORY,
                            new MessageSource(
                                dirname(__DIR__)
                                . DIRECTORY_SEPARATOR . 'resources'
                                . DIRECTORY_SEPARATOR . 'messages',
                            ),
                            new IntlMessageFormatter(),
                        )),
                )
            ,
        ]);

        $this->panel = (new Panel(
            self::$collector,
            [
                AssetLoaderInterface::class => new AssetLoaderInterfaceProxy(
                    self::$container->get(AssetLoaderInterface::class),
                    self::$collector,
                ),
            ],
        ));

        self::$containerProxy = new ContainerProxy(self::$container);
        $this->panel = $this->panel->withContainer(self::$containerProxy);
        $this->panel->startup();
    }

    #[Test]
    public function viewPath(): void
    {
        $this->assertSame(
            dirname(__DIR__)
            . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR,
            $this->panel->getViewPath());
    }

    #[DataProvider('assetsProvider')]
    #[Test]
    public function assets(array $assets): void
    {
        foreach ($assets as $asset) {
            self::$containerProxy->get(AssetLoaderInterface::class)->loadBundle($asset);
        }

        $this->assertStringMatchesFormat(
            strtr(
                self::TAB,
                [
                    '{iconColour}' => (count($assets) === 0 ? self::COLOUR_NO_ASSETS : self::COLOUR_ASSETS),
                    '{plural}' => (count($assets) === 1 ? '' : 's'),
                    '{assetCount}' => count($assets),
                ],
            ),
            $this->panel->getTab(),
        );

        $this->assertSame(
            $this->stripWhitespace(strtr(
                self::PANEL,
                [
                    '{body}' => $this->getPanelBody($assets),
                ],
            )),
            $this->stripWhitespace($this->panel->getPanel()),
        );
    }

    public static function assetsProvider(): array
    {
        return [
            'No Assets' => [
                'assets' => [],
            ],
            'One Assets' => [
                'assets' => [
                    FirstAsset::class,
                ],
            ],
            'Two Assets' => [
                'assets' => [
                    FirstAsset::class,
                    SecondAsset::class,
                ],
            ],
            'Three Assets' => [
                'params' => [
                    FirstAsset::class,
                    SecondAsset::class,
                    ThirdAsset::class,
                ],
            ],
        ];
    }

    private function array2String(?array $arguments): string
    {
        if (empty($arguments)) {
            return '';
        }

        $result = [];
        foreach ($arguments as $key => $value) {
            $result[] = is_int($key)
                ? $value
                : sprintf('%s&nbsp;=&nbsp;%s', $key, $value)
            ;
        }

        return '<ul><li>' . implode('</li><li>', $result) . '</li></ul>';
    }

    private function getPanelBody(array $assets): string
    {
        if (empty($assets)) {
            return '<tr><td colspan="16">0&nbsp;Assets</td></tr>';
        }

        $result = [];
        foreach ($assets as $asset) {
            $asset = $asset::instantiate($asset);

            $result[] = strtr(
                '<tr>'
                . '<td>{basePath}</td>'
                . '<td>{baseUrl}</td>'
                . '<td>{sourcePath}</td>'
                . '<td>{cdn}</td>'
                . '<td>{depends}</td>'
                . '<td>{css}</td>'
                . '<td>{cssStrings}</td>'
                . '<td>{cssOptions}</td>'
                . '<td>{cssPosition}</td>'
                . '<td>{js}</td>'
                . '<td>{jsStrings}</td>'
                . '<td>{jsVars}</td>'
                . '<td>{jsOptions}</td>'
                . '<td>{jsPosition}</td>'
                . '<td>{export}</td>'
                . '<td>{converterOptions}</td>'
                . '<td>{publishOptions}</td>'
                . '</tr>',
                [
                    '{basePath}' => $asset->basePath === null ? '' : self::$aliases->get($asset->basePath),
                    '{baseUrl}' => $asset->baseUrl === null ? '' : self::$aliases->get($asset->baseUrl),
                    '{sourcePath}' => $asset->sourcePath === null ? '' : self::$aliases->get($asset->sourcePath),
                    '{cdn}' => ($asset->cdn ? 'true' : 'false'),
                    '{depends}' => $this->array2String($asset->depends),
                    '{css}' => $this->array2String($asset->css),
                    '{cssStrings}' => $this->array2String($asset->cssStrings),
                    '{cssOptions}' => $this->array2String($asset->cssOptions),
                    '{cssPosition}' => match ($asset->cssPosition) {
                        WebView::POSITION_BEGIN => 'Begin',
                        WebView::POSITION_END => 'End',
                        WebView::POSITION_HEAD, null => 'Head',
                    },
                    '{js}' => $this->array2String($asset->js),
                    '{jsStrings}' => $this->array2String($asset->jsStrings),
                    '{jsVars}' => $this->array2String($asset->jsVars),
                    '{jsOptions}' => $this->array2String($asset->jsOptions),
                    '{jsPosition}' => match ($asset->jsPosition) {
                        WebView::POSITION_BEGIN => 'Begin',
                        WebView::POSITION_END, null => 'End',
                        WebView::POSITION_HEAD => 'Head',
                        WebView::POSITION_LOAD => 'Load',
                        WebView::POSITION_READY => 'Ready',
                    },
                    '{export}' => $this->array2String($asset->export),
                    '{converterOptions}' => $this->converterOptions($asset->converterOptions),
                    '{publishOptions}' => $this->array2String($asset->publishOptions),
                ],
            );
        }
        return implode('', $result);
    }

    private function converterOptions($converterOptions): string
    {
        if (empty($converterOptions)) {
            return '';
        }

        $result = [];
        foreach ($converterOptions as $converter => $options) {
            if ($options !== null) {
                $result[] = $converter;
            }
        }

        if (empty($result)) {
            return '';
        }

        return '<ul><li>' . implode('</li><li>', $result) . '</li></ul>';
    }

    private function stripWhitespace(string $string): string
    {
        return preg_replace('/>\s+</', '><', $string);
    }
}