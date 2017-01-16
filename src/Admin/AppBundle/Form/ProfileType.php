<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 10/01/2017
 * Time: 11:05
 */

namespace Admin\AppBundle\Form;


use Front\AppBundle\Entity\Application;
use Front\AppBundle\Entity\Right;
use Front\AppBundle\Repository\RightRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Application $application */
        $application = $options["application"];
        $builder->add("name", TextType::class, array(
                "label"     => "Nom du profil"
            ))
            ->add("rights", EntityType::class, array(
                "label"      => "Droits",
                "class"      => "Front\\AppBundle\\Entity\\Right",
                "query_builder" => function(RightRepository $rightRepository) use ($application){
                    return $rightRepository->getQbByApplication($application);
                },
                "placeholder"=> " ",
                "choice_label"  => function (Right $right) {
                    return $right->getName();
                },
                "attr"      => array(
                    'class'             => 'chosen-select',
                    'data-placeholder'   => 'Sélectionnez un droit à ajouter...'),
                "multiple"  => true
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            "data_class" => 'Front\AppBundle\Entity\Profile',
            "application"   => null));
    }

}