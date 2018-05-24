<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 31/08/2016
 * Time: 14:24
 */

namespace Admin\UserManagerBundle\Form\Type;

use Front\AppBundle\Entity\Profile;
use Front\DomainBundle\Repository\DomainRepository;
use Front\UserBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAdminEditType extends AbstractType
{
    /** @var array */
    private $rightThatCanManageNews;

    /**
     * UserAdminEditType constructor.
     * @param $rightThatCanManageNews
     */
    public function __construct(array $rightThatCanManageNews)
    {
        $this->rightThatCanManageNews = $rightThatCanManageNews;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var User $user */
        $user = $options["user"];
        $builder->remove("plainPassword")
            ->remove("mainAgency")
            ->add("profiles", EntityType::class, array(
                "label"      => "admin.user_manager.user_edit.specific_profiles",
                "translation_domain"    => "Admin",
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

        //If the user manage a domain, we need to add the "domain" part in the form
        foreach ($this->rightThatCanManageNews as $codeRight) {
            if ($user->getRight($codeRight) != null) {
                $builder->add("domainManaged", EntityType::class, array(
                    "label"     => "admin.user_manager.user_edit.domain_managed",
                    "translation_domain"    => "Admin",
                    "class"     => "Front\\DomainBundle\\Entity\\Domain",
                    "choice_label"  => "label",
                    "query_builder" => function(DomainRepository $domainRepository) {
                        return $domainRepository->getActiveQueryBuilder();
                    },
                    "placeholder"   => "Sélectionnez un domaine",
                    "required" => false
                ));
                break;
            }
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array("data_class" => 'Front\UserBundle\Entity\User',
            "user"  => null));
    }

    public function getParent()
    {
        return UserType::class;
    }
}
