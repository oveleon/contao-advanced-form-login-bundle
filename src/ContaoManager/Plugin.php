<?php

declare(strict_types=1);

/*
 * This file is part of Oveleon AdvancedFormLoginBundle.
 *
 * (c) https://www.oveleon.de/
 */

namespace Oveleon\ContaoAdvancedFormLoginBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Oveleon\ContaoAdvancedFormLoginBundle\ContaoAdvancedFormLoginBundle;
use Oveleon\ContaoAdvancedFormBundle\ContaoAdvancedFormBundle;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(ContaoAdvancedFormLoginBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class, ContaoAdvancedFormBundle::class])
                ->setReplace(['advanced-form-login']),
        ];
    }
}
