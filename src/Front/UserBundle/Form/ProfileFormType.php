<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 24-08-16
 * Time: 14:11
 */

namespace Front\UserBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('surname', null, array('label' => 'Nom de famille'));
        $builder->add('firstname', null, array('label' => 'Prénom'));
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }
}