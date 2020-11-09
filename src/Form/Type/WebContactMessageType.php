<?php

namespace App\Form\Type;

use App\Model\WebContactMessage;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue as RecaptchaTrue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class WebContactMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Nombre *',
                    'required' => true,
                    'attr' => [
                        'class' => 'common-fields',
                    ],
                    'constraints' => [
                        new Assert\NotBlank(),
                    ],
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'Email *',
                    'required' => true,
                    'attr' => [
                        'class' => 'common-fields',
                    ],
                    'constraints' => [
                        new Assert\NotBlank(),
                        new Assert\Email([
                            'strict' => true,
                            'checkMX' => true,
                            'checkHost' => true,
                        ]),
                    ],
                ]
            )
            ->add(
                'message',
                TextareaType::class,
                [
                    'label' => 'Consulta *',
                    'required' => true,
                    'attr' => [
                        'rows' => 5,
                        'class' => 'message-field',
                    ],
                    'constraints' => [
                        new Assert\NotBlank(),
                    ],
                ]
            )
            ->add(
                'privacyPolicyAgreementAccepted',
                CheckboxType::class,
                [
                    'required' => true,
                    'mapped' => false,
                    'label' => 'Acepto las condiciones legales',
                ]
            )
            ->add(
                'captcha',
                EWZRecaptchaType::class,
                [
                    'label' => ' ',
                    'attr' => [
                        'options' => [
                            'theme' => 'light',
                            'type' => 'image',
                            'size' => 'normal',
                        ],
                    ],
                    'mapped' => false,
                    'constraints' => [
                        new RecaptchaTrue(),
                    ],
                ]
            )
            ->add(
                'send',
                SubmitType::class,
                [
                    'label' => 'Enviar',
                    'attr' => [
                        'class' => 'btn-primary',
                    ],
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => WebContactMessage::class,
            ]
        );
    }
}
