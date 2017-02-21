<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 24/11/2016
 * Time: 17:47
 */

namespace Front\DomainBundle\Form\Type;


use Front\DomainBundle\Repository\DomainRepository;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options["user"];
        $builder->add('title', TextType::class,
                array("label" => "front.domain.news.title",
                    "translation_domain"    => "Front"))
            ->add('text', CKEditorType::class,
                array("label" => "front.domain.news.text",
                    "translation_domain"    => "Front",
                    "config_name" => "my_basic_config"))
            ->add('beginPublicationDate', DateType::class,
                array("label" => "front.domain.news.begin_publication",
                    "translation_domain"    => "Front",
                    "widget" => "single_text",
                    'format' => 'dd-MM-yyyy',
                    'placeholder' => 'jj-mm-yyyy'))
            ->add('endPublicationDate', DateType::class,
                array("label" => "front.domain.news.end_publication",
                    "translation_domain"    => "Front",
                    "required" => false,
                    "widget" => "single_text",
                    'format' => 'dd-MM-yyyy',
                    'placeholder' => 'jj-mm-yyyy'))
            ->add('imageFile', VichImageType::class,
                array("label" => "front.domain.news.image_cover",
                    "translation_domain"    => "Front",
                    "required" => false))
            ->add('domain', EntityType::class,
                array("class"       => "Front\\DomainBundle\\Entity\\Domain",
                    "choice_label"  => "label",
                    "choice_value"  => "id",
                    "label"         => "front.domain.news.domain",
                    "translation_domain"    => "Front",
                    "query_builder" => function (DomainRepository $repository) use ($user){
                        return $repository->getActiveQueryBuilderForUser($user);
                    },))
            ->add('externalVideo', CollectionType::class, array(
                "entry_type"    => TextType::class,
                "allow_add"     => true,
                "allow_delete"  => true,
                "label"         => "front.domain.news.external_video",
                "translation_domain"    => "Front"
            ))
            ->add('files', CollectionType::class, array(
                "entry_type"    => NewsFileType::class,
                "allow_add"     => true,
                "by_reference"  => false,
                "allow_delete"  => true,
                "label"         => "front.domain.news.attachment",
                "translation_domain"    => "Front"
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Front\DomainBundle\Entity\News',
            'user'       => null));
    }
}
