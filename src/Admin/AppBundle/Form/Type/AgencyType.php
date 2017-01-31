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
                "label"     => "Code"
            ))
            ->add("name", TextType::class, array(
                "label"     => "Nom de l'agence"
            ))
            ->add("email", EmailType::class, array(
                "label"     => "Adresse email"
            ))
            ->add("contact", ContactType::class)
            ->add("active", CheckboxType::class, array(
                "label"     => " ",
                "required"  => false,
                "attr"      => array('class' => 'datepicker',
                    'data-toggle'   => 'toggle',
                    'data-off'      => 'Inactive',
                    'data-on'       => 'Active')
            ))
            ->add("address", TextType::class, array(
                "label"     => "Adresse"
            ))
            ->add("postalCode", TextType::class, array(
                "label"     => "Code postal"
            ))
            ->add("town", TextType::class, array(
                "label"     => "Ville"
            ))
            ->add("country", TextType::class, array(
                "label"     => "Pays"
            ))
            ->add("latitude", TextType::class, array(
                "label"     => "Latitude"
            ))
            ->add("longitude", TextType::class, array(
                "label"     => "Longitude"
            ))
            ->add("region", EntityType::class, array(
                "class"       => "Front\\AppBundle\\Entity\\Region",
                "choice_label"  => function (Region $region) {
                    return $region->getCode()." - ".$region->getName();
                },
                "choice_value"  => "id",
                "label"         => "Region",
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
