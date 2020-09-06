<?php

namespace App\Controller\Glossary;

use App\Entity\GlossaryEntry;
use App\Form\Type\DeleteEntryType;
use App\Form\Type\GlossaryEntryType;
use App\Model\GlossaryEntryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GlossaryEntryController extends AbstractController
{
    /**
     * Renders form to create new entry.
     * Handles request to create new entry in database.
     *
     * @param Request $request
     * @param GlossaryEntryServiceInterface $glossaryEntryService
     *
     * @return Response
     */
    public function createNewEntry(
        Request $request,
        GlossaryEntryServiceInterface $glossaryEntryService
    ): Response {
        $glossaryEntry = new GlossaryEntry();
        $glossaryForm = $this->createForm(GlossaryEntryType::class, $glossaryEntry);
        $glossaryForm->handleRequest($request);

        if ($glossaryForm->isSubmitted() && $glossaryForm->isValid()) {

            if ($glossaryEntryService->insertEntry($glossaryEntry)) {
                $this->addFlash(
                    'success', '\'' . $glossaryEntry->getTerm() . '\' has been added to your glossary!');

                    return $this->redirectToRoute('glossary');
            } else {
                $this->addFlash(
                    'danger',
                    'The term \'' . $glossaryForm->getData()->getTerm() . '\' already exists in your glossary.');

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
     *
     * @return Response
     */
    public function editEntry(
        Request $request,
        GlossaryEntry $glossaryEntry,
        GlossaryEntryServiceInterface $glossaryEntryService
    ): Response {
        $glossaryForm = $this->createForm(GlossaryEntryType::class, $glossaryEntry);
        $glossaryForm->handleRequest($request);

        if ($glossaryForm->isSubmitted() && $glossaryForm->isValid()) {
            if ($glossaryEntryService->updateEntry($glossaryEntry)) {
                $this->addFlash('success', 'Entry updated!');

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
     *
     * @return Response
     */
    public function deleteEntry(
        Request $request,
        GlossaryEntry $glossaryEntry,
        GlossaryEntryServiceInterface $glossaryEntryService
    ): Response {
        $deleteEntryForm = $this->createForm(DeleteEntryType::class, $glossaryEntry);
        $deleteEntryForm->handleRequest($request);

        if ($deleteEntryForm->isSubmitted() && $deleteEntryForm->isValid()) {
            if ($glossaryEntryService->deleteEntry($glossaryEntry)) {
                $this->addFlash('success', 'Entry deleted!');

                return $this->redirectToRoute('list');
            }
        }

        return $this->render('glossary/delete_entry.html.twig', [
            'delete_entry' => $deleteEntryForm->createView(),
            'glossary' => $glossaryEntry
        ]);
     }
}
