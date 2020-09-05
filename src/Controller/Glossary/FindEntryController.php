<?php

namespace App\Controller\Glossary;

use App\Entity\GlossaryEntry;
use App\Form\Type\FindEntryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FindEntryController extends AbstractController
{
    /**
     * Search for glossary entry by given term.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function findEntry(Request $request): Response
    {
        $glossaryEntry = new GlossaryEntry();
        $entityManager = $this->getDoctrine()->getManager();
        $findEntryForm = $this->createForm(FindEntryType::class);
        $findEntryForm->handleRequest($request);

        if ($findEntryForm->isSubmitted() && $findEntryForm->isValid()) {
            $data = $findEntryForm->getData();
            $term = $data->getTerm();

            $entry = $this->getDoctrine()
            ->getRepository(GlossaryEntry::class)
            ->findByTerm($term);

            if ($entry !== NULL) {
                return $this->redirectToRoute('edit', [
                    'id' => $entry->getId()
                ]);
            }

            $this->addFlash(
                'success',
                'The term \'' . $term . '\' does not exist in your glossary!'
            );
        }

        return $this->render('glossary/find_entry.html.twig', [
            'find_entry' => $findEntryForm->createView()
        ]);
    }
}
