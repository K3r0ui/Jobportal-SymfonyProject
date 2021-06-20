<?php

namespace App\Controller\Recruiter;

use App\Entity\Rdv;
use App\Entity\Admin;
use App\Entity\Demploi;
use App\Entity\Oemploi;
use App\Entity\Condidat;
use App\Entity\Categorie;
use App\Entity\Recruiter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/recruiter", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Dashboard Recruiteur');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Categorie', 'fas fa-list', Categorie::class);
        yield MenuItem::linkToCrud('OEmploi', 'fas fa-list', Oemploi::class);
        yield MenuItem::linkToCrud('DEmploi', 'fas fa-list', Demploi::class);
        yield MenuItem::linkToCrud('RDV', 'fas fa-list', Rdv::class);
        yield MenuItem::linkToCrud('Condidat', 'fas fa-list', Condidat::class);
        
    }
}
