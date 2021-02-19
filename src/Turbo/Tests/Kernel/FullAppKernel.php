<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\UX\Turbo\Tests\Kernel;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\UX\Turbo\TurboBundle;
use Symfony\WebpackEncoreBundle\WebpackEncoreBundle;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @internal
 */
class FullAppKernel extends Kernel
{
    use AppKernelTrait;

    public function registerBundles()
    {
        return [new FrameworkBundle(), new WebpackEncoreBundle(), new TwigBundle(), new TurboBundle()];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(function (ContainerBuilder $container) {
            $container->loadFromExtension('framework', ['secret' => '$ecret', 'test' => true]);
            $container->loadFromExtension('twig', ['default_path' => __DIR__.'/templates', 'strict_variables' => true, 'exception_controller' => null]);
            $container->loadFromExtension('webpack_encore', ['output_path' => '%kernel.project_dir%/public/build']);

            $container->loadFromExtension('turbo', [
                'streams' => [
                    'adapter' => 'turbo.streams.adapter.mercure',
                    'options' => ['hub' => 'http://localhost/.well-know/mecure'],
                ],
            ]);
        });
    }
}
