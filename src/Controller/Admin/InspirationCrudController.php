<?php

namespace App\Controller\Admin;

use App\Entity\Inspiration;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class InspirationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Inspiration::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
        ->add('index', 'detail');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ImageField::new('image','Image')
            ->setBasePath('uploads/inspiration_images/')
            ->setUploadDir('public/uploads/inspiration_images')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            TextField::new('alt','Texte alternatif')->hideOnIndex(),
            TextField::new('title','Titre'),
            SlugField::new('slug')
            ->setTargetFieldName('title')
            ->hideOnIndex()
            ->hideOnDetail(),
            TextField::new('subtitle','Sous-titre'),
            BooleanField::new('isPopular','A la Une'),
            MoneyField::new('price','Prix')->setCurrency('EUR'),
            TextareaField::new('description','Description'),
            AssociationField::new('category','Catégorie'),
            AssociationField::new('items', 'Articles utilisés dans cette inspiration')->setRequired(false)
        ];
    }
}