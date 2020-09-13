<?php

namespace App\Controller\Glossary;

use App\Form\Type\FindEntryType;
use App\Model\GlossaryEntryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class FindEntryController extends AbstractController
{
    /**
     * Search for glossary entry by given term.
     *
     * @param Request $request
     * @param GlossaryEntryServiceInterface $glossaryEntryService
     * @param TranslatorInterface $translator
     *
     * @return Response
     */
    public function findEntry(
        Request $request,
        GlossaryEntryServiceInterface $glossaryEntryService,
        TranslatorInterface $translator
    ): Response {
        $findEntryForm = $this->createForm(FindEntryType::class);
        $findEntryForm->handleRequest($request);

        if ($findEntryForm->isSubmitted() && $findEntryForm->isValid()) {
            $term = $findEntryForm->getData()->getTerm();
            $entry = $glossaryEntryService->findEntry($term);

            if ($entry !== null) {
                return $this->redirectToRoute('edit', [
                    'id' => $entry->getId()
                ]);
            }

            $this->addFlash(
                'danger',
                $translator->trans(
                    'flashmessage.entry.not.found', ['%term%' => $term]
                )
            );
        }

        return $this->render('glossary/find_entry.html.twig', [
            'find_entry' => $findEntryForm->createView()
        ]);
    }
}
