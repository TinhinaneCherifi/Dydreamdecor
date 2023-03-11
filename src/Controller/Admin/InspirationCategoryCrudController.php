<?php

namespace App\Controller\Admin;

use App\Entity\InspirationCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class InspirationCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return InspirationCategory::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
        ->add('index', 'detail');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name','Titre'),
            AssociationField::new('inspirations', 'Inspirations'),
        ];
    }
}
