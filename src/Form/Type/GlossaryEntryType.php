<?php

namespace App\Form\Type;

use App\Entity\GlossaryEntry;
use App\Form\Type\AbstractEntryType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GlossaryEntryType extends AbstractEntryType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('term', TextType::class, [
                'label' => $this->getTranslator()->trans('entry.term')
            ])
            ->add('description', TextareaType::class, [
                'label' => $this->getTranslator()->trans('entry.description')
            ])
            ->add('relevance', ChoiceType::class, [
                'choices' => [
                    $this->getTranslator()->trans('entry.relevance.1') => 1,
                    $this->getTranslator()->trans('entry.relevance.2') => 2,
                    $this->getTranslator()->trans('entry.relevance.3') => 3
                ],
                'label' => $this->getTranslator()->trans('entry.relevance.title')
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GlossaryEntry::class
        ]);
    }
}
