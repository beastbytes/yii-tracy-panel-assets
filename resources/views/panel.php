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
    <?php if (empty($bundles)): ?>
        <tr>
            <td colspan="16"><?= $translator->translate('assets.bundles', ['total' => 0]) ?></td>
        </tr>
    <?php else: ?>
    <?php foreach ($bundles as $bundle): ?>
        <tr>
            <td><?= $bundle->basePath ?></td>
            <td><?= $bundle->baseUrl ?></td>
            <td><?= $bundle->sourcePath ?></td>
            <td><?= ($bundle->cdn ? 'true' : 'false') ?></td>
            <td>
                <?php if (!empty($bundle->depends)): ?>
                <ul>
                    <?php foreach ($bundle->depends as $dependency): ?>
                        <?= "<li>$dependency</li>" ?>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </td>
            <td>
                <?php if (!empty($bundle->css)): ?>
                <ul>
                    <?php foreach ($bundle->css as $css): ?>
                        <?= "<li>$css</li>" ?>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </td>
            <td>
                <?php if (!empty($bundle->cssStrings)): ?>
                <ul>
                    <?php foreach ($bundle->cssStrings as $cssString): ?>
                        <?= "<li>$cssString</li>" ?>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </td>
            <td>
                <?php if (!empty($bundle->cssOptions)): ?>
                <ul>
                    <?php foreach ($bundle->cssOptions as $cssOption): ?>
                        <?= "<li>$cssOption</li>" ?>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </td>
            <td><?= match ($bundle->cssPosition) {
                    WebView::POSITION_BEGIN => $translator->translate('assets.value.begin'),
                    WebView::POSITION_END => $translator->translate('assets.value.end'),
                    WebView::POSITION_HEAD, null => $translator->translate('assets.value.head'),
                } ?></td>
            <td>
                <?php if (!empty($bundle->js)): ?>
                <ul>
                    <?php foreach ($bundle->js as $js): ?>
                        <?= "<li>$js</li>" ?>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </td>
            <td>
                <?php if (!empty($bundle->jsStrings)): ?>
                <ul>
                    <?php foreach ($bundle->jsStrings as $jsString): ?>
                        <?= "<li>$jsString</li>" ?>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </td>
            <td>
                <?php if (!empty($bundle->jsVars)): ?>
                <ul>
                    <?php foreach ($bundle->jsVars as $jsVar): ?>
                        <?= "<li>$jsVar</li>" ?>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </td>
            <td>
                <?php if (!empty($bundle->jsOptions)): ?>
                <ul>
                    <?php foreach ($bundle->jsOptions as $jsOption): ?>
                        <?= "<li>$jsOption</li>" ?>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </td>
            <td><?= match ($bundle->jsPosition) {
                    WebView::POSITION_BEGIN => $translator->translate('assets.value.begin'),
                    WebView::POSITION_END, null => $translator->translate('assets.value.end'),
                    WebView::POSITION_HEAD => $translator->translate('assets.value.head'),
                    WebView::POSITION_LOAD => $translator->translate('assets.value.load'),
                    WebView::POSITION_READY => $translator->translate('assets.value.ready'),
                } ?></td>
            <td>
                <?php if (!empty($bundle->export)): ?>
                <ul>
                    <?php foreach ($bundle->export as $export): ?>
                    <?= "<li>$export</li>" ?>
                <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </td>
            <td>
                <?php if (!empty($bundle->converterOptions)):
                    $converterOptions = array_filter($bundle->converterOptions, fn($item) => $item !== null);
                    if (!empty($converterOptions)): ?>
                    <ul>
                        <?php foreach ($converterOptions as $converter => $option): ?>
                            <?= $option !== null ? "<li>$converter</li>" : '' ?>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                <?php endif; ?>
            </td>
            <td>
                <?php if (!empty($bundle->publishOptions)): ?>
                <ul>
                    <?php foreach ($bundle->publishOptions as $name => $option): ?>
                        <?= $option !== null && $option !== false ? "<li>$name</li>" : '' ?>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>