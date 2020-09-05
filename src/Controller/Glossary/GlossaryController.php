<?php

namespace App\Controller\Glossary;

use App\Entity\Glossary;
use App\Form\Type\DeleteEntryType;
use App\Form\Type\GlossaryType;
use App\Repository\GlossaryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GlossaryController extends AbstractController
{
    /**
     * Renders form to create new entry.
     * Handles request to create new entry in database.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function createNewEntry(Request $request): Response
    {
        $glossary = new Glossary();
        $entityManager = $this->getDoctrine()->getManager();

        $glossaryForm = $this->createForm(GlossaryType::class, $glossary);
        $glossaryForm->handleRequest($request);

        if ($glossaryForm->isSubmitted() && $glossaryForm->isValid()) {
            $data = $glossaryForm->getData();
            $term = $data->getTerm();

            $checkEntry = $this->getDoctrine()
                ->getRepository(Glossary::class)
                ->findByTerm($term);

            if ($checkEntry == NULL) {
                $entityManager->persist($glossary);
                $entityManager->flush();

                $this->addFlash(
                    'success', '\'' . $term . '\' has been added to your glossary!');

                    return $this->redirectToRoute('glossary');
            } else {
                $this->addFlash(
                    'success', 'The term \'' . $term . '\' already exists in your glossary.');

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
     * @param Glossary $glossary
     * @param EntityManagerInterface $entityManager
     *
     * @return Response
     */
    public function editEntry(
        Glossary $glossary,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $glossaryForm = $this->createForm(GlossaryType::class, $glossary);
        $glossaryForm->handleRequest($request);

        if ($glossaryForm->isSubmitted() && $glossaryForm->isValid()) {
            $entityManager->persist($glossary);
            $entityManager->flush();

            $this->addFlash('success', 'Entry updated!');

            return $this->redirectToRoute('edit', [
                'id' => $glossary->getId()
            ]);
        }

        return $this->render('glossary/edit.html.twig', [
            'glossary' => $glossaryForm->createView()
        ]);
    }

    /**
     * Renders form to delete entry from database.
     *
     * @param Request $request
     * @param Glossary $glossary
     * @param EntityManagerInterface $entityManager
     *
     * @return Response
     */
    public function deleteEntry(
        Glossary $glossary,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $deleteEntryForm = $this->createForm(DeleteEntryType::class, $glossary);
        $deleteEntryForm->handleRequest($request);

        if ($deleteEntryForm->isSubmitted() && $deleteEntryForm->isValid()) {
            $entityManager->remove($glossary);
            $entityManager->flush();

            $this->addFlash('success', 'Entry deleted!');

            return $this->redirectToRoute('list');
        }

        return $this->render('glossary/delete_entry.html.twig', [
            'delete_entry' => $deleteEntryForm->createView(),
            'glossary' => $glossary
        ]);
     }
}
