<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 22/12/2016
 * Time: 09:47
 */

namespace Front\DomainBundle\Form\Type;


use Front\DomainBundle\Entity\Domain;
use Front\UserBundle\Entity\User;
use Front\UserBundle\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DomainType extends AbstractType
{
    private $rolesProfile;

    /**
     * DomainType constructor.
     * @param $rolesProfile
     */
    public function __construct($rolesProfile)
    {
        $this->rolesProfile = $rolesProfile;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Domain $domain */
        $domain      = $builder->getData();
        $rolesProfile = $this->rolesProfile;

        $builder
            ->add("label", TextType::class, array(
                "label"     => "front.domain.domain.name",
                "translation_domain"    => "Front",
                "attr"      => array("placeholder"  => "Nom du domaine")
            ))
            ->add("active", CheckboxType::class, array(
                "label"     => "front.domain.domain.active",
                "translation_domain"    => "Front",
                "required"  => false,
                "attr"      => array("data-toggle"   => "toggle",
                    "data-off"      => "Inactif",
                    "data-on"       => "Actif")
            ));

        if ($domain->getActive()) {
            $builder->add("users", EntityType::class, array(
                "label" => "front.domain.domain.users",
                "translation_domain"    => "Front",
                "attr" =>
                    array("data-placeholder" => "Sélectionnez un ou plusieurs utilisateurs",
                        "class" => "chosen-select"),
                "class" => "Front\\UserBundle\\Entity\\User",
                "multiple" => true,
                "query_builder" => function (UserRepository $userRepository) use ($rolesProfile) {
                    //We get only the users that can manage the news
                    return $userRepository->findByRightsCodeQueryBuilder($rolesProfile);
                },
                "choice_label" => function (User $user) {
                    return $user->getSurname() . " " . $user->getFirstname();
                },
                "choice_attr" => function (User $user) use ($domain) {
                    //If they already manage a domain, we can't let them in the list but if they manage this domain,
                    // we don't need to disable them
                    if ($user->getDomainManaged() != null) {
                        if ($domain->getId() == $user->getDomainManaged()->getId()) {
                            return ['selected' => "selected"];
                        } else {
                            return ['disabled' => "disabled"];
                        }
                    } else {
                        return [];
                    }

                }
            ));
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            "data_class" => "Front\\DomainBundle\\Entity\\Domain"
        ));
    }
}
