<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 31/08/2016
 * Time: 14:24
 */

namespace Admin\UserManagerBundle\Form;


use Doctrine\ORM\EntityRepository;
use Front\AppBundle\Entity\Agency;
use Front\AppBundle\Repository\AgencyRepository;
use Front\UserBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAdminEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove("plainPassword")
            ->add('user_agencies', EntityType::class, array(
                'class' => 'Front\AppBundle\Entity\Agency',
                'choice_label' => function($agency) {
                    /** @var Agency $agency */
                    return $agency->getCode()." - ".$agency->getName();
                },
                'query_builder' => function (EntityRepository $entityRepository) use ($options) {
                    if (isset($options['data'])){
                        /** @var User $user */
                        $user = $options['data'];

                        /** @var AgencyRepository $entityRepository */
                        return $entityRepository->getAgenciesNotUserQuery($user->getId());

                    }
                        //return $entityRepository;
                    else {
                        echo var_dump($options['data']); exit();
                    }
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