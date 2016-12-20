<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 20/12/2016
 * Time: 14:58
 */

namespace Front\DomainBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CatalogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("title", TextType::class, array(
                "label"     => "Titre"
            ))
            ->add("imageFile", VichImageType::class, array(
                "label"     => "Image",
                "attr"      => array('accept' => 'image/jpeg,image/png'),
                "required"  => false
            ))
            ->add("fileNameShown", TextType::class, array(
                "label"     => "Nom du fichier téléchargé"
            ))
            ->add("file", VichFileType::class, array(
                "label"     => "Fichier",
                "required"  => false
            ))
            ->add("beginPublicationDate", DateType::class, array(
                "label"     => "Début de publication",
                "widget"    => "single_text",
                'format'    => 'dd-MM-yyyy',
                'placeholder' => 'jj-mm-yyyy'
            ))
            ->add("isPositionLeft", CheckboxType::class, array(
                "label"     => " ",
                "required"  => false
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Front\DomainBundle\Entity\Catalog'));
    }
}