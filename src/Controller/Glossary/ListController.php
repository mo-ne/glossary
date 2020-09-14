<?php

namespace App\Controller\Glossary;

use App\Repository\GlossaryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ListController extends AbstractController
{
    /**
     * Renders a list of all glossary entries.
     *
     * @param GlossaryRepository $glossaryRepo
     *
     * @return Response
     */
    public function list(GlossaryRepository $glossaryRepo): Response
    {
        $entries = $glossaryRepo->findAll();

        return $this->render('glossary/list.html.twig', [
            'entries' => $entries
        ]);
    }
}
