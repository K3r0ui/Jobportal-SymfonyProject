<?php

namespace App\Controller\Recruiter;

use App\Entity\Demploi;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DemploiCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Demploi::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('etat'),
            DateTimeField::new('date'),
            AssociationField::new('oemploi'),
            AssociationField::new('idcondidat'),
        ];
    }
    
}
