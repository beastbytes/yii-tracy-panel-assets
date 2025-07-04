<?php
/**
 * @var array $bundles
 * @psalm-var array{
 *     total: int
 * } $bundles
 * @var TranslatorInterface $translator
*/

use BeastBytes\Yii\Tracy\Panel\Assets\Panel;
use Yiisoft\Translator\TranslatorInterface;

$translator = $translator->withDefaultCategory(Panel::MESSAGE_CATEGORY);

echo $translator->translate('assets.bundles', ['total' => $bundles['total']]);