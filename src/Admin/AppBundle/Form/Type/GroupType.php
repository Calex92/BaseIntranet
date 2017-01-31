<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 10/01/2017
 * Time: 11:05
 */

namespace Admin\AppBundle\Form\Type;


use Front\AppBundle\Entity\Profile;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("name", TextType::class, array(
                "label"     => "Nom du groupe"
            ))
            ->add("profiles", EntityType::class, array(
                "label"      => "Profils",
                "class"      => "Front\\AppBundle\\Entity\\Profile",
                "placeholder"=> " ",
                "choice_label"  => function (Profile $profile) {
                    return $profile->getName();
                },
                "group_by"   => function(Profile $val) {
                    return $val->getApplication()->getName();
                },
                "attr"      => array(
                    'class'             => 'chosen-select',
                    'data-placeholder'   => 'Sélectionnez un profil à ajouter...'),
                "multiple"  => true
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array("data_class" => 'Front\AppBundle\Entity\Group'));
    }

}
