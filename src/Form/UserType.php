<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstName', TextType::class, [
            'label'=> 'Prénom',
            'attr'=> [
                'placeholder'=> 'john',
            ],
        ])
        ->add('lastName', TextType::class, [
            'label'=> 'Nom',
            'attr'=> [
                'placeholder'=> 'Doe',
            ],
        ])
        ->add('Telephone', TextType::class,[
            'label'=> 'Telephone',
            'attr'=> [
                'placeholder'=> '0609274878'
            ],
        ])
        ->add('BirthDate', BirthdayType::class, [
            'widget'=> 'single_text',
            'format'=> 'yyyy-MM-dd',
            'placeholder'=>'1987/03/28',
        ])
        ->add('email', EmailType::class, [
            'label'=> 'Email',
            'attr'=> ['
                placeholder'=> 'john@exemple.com',
        ],
        ])
        ->add('password', RepeatedType::class, [
            'type'=> PasswordType::class,
            'invalid_message'=> 'Les mots de passe doivent être identiques.', 
            'first_options'=> [
                'label'=> 'Mot de passe',
                'attr'=> [
                    'placeholder'=> 'S3CRE3T',
                ],
                'constraints'=> [
                    new NotBlank(),
                    new Length([
                        'max'=> 4096,
                    ]),
                    new Regex(
                        pattern: '/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$/',
                        message: 'Le mot de passe doit contenir 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial. Longueur entre 8 et 16 caractères.'
                    ),
                ]
            ],
            'second_options'=> [
                'label'=> 'Confirmer le mot de passe',
                'attr'=> [
                    'placeholder'=> 'S3CR3T',
                ],
            ],
            'mapped'=> 'false',
        ]);

        if($options['isAdmin']) {
            $builder    
                    ->remove('password')
                    ->add('roles', ChoiceType::class, [
                        'label' => 'Rôle',
                        'choices' => [
                            'Utilisateur' => 'ROLE_USER',
                            'éditeur' =>'ROLE_EDITOR',
                            'Administrateur' => 'ROLE_ADMIN',
                        ],
                        'expanded' => true,
                        'multiple' => true,
                    ]);

        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => User::class,
            'isAdmin' => false,
        ]);
    }
}