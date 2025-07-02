<?php
/**
 * @var array $bundles
 * @psalm-var array{
 *     total: int
 * } $bundles
 */

echo sprintf('%d %s', $bundles['total'], $bundles['total'] === 1 ? 'bundle' : 'bundles');