<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 29/11/2016
 * Time: 18:05
 */

namespace Front\DomainBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,
                array("label" => "front.domain.news_file.title",
                    "translation_domain"    => "Front"))
            ->add('file', FileType::class,
                array("required" => false,
                    "label" => "front.domain.news_file.document",
                    "translation_domain"    => "Front"));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Front\DomainBundle\Entity\NewsFile'
        ));
    }

}
