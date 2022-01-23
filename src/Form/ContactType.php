<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class, [
            'label' => ' ',
            'required' => true,
            'attr' => [
                'class' => 'form-element',
                'id' => 'name',
                'placeholder' => 'Nom & Prénom'
            ]
        ])
        ->add('tel', TextType::class, [
            'label' => ' ',
            'required' => true,
            'attr' => [
                'class' => 'form-element',
                'id' => 'tel',
                'placeholder' => 'Tel'
            ]
        ])
        ->add('email', EmailType::class, [
            'label' => ' ',
            'required' => true,
            'attr' => [
                'class' => 'form-element',
                'id' => 'email',
                'placeholder' => 'admin@pergolazur.com'
            ]
        ])
        ->add('company', TextType::class, [
            'label' => ' ',
            'required' => false,
            'attr' => [
                'class' => 'form-element',
                'id' => 'company',
                'placeholder' => 'Https://pergolazur.com'
            ]
        ])
        ->add('message', TextareaType::class, [
            'label' => ' ',
            'required' => false,
            'attr' => [
                'class' => 'form-element',
                'id' => 'message',
                'placeholder' => "J'aimerais des informations sur des pergolas svp..."
            ]
        ])
        ->add('agreeTerms', CheckboxType::class, [
            'mapped' => false,
            'constraints' => [
                new IsTrue([
                    'message' => 'Valider la saisie de données',
                ]),
            ]
        ])
        /* ->add('captchaCode', CaptchaType::class, array(
            'captchaConfig' => 'ExampleCaptcha'
          )); */

        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
