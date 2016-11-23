<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 24-08-16
 * Time: 14:11
 */

namespace Front\UserBundle\Form;


use Front\AppBundle\Form\ContactType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('surname', TextType::class, array('label' => 'form.surname',
            'translation_domain' => 'FOSUserBundle'))
            ->add('firstname', TextType::class, array('label' => 'form.firstname',
            'translation_domain' => 'FOSUserBundle'))
            ->add('contact', ContactType::class)
            ->add('imageFile', VichImageType::class, array("required" => false, 'download_link' => false));
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