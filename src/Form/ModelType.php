<?php

namespace App\Form;

use App\Entity\Model;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ModelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', textType::class, [
            'label'=>'Model',
            'attr'=> [
                'placeholder' => 'Nike air',
            ],
        ])
        ->add('slug', textType::class, [
            'label'=>'slug',
            'attr'=> [
                'placeholder' => 'Nike air'
            ],
        ])
        ->add('enable', CheckboxType::class, [
            'label'=> 'Actif',
            'required' => false,
        ])
        ->add('created_at', DateTimeType::class, [
            'date_label' => 'Starts On',
            'widget' => 'single_text',
            'attr' => ['readonly' => true], // Champ en lecture seule
            'data' => new \DateTimeImmutable(), // Valeur par défaut à la création
        ])
        ->add('updated_at', DateType::class, [
            'widget' => 'single_text',
        ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Model::class,
        ]);
    }
}
