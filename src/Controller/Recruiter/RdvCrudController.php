<?php

namespace App\Controller\Recruiter;

use App\Entity\Rdv;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RdvCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Rdv::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            DateTimeField::new('date'),
            TextField::new('etat'),
            AssociationField::new('demploi'),
            AssociationField::new('recruiteur'),
        ];
    }
    
}
