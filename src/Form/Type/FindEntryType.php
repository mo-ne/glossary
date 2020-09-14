<?php

namespace App\Form\Type;

use App\Entity\GlossaryEntry;
use App\Form\Type\AbstractEntryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FindEntryType extends AbstractEntryType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'term',
                TextType::class,
                ['label' => $this->getTranslator()->trans('entry.term'), 'help' => $this->getTranslator()->trans('form.help.edit')]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GlossaryEntry::class
        ]);
    }
}
