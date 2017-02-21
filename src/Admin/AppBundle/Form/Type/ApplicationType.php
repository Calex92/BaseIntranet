<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 10/01/2017
 * Time: 11:05
 */

namespace Admin\AppBundle\Form\Type;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
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
                "label" => "admin.app.application.name",
                "translation_domain"     => "Admin"
            ))
            ->add("location", TextType::class, array(
                "label"     => "admin.app.application.route",
                "translation_domain"     => "Admin"
            ))
            ->add("imageFile", VichImageType::class, array(
                "label" => "admin.app.application.image",
                "translation_domain"     => "Admin",
                "required" => false)
            )
            ->add("description", CKEditorType::class, array(
                "label" => "admin.app.application.description",
                "translation_domain"     => "Admin",
                "config_name" => "my_basic_config"
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array("data_class" => 'Front\AppBundle\Entity\Application'));
    }
}
