<?php

namespace App\Controller\Admin;

use App\Entity\TodoList;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TodoListCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TodoList::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
        ->add('index', 'detail'); // in order to add the "consulter" button on each tack and access its detail
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('taskName', 'Nom de la tâche'),
            TextareaField::new('description', 'Description de la tâche'),
            DateTimeField::new('deadLine', 'Accomplir avant le'),
            BooleanField::new('isDone', 'Fait')
        ];
    }
}
