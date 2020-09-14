<?php

namespace App\Controller\Glossary;

use App\Entity\GlossaryEntry;
use App\Form\Type\DeleteEntryType;
use App\Form\Type\GlossaryEntryType;
use App\Model\GlossaryEntryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class GlossaryEntryController extends AbstractController
{
    /**
     * Renders form to create new entry.
     * Handles request to create new entry in database.
     *
     * @param Request $request
     * @param GlossaryEntryServiceInterface $glossaryEntryService
     * @param TranslatorInterface $translator
     *
     * @return Response
     */
    public function createNewEntry(
        Request $request,
        GlossaryEntryServiceInterface $glossaryEntryService,
        TranslatorInterface $translator
    ): Response {
        $glossaryEntry = new GlossaryEntry();
        $glossaryForm = $this->createForm(GlossaryEntryType::class, $glossaryEntry);
        $glossaryForm->handleRequest($request);

        if ($glossaryForm->isSubmitted() && $glossaryForm->isValid()) {

            if ($glossaryEntryService->insertEntry($glossaryEntry)) {
                $this->addFlash(
                    'success',
                    $translator->trans(
                        'flashmessage.entry.added', [
                            '%term%' => $glossaryEntry->getTerm()
                        ]
                    )
                );

                    return $this->redirectToRoute('glossary');
            } else {
                $this->addFlash(
                    'danger',
                    $translator->trans(
                        'flashmessage.entry.already.existing', [
                            '%term%' => $glossaryForm->getData()->getTerm()
                        ]
                    )
                );

                return $this->render('glossary/glossary.html.twig', [
                    'glossary' => $glossaryForm->createView(),
                ]);
            }
        } else {
            return $this->render('glossary/glossary.html.twig', [
                'glossary' => $glossaryForm->createView(),
            ]);
        }
    }

    /**
     * Renders form to edit entry by given term and updates term in database.
     *
     * @param Request $request
     * @param GlossaryEntry $glossaryEntry
     * @param GlossaryEntryServiceInterface $glossaryEntryService
     * @param TranslatorInterface $translator
     *
     * @return Response
     */
    public function editEntry(
        Request $request,
        GlossaryEntry $glossaryEntry,
        GlossaryEntryServiceInterface $glossaryEntryService,
        TranslatorInterface $translator
    ): Response {
        $glossaryForm = $this->createForm(GlossaryEntryType::class, $glossaryEntry);
        $glossaryForm->handleRequest($request);

        if ($glossaryForm->isSubmitted() && $glossaryForm->isValid()) {
            if ($glossaryEntryService->updateEntry($glossaryEntry)) {
                $this->addFlash(
                    'success',
                    $translator->trans('flashmessage.entry.updated')
                );

                return $this->redirectToRoute('edit', [
                    'id' => $glossaryEntry->getId()
                ]);
            }
        }

        return $this->render('glossary/edit.html.twig', [
            'glossary' => $glossaryForm->createView()
        ]);
    }

    /**
     * Renders form to delete entry from database.
     *
     * @param Request $request
     * @param GlossaryEntry $glossaryEntry
     * @param GlossaryEntryServiceInterface $glossaryEntryService
     * @param TranslatorInterface $translator
     *
     * @return Response
     */
    public function deleteEntry(
        Request $request,
        GlossaryEntry $glossaryEntry,
        GlossaryEntryServiceInterface $glossaryEntryService,
        TranslatorInterface $translator
    ): Response {
        $deleteEntryForm = $this->createForm(DeleteEntryType::class, $glossaryEntry);
        $deleteEntryForm->handleRequest($request);

        if ($deleteEntryForm->isSubmitted() && $deleteEntryForm->isValid()) {
            if ($glossaryEntryService->deleteEntry($glossaryEntry)) {
                $this->addFlash(
                    'success',
                    $translator->trans('flashmessage.entry.deleted')
                );

                return $this->redirectToRoute('list');
            }
        }

        return $this->render('glossary/delete_entry.html.twig', [
            'delete_entry' => $deleteEntryForm->createView(),
            'glossary' => $glossaryEntry
        ]);
     }
}
