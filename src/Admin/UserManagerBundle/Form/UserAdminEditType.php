<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 31/08/2016
 * Time: 14:24
 */

namespace Admin\UserManagerBundle\Form;

use Front\AppBundle\Entity\Profile;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAdminEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove("plainPassword")
            ->add("profiles", EntityType::class, array(
                "label"      => "Profils spécifiques",
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
                "multiple"  => true,
                "required"  => false
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array("data_class" => 'Front\UserBundle\Entity\User'));
    }

    public function getParent()
    {
        return UserType::class;
    }
}