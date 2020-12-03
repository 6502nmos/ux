<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Symfony\UX\Dropzone;

use PHPUnit\Framework\TestCase;
use Symfony\UX\Dropzone\Form\DropzoneType;
use Tests\Symfony\UX\Dropzone\Kernel\TwigAppKernel;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @internal
 */
class DropzoneTypeTest extends TestCase
{
    public function testRenderForm()
    {
        $kernel = new TwigAppKernel('test', true);
        $kernel->boot();

        $form = $kernel->getContainer()->get('form.factory')->createBuilder()
            ->add('photo', DropzoneType::class, ['attr' => ['data-controller' => 'mydropzone']])
            ->getForm()
        ;

        $rendered = $kernel->getContainer()->get('twig')->render('dropzone_form.html.twig', ['form' => $form->createView()]);

        $this->assertSame(
            '<form name="form" method="post" enctype="multipart/form-data"><div id="form"><div><label for="form_photo" class="required">Photo</label><div class="dropzone-container" data-controller="mydropzone @symfony/ux-dropzone/dropzone">
        <input type="file" id="form_photo" name="form[photo]" required="required" data-controller="" class="dropzone-input" data-target="@symfony/ux-dropzone/dropzone.input" />

        <div class="dropzone-placeholder" data-target="@symfony/ux-dropzone/dropzone.placeholder"></div>

        <div class="dropzone-preview" data-target="@symfony/ux-dropzone/dropzone.preview" style="display: none">
            <button class="dropzone-preview-button" type="button"
                    data-target="@symfony/ux-dropzone/dropzone.previewClearButton"></button>

            <div class="dropzone-preview-image" style="display: none"
                 data-target="@symfony/ux-dropzone/dropzone.previewImage"></div>

            <div data-target="@symfony/ux-dropzone/dropzone.previewFilename" class="dropzone-preview-filename"></div>
        </div>
    </div></div></div></form>
',
            $rendered
        );
    }
}