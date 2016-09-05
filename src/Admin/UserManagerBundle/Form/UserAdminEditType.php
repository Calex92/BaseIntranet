<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 31/08/2016
 * Time: 14:24
 */

namespace Admin\UserManagerBundle\Form;


use Front\AppBundle\Entity\Agency;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAdminEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove("plainPassword")
            ->add('agencies', EntityType::class, array(
                'class' => 'Front\AppBundle\Entity\Agency',
                'choice_label' => function($agency) {
                    /** @var Agency $agency */
                    return $agency->getCode()." - ".$agency->getName();
                }
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