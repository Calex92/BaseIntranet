<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 10/01/2017
 * Time: 11:05
 */

namespace Admin\AppBundle\Form\Type;


use Front\AppBundle\Entity\Zone;
use Front\AppBundle\Repository\ZoneRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("code", IntegerType::class, array(
                "label"     => "admin.app.region.code",
                "translation_domain"    => "Admin"
            ))
            ->add("name", TextType::class, array(
                "label"     => "admin.app.region.name",
                "translation_domain"    => "Admin"
            ))
            ->add("active", CheckboxType::class, array(
                "label"     => "admin.app.region.active",
                "translation_domain"    => "Admin",
                "required"  => false,
                "attr"      => array('class' => 'datepicker',
                    'data-toggle'   => 'toggle',
                    'data-off'      => 'Inactive',
                    'data-on'       => 'Active')
            ))
            ->add("zone", EntityType::class, array(
                "class"       => "Front\\AppBundle\\Entity\\Zone",
                "choice_label"  => function (Zone $zone) {
                    return $zone->getCode()." - ".$zone->getName();
                },
                "choice_value"  => "id",
                "label"         => "admin.app.region.zone",
                "translation_domain"    => "Admin",
                "query_builder" => function (ZoneRepository $repository) {
                    return $repository->getActiveQueryBuilder();
                },
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array("data_class" => 'Front\AppBundle\Entity\Region'));
    }

}
