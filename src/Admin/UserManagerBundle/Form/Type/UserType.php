<?php

namespace Admin\UserManagerBundle\Form\Type;

use Front\AppBundle\Entity\Agency;
use Front\AppBundle\Form\Type\ContactType;
use Front\AppBundle\Repository\AgencyRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 30/08/2016
 * Time: 14:11
 */
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('surname', TextType::class, array('label' => "form.surname", 'translation_domain' => 'FOSUserBundle'))
            ->add('firstname', TextType::class, array('label' => "form.firstname", 'translation_domain' => 'FOSUserBundle'))
            ->add('email', EmailType::class, array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
            ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch'))
            ->add('contact', ContactType::class)
            ->add("group", EntityType::class, array(
                "label" => "admin.user_manager.user.group",
                "translation_domain"    => "Admin",
                "expanded" => false,
                "multiple" => false,
                "class" => "Front\\AppBundle\\Entity\\Group",
                "choice_label" => "name",
                "placeholder" => "Sélectionnez un groupe",
                "attr" => array(
                    'class' => 'chosen-select'),
            ))
            ->add("mainAgency", EntityType::class, array(
                "mapped" => false,
                "label" => "admin.user_manager.user.main_agency",
                "translation_domain" => "Admin",
                "multiple" => false,
                "expanded" => false,
                "class" => "Front\\AppBundle\\Entity\\Agency",
                "placeholder" => "Sélectionnez l'agence principale",
                "choice_label" => function (Agency $agency) {
                    return $agency->getCode() . " - " . $agency->getName();
                },
                "query_builder" => function (AgencyRepository $agencyRepository) {
                    return $agencyRepository->getAgenciesQueryBuilder();
                },
                "attr" => array(
                    'class' => 'chosen-select'),
            ))
            ->add("enabled", CheckboxType::class, array(
                "label" => "admin.user_manager.user.active",
                "translation_domain"    => "Admin",
                "required" => false,
                "attr" => array("data-toggle" => "toggle",
                    "data-off" => "Inactif",
                    "data-on" => "Actif")
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Front\UserBundle\Entity\User'));
    }

    public function getBlockPrefix()
    {
        return 'fos_user_registration';
    }
}
