<?php
/**
 * @var array $bundles
 * @psalm-var array{
 *     total: int
 * } $bundles
 * @var TranslatorInterface $translator
*/

use Yiisoft\Translator\TranslatorInterface;

$translator = $translator->withDefaultCategory('tracy-assets');

echo $translator->translate('assets.bundles', ['total' => $bundles['total']]);