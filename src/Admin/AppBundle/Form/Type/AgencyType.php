<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 10/01/2017
 * Time: 11:05
 */

namespace Admin\AppBundle\Form\Type;


use Front\AppBundle\Entity\Region;
use Front\AppBundle\Form\Type\ContactType;
use Front\AppBundle\Repository\RegionRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgencyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("code", IntegerType::class, array(
                "label"     => "admin.app.agency.code",
                "translation_domain" => "Admin"
            ))
            ->add("name", TextType::class, array(
                "label"     => "admin.app.agency.name",
                "translation_domain" => "Admin"
            ))
            ->add("email", EmailType::class, array(
                "label"     => "admin.app.agency.email",
                "translation_domain" => "Admin"
            ))
            ->add("contact", ContactType::class)
            ->add("active", CheckboxType::class, array(
                "label"     => "admin.app.agency.active",
                "translation_domain" => "Admin",
                "required"  => false,
                "attr"      => array(
                    'data-toggle'   => 'toggle',
                    'data-off'      => 'Inactive',
                    'data-on'       => 'Active')
            ))
            ->add("address", TextType::class, array(
                "label"     => "admin.app.agency.address",
                "translation_domain" => "Admin"
            ))
            ->add("postalCode", TextType::class, array(
                "label"     => "admin.app.agency.postalCode",
                "translation_domain" => "Admin"
            ))
            ->add("town", TextType::class, array(
                "label"     => "admin.app.agency.town",
                "translation_domain" => "Admin"
            ))
            ->add("country", TextType::class, array(
                "label"     => "admin.app.agency.country",
                "translation_domain" => "Admin"
            ))
            ->add("latitude", TextType::class, array(
                "label"     => "admin.app.agency.latitude",
                "translation_domain" => "Admin"
            ))
            ->add("longitude", TextType::class, array(
                "label"     => "admin.app.agency.longitude",
                "translation_domain" => "Admin"
            ))
            ->add("region", EntityType::class, array(
                "class"       => "Front\\AppBundle\\Entity\\Region",
                "choice_label"  => function (Region $region) {
                    return $region->getCode()." - ".$region->getName();
                },
                "choice_value"  => "id",
                "label"         => "admin.app.agency.region",
                "translation_domain" => "Admin",
                "query_builder" => function (RegionRepository $repository) {
                    return $repository->getActiveQueryBuilder();
                },
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array("data_class" => 'Front\AppBundle\Entity\Agency'));
    }

}
