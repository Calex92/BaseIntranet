<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 22/12/2016
 * Time: 09:47
 */

namespace Front\DomainBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DomainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("label", TextType::class, array(
                "label"     => "Nom du domaine"
            ))
            ->add("active", CheckboxType::class, array(
                "label"     => " ",
                "required"  => false,
                "attr"      => array("data-toggle"   => "toggle",
                    "data-off"      => "Inactif",
                    "data-on"       => "Actif")
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            "data_class" => "Front\DomainBundle\Entity\Domain"
        ));
    }
}