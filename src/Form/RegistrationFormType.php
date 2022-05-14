<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez inscrire un email!',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre email doit faire au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => " ",
                'attr' => [
                    'class' => 'form-check',
                ],
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions!',
                    ]),
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez inscrire un mot de passe!',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 255,
                    ]),
                ],
                'first_options' => [
                    'label' => "Mot de Passe:",
                    // 'attr' => [
                    //     'class' => 'form-control',
                    // ]
                ],
                'second_options' => [
                    'label' => "Répétez votre mot de passe:",
                    // 'attr' => [
                    //     'class' => 'form-control',
                    // ]
                ]
            ])
            ->add('firstname', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre prénom doit faire au moins {{ limit }} caractères',
                        'max' => 255,
                    ]),
                ],
            ])
            ->add('lastname', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre nom doit faire au moins {{ limit }} caractères',
                        'max' => 255,
                    ]),
                ],
            ])
            ->add('address', TextType::class, [])
            ->add('zip', NumberType::class, [
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Votre code postal doit faire au moins {{ limit }} caractères',
                        'max' => 5,
                        'maxMessage' => 'Votre code postal doit faire au maximum {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('city', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre nom doit faire au moins {{ limit }} caractères',
                        'max' => 255,
                    ]),
                ],
            ])
            ->add('phone_number', TelType::class, []);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
