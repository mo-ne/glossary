<?php

namespace App\Form\Type;

use App\Entity\GlossaryEntry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GlossaryEntryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('term', TextType::class)
            ->add('description', TextareaType::class)
            ->add('relevance', ChoiceType::class, [
                'choices' => [
                    'high' => 1,
                    'medium' => 2,
                    'low' => 3]])
             ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GlossaryEntry::class
        ]);
    }
}