<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 10/01/2017
 * Time: 11:05
 */

namespace Admin\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("name", TextType::class, array(
                "label"     => "Nom de l'application"
            ))
            ->add("location", TextType::class, array(
                "label"     => "Route de l'application"
            ))
            ->add("imageFile", VichImageType::class, array(
                "label" => "Image de l'application",
                "required" => false)
            )
            ->add("description", TextareaType::class, array(
                "label" => "Description"
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array("data_class" => 'Front\AppBundle\Entity\Application'));
    }
}
