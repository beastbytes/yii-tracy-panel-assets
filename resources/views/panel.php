<?php

use Yiisoft\Assets\AssetBundle;
use Yiisoft\View\WebView;

/**
 * @var list<AssetBundle> $bundles
 */
?>

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
                    WebView::POSITION_HEAD => 'Head',
                    WebView::POSITION_BEGIN => 'Begin',
                    WebView::POSITION_END => 'End',
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
                    WebView::POSITION_HEAD => 'Head',
                    WebView::POSITION_BEGIN => 'Begin',
                    WebView::POSITION_END => 'End',
                    WebView::POSITION_READY => 'Ready',
                    WebView::POSITION_LOAD => 'Load',
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