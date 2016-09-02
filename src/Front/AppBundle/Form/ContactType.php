<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 01/09/2016
 * Time: 15:21
 */

namespace Front\AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('phone', TextType::class, array('label' => "Téléphone", 'required' => false))
            ->add('mobilePhone', TextType::class, array('label' => "Portable", 'required' => false))
            ->add('fax', TextType::class, array('label' => 'Fax', 'required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Front\AppBundle\Entity\Contact'));
    }
}