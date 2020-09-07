<?php

namespace App\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends AbstractController
{
    /**
     * Renders dashboard.
     *
     * @return Response
     */
    public function dashboard(): Response
    {
        return $this->render('glossary/dashboard.html.twig');
    }
}
