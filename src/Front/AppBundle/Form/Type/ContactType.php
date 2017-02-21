<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 01/09/2016
 * Time: 15:21
 */

namespace Front\AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('phone', TextType::class, array(
            'label' => 'front.app.contact.phone',
            'required' => false,
            'translation_domain' => 'Front'
        ))
            ->add('mobilePhone', TextType::class, array(
                'label' => "front.app.contact.mobile",
                'required' => false,
                'translation_domain' => 'Front'
            ))
            ->add('fax', TextType::class, array(
                'label' => 'front.app.contact.fax',
                'required' => false,
                'translation_domain' => 'Front'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Front\AppBundle\Entity\Contact'));
    }
}
