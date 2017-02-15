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
    private $codeProfile;

    /**
     * DomainType constructor.
     * @param $codeProfile
     */
    public function __construct($codeProfile)
    {
        $this->codeProfile = $codeProfile;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Domain $domain */
        $domain      = $builder->getData();
        $codeProfile = $this->codeProfile;

        $builder
            ->add("label", TextType::class, array(
                "label"     => "Nom du domaine",
                "attr"      => array("placeholder"  => "Nom du domaine")
            ))
            ->add("active", CheckboxType::class, array(
                "label"     => " ",
                "required"  => false,
                "attr"      => array("data-toggle"   => "toggle",
                    "data-off"      => "Inactif",
                    "data-on"       => "Actif")
            ));

        if ($domain->getActive()) {
            $builder->add("users", EntityType::class, array(
                "label" => "Utilisateurs gestionnaires",
                "attr" =>
                    array("data-placeholder" => "Sélectionnez un ou plusieurs utilisateurs",
                        "class" => "chosen-select"),
                "class" => "Front\\UserBundle\\Entity\\User",
                "multiple" => true,
                "query_builder" => function (UserRepository $userRepository) use ($codeProfile) {
                    //We get only the users that can manage the news
                    return $userRepository->findByRightsCodeQueryBuilder($codeProfile);
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
