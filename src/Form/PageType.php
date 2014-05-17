<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 19/04/14
 * Time: 23:29
 */

namespace Chula\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slug')
            ->add('content', 'textarea');
    }

    public function getName()
    {
        return 'page';
    }
}
