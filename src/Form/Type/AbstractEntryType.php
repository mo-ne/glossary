<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Contracts\Translation\TranslatorInterface;

class AbstractEntryType extends AbstractType
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * AbstractEntryType consructor.
     *
     * @param TranslatorInterface $translator
     *
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function getTranslator()
    {
        return $this->translator;
    }
}
