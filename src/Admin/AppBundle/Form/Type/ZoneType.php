<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 10/01/2017
 * Time: 11:05
 */

namespace Admin\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ZoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("code", IntegerType::class, array(
                "label"     => "Code"
            ))
            ->add("name", TextType::class, array(
                "label"     => "Nom de l'agence"
            ))
            ->add("active", CheckboxType::class, array(
                "label"     => " ",
                "required"  => false,
                "attr"      => array('data-toggle'   => 'toggle',
                    'data-off'      => 'Inactive',
                    'data-on'       => 'Active')
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array("data_class" => 'Front\AppBundle\Entity\Zone'));
    }

}
