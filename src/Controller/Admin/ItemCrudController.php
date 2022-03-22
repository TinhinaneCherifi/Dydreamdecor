<?php

namespace App\Controller\Admin;

use App\Entity\Item;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;

class ItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Item::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
        ->add('index', 'detail');
    }

    public function configureFields(string $pageName): iterable
    {
        return[
            ImageField::new('image','Image')
            ->setBasePath('uploads/item_images/')
            ->setUploadDir('public/uploads/item_images')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            TextField::new('alt','Texte alternatif')->hideOnIndex(),
            TextField::new('name','Nom'),
            SlugField::new('slug')
            ->setTargetFieldName('name')
            ->hideOnIndex()
            ->hideOnDetail(),
            BooleanField::new('isPopular', 'A la Une'),
            MoneyField::new('price','Prix')->setCurrency('EUR'),
            TextareaField::new('description','Description'),
            AssociationField::new('category','Catégorie'),
            AssociationField::new('inspirations', 'Inspirations utilisant cet article')->setRequired(false)
        ];
    }
    
}