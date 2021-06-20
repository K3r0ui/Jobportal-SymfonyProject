<?php

namespace App\Controller\Recruiter;

use App\Entity\Condidat;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\HiddenField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CondidatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Condidat::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            EmailField::new('email'),
            Field::new('password', 'New password')->onlyOnForms()
            ->setFormType(PasswordType::class),
            TelephoneField::new('mobile'),
            ImageField::new('cvimage')
            ->setBasePath('uploads/condidat/cv')
            ->setUploadDir('public/uploads/condidat/cv')
            ->setFormType(FileUploadType::class)
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            DateTimeField::new('createdAt'),
            TextField::new('nom'),
            TextField::new('prenom'),
            ImageField::new('profileimage')
            ->setBasePath('uploads/condidat/pdp')
            ->setUploadDir('public/uploads/condidat/pdp')
            ->setFormType(FileUploadType::class)
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            DateTimeField::new('ddnaissance'),
            BooleanField::new('enabled'),
            HiddenField::new('token')->onlyOnForms(),
            HiddenField::new('resettoken')->onlyOnForms(),
        ];
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // ...
          //  ->setPermission(Action::DELETE, 'ROLE_ADMIN')
          //  ->setPermission(Action::DETAIL, 'ROLE_RECRUITER')
            ->disable(Action::NEW,Action::EDIT) // Disable creating Condidat or editing in the backend
            
        ;
    }
    
}
