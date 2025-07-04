<?php

/**
 * @var list<AssetBundle> $bundles
 * @var TranslatorInterface $translator
 */

use BeastBytes\Yii\Tracy\Panel\Assets\Panel;
use Yiisoft\Assets\AssetBundle;
use Yiisoft\View\WebView;
use Yiisoft\Translator\TranslatorInterface;

$translator = $translator->withDefaultCategory(Panel::MESSAGE_CATEGORY);
?>

<table>
    <thead>
        <tr>
            <th><?= $translator->translate('assets.header.base-path') ?></th>
            <th><?= $translator->translate('assets.header.base-url') ?></th>
            <th><?= $translator->translate('assets.header.source-path') ?></th>
            <th><?= $translator->translate('assets.header.cdn') ?></th>
            <th><?= $translator->translate('assets.header.depends') ?></th>
            <th><?= $translator->translate('assets.header.css-files') ?></th>
            <th><?= $translator->translate('assets.header.css-strings') ?></th>
            <th><?= $translator->translate('assets.header.css-options') ?></th>
            <th><?= $translator->translate('assets.header.css-position') ?></th>
            <th><?= $translator->translate('assets.header.js-files') ?></th>
            <th><?= $translator->translate('assets.header.js-strings') ?></th>
            <th><?= $translator->translate('assets.header.js-vars') ?></th>
            <th><?= $translator->translate('assets.header.js-options') ?></th>
            <th><?= $translator->translate('assets.header.js-position') ?></th>
            <th><?= $translator->translate('assets.header.export') ?></th>
            <th><?= $translator->translate('assets.header.converter-options') ?></th>
            <th><?= $translator->translate('assets.header.publish-options') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($bundles as $bundle): ?>
        <tr>
            <td><?= $bundle['basePath'] ?></td>
            <td><?= $bundle['baseUrl'] ?></td>
            <td><?= $bundle['sourcePath'] ?></td>
            <td><?= ($bundle['cdn'] ? 'true' : 'false') ?></td>
            <td>
                <ul>
                    <?php foreach ($bundle['depends'] as $dependancy): ?>
                        <?= "<li>$dependancy</li>" ?>
                    <?php endforeach; ?>
                </ul>
            </td>
            <td>
                <ul>
                    <?php foreach ($bundle['css'] as $css): ?>
                        <?= "<li>$css</li>" ?>
                    <?php endforeach; ?>
                </ul>
            </td>
            <td>
                <ul>
                    <?php foreach ($bundle['cssStrings'] as $cssString): ?>
                        <?= "<li>$cssString</li>" ?>
                    <?php endforeach; ?>
                </ul>
            </td>
            <td>
                <ul>
                    <?php foreach ($bundle['cssOptions'] as $cssOption): ?>
                        <?= "<li>$cssOption</li>" ?>
                    <?php endforeach; ?>
                </ul>
            </td>
            <td>
                <?= match ($bundle['cssPosition']) {
                    WebView::POSITION_BEGIN => $translator->translate('assets.value.begin'),
                    WebView::POSITION_END => $translator->translate('assets.value.end'),
                    WebView::POSITION_HEAD => $translator->translate('assets.value.head'),
                } ?>
            </td>
            <td>
                <ul>
                    <?php foreach ($bundle['js'] as $js): ?>
                        <?= "<li>$js</li>" ?>
                    <?php endforeach; ?>
                </ul>
            </td>
            <td>
                <ul>
                    <?php foreach ($bundle['jsStrings'] as $jsString): ?>
                        <?= "<li>$jsString</li>" ?>
                    <?php endforeach; ?>
                </ul>
            </td>
            <td>
                <ul>
                    <?php foreach ($bundle['jsVars'] as $jsVar): ?>
                        <?= "<li>$jsVar</li>" ?>
                    <?php endforeach; ?>
                </ul>
            </td>
            <td>
                <ul>
                    <?php foreach ($bundle['jsOptions'] as $jsOption): ?>
                        <?= "<li>$jsOption</li>" ?>
                    <?php endforeach; ?>
                </ul>
            </td>
            <td>
                <?= match ($bundle['jsPosition']) {
                    WebView::POSITION_BEGIN => $translator->translate('assets.value.begin'),
                    WebView::POSITION_END => $translator->translate('assets.value.end'),
                    WebView::POSITION_HEAD => $translator->translate('assets.value.head'),
                    WebView::POSITION_LOAD => $translator->translate('assets.value.load'),
                    WebView::POSITION_READY => $translator->translate('assets.value.ready'),
                } ?>
            </td>
            <td>
                <ul>
                    <?php foreach ($bundle['export'] as $export): ?>
                    <?= "<li>$export</li>" ?>
                <?php endforeach; ?>
                </ul>
            </td>
            <td>
                <ul>
                    <?php foreach ($bundle['converterOptions'] as $name => $option): ?>
                        <?= $option !== null ? "<li>$name</li>" : '' ?>
                    <?php endforeach; ?>
                </ul>
            </td>
            <td>
                <ul>
                    <?php foreach ($bundle['publishOptions'] as $name => $option): ?>
                        <?= $option !== null && $option !== false ? "<li>$name</li>" : '' ?>
                    <?php endforeach; ?>
                </ul>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>