<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 20/12/2016
 * Time: 09:35
 */

namespace Front\DomainBundle\Form\Type;


use Front\DomainBundle\Repository\DomainRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options["user"];
        $builder->add('title', TextType::class,
                array("label"       => "front.domain.document.title",
                    "translation_domain"    => "Front"))
            ->add('domain', EntityType::class,
                array("class"       => "Front\\DomainBundle\\Entity\\Domain",
                    "choice_label"  => "label",
                    "choice_value"  => "id",
                    "label"         => "front.domain.document.domain",
                    "translation_domain"    => "Front",
                    "query_builder" => function (DomainRepository $repository) use ($user){
                        return $repository->getActiveQueryBuilderForUser($user);
                    },))
            ->add("fileNameShown", TextType::class,
                array("label"   => "front.domain.document.filename_shown",
                    "translation_domain"    => "Front"))
            ->add("file", VichFileType::class,
                array("label"   => "front.domain.document.file",
                    "translation_domain"    => "Front"))
            ->add('beginPublicationDate', DateType::class,
                array("label" => "front.domain.document.begin_publication",
                    "translation_domain"    => "Front",
                    "widget" => "single_text",
                    'format' => 'dd-MM-yyyy',
                    'placeholder' => 'jj-mm-yyyy'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => "Front\\DomainBundle\\Entity\\Document",
            "user"       => null));
    }
}
