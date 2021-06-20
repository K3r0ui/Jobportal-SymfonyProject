<?php

namespace App\Controller\Recruiter;

use App\Entity\Oemploi;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OemploiCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Oemploi::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextField::new('description'),
            ArrayField::new('etat'),
            IntegerField::new('salaire'),
            AssociationField::new('categorie'),
            CountryField::new('location'),
            TextField::new('nomemployeur'),
            ArrayField::new('emploirequirement'),
         /*   TextareaField::new('imageFile')
            ->setFormType(VichImageType::class)
            ->hideOnIndex()
            ->setBasePath("app.path.employeurimages")
            ->setUploadDir('public/uploads/images/employeurimage'), */
            ImageField::new('employeurimage')
            ->setBasePath('uploads/images/employeurimage')
            ->setUploadDir('public/uploads/images/employeurimage')
            ->setFormType(FileUploadType::class)
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            DateTimeField::new('createdAt'),
        ];
    }
    public function configureActions(Actions $actions): Actions
{
    return $actions
        // ...
        ->setPermission(Action::NEW, 'ROLE_ADMIN')
    ;
}
    
}
