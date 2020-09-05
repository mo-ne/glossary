<?php

namespace App\Form\Type;

use App\Entity\Glossary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditPageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', TextType::class)
            ->add('term', TextType::class)
            ->add('description', TextType::class)
            ->add('relevance', ChoiceType::class, [
                'choices' => [
                    'high' => 1,
                    'medium' => 2,
                    'low' => 3
                ]
            ])
            ->add('creation_date', DateTimeType::class, [])
            ->add('change_date', DateTimeType::class, [])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Glossary::class
        ]);
    }
}
