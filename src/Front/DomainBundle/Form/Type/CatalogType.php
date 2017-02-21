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
                "label"     => "front.domain.catalog.title",
                "translation_domain"    => "Front"
            ))
            ->add("imageFile", VichImageType::class, array(
                "label"     => "front.domain.catalog.image",
                "translation_domain"    => "Front",
                "attr"      => array('accept' => 'image/jpeg,image/png'),
                "required"  => false
            ))
            ->add("fileNameShown", TextType::class, array(
                "label"     => "front.domain.catalog.filename",
                "translation_domain"    => "Front"
            ))
            ->add("file", VichFileType::class, array(
                "label"     => "front.domain.catalog.file",
                "translation_domain"    => "Front",
                "required"  => false
            ))
            ->add("beginPublicationDate", DateType::class, array(
                "label"     => "front.domain.catalog.begin_publication",
                "translation_domain"    => "Front",
                "widget"    => "single_text",
                'format'    => 'dd-MM-yyyy',
                'placeholder' => 'jj-mm-yyyy'
            ))
            ->add("isPositionLeft", CheckboxType::class, array(
                "label"     => "front.domain.catalog.is_position_left",
                "translation_domain" => "Front",
                "required"  => false,
                "attr"      => array('class' => 'datepicker',
                            'data-toggle'   => 'toggle',
                            'data-off'      => 'Droite',
                            'data-on'       => 'Gauche')
            ))
            ->add("visible", CheckboxType::class, array(
                "label"     => "front.domain.catalog.active",
                "translation_domain"    => "Front",
                "required"  => false,
                "attr"      => array("class" => "datepicker",
                                "data-toggle"   => "toggle",
                                "data-off"      => "Caché",
                                "data-on"       => "Visible")
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Front\DomainBundle\Entity\Catalog'));
    }
}
