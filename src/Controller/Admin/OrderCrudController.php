<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Service\MailJet;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderCrudController extends AbstractCrudController
{
    private $entityManager;
    private $adminUrlGenerator;


    public function __construct(EntityManagerInterface $entityManager, AdminUrlGenerator $adminUrlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $gettingPrepared = Action::new('gettingPrepared', 'En cours de préparation', 'fas fa-box-open')->linkToCrudAction('gettingPrepared');
        $gettingDelivered = Action::new('gettingDelivered', 'En cours de livraison', 'fas fa-truck')->linkToCrudAction('gettingDelivered');
        $delivered = Action::new('delivered', 'Livrée', 'fas fa-check-double')->linkToCrudAction('delivered');


        return $actions
        ->add('detail', $gettingPrepared)
        ->add('detail', $gettingDelivered)
        ->add('detail', $delivered)
        ->add('index', 'detail'); // in order to add the "show" button on each order and access its the detail
    }

    public function gettingPrepared(AdminContext $context)
    {
        $order = $context->getEntity()->getInstance();
        $order->setStatus(2);
        $this->entityManager->flush();
        
        $user = $order->getUser(); //ajouté pour l'envoi de mail

        $url = $this->adminUrlGenerator
            ->setController(OrderCrudController::class)
            ->setAction(Action::INDEX)
            ->generateUrl();

        // Send an order status change email
        $mailJet = new MailJet();
        $subject = 'Changement de statut de votre commande';
        $title = 'Votre commande est cours de préparation';
        $content = 'Cher(e) '.$order->getUser()->getFirstname().', votre commande'.$order->getRef().'est en cours de préparation';
        $button = 'Suivre ma commande';
        $mailJet->send($user->getEmail(),$user->getFirstname(), $subject, $title, $content, $button);
            
        return $this->redirect($url);
    }

    public function gettingDelivered(AdminContext $context)
    {
        $order = $context->getEntity()->getInstance();
        $order->setStatus(3);
        $this->entityManager->flush();

        $user = $order->getUser(); //ajouté pour l'envoi de mail
        
        $url = $this->adminUrlGenerator
            ->setController(OrderCrudController::class)
            ->setAction(Action::INDEX)
            ->generateUrl();

        // Send an order status change email
        $mailJet = new MailJet();
        $subject = 'Changement de statut de votre commande';
        $title = 'Votre commande est cours de livraison';
        $content = 'Cher(e) '.$order->getUser()->getFirstname().', votre commande'.$order->getRef().'est en cours de livraison. Préparez-vous à la recevoir';
        $button = 'Suivre ma commande';
        $mailJet->send($user->getEmail(),$user->getFirstname(), $subject, $title, $content, $button);

        return $this->redirect($url);
    }

    public function delivered(AdminContext $context)
    {
        $order = $context->getEntity()->getInstance();
        $order->setStatus(4);
        $this->entityManager->flush();

        $user = $order->getUser(); //added for email purpose 
        
        $url = $this->adminUrlGenerator
            ->setController(OrderCrudController::class)
            ->setAction(Action::INDEX)
            ->generateUrl();

        // Send an order status change email
        $mailJet = new MailJet();
        $subject = 'Changement de statut de votre commande';
        $title = 'Votre commande est cours de préparation';
        $content = 'Cher(e) '.$order->getUser()->getFirstname().', Votre commande'.$order->getRef().'a été livrée';
        $button = 'Confirmez la reception';
        $mailJet->send($user->getEmail(),$user->getFirstname(), $subject, $title, $content, $button);

        return $this->redirect($url);
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['id' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateTimeField::new('createdAt', 'Passée le'),
            TextField::new('user.fullName', 'Client'),
            MoneyField::new('total', 'Total produit')->setCurrency('EUR'),
            TextField::new('carrierName', 'Mode de livraison'),
            TextEditorField::new('deliveryAddress', 'Adresse de livraison')->hideOnIndex(),
            MoneyField::new('carrierPrice', 'Frais de port')->setCurrency('EUR'),
            ChoiceField::new('status')->setChoices([
                'Non payée' => 0,
                'Payée' => 1,
                'En cours de préparation' => 2,
                'En cours de livraison' => 3,
                'Livrée' => 4
            ]),
            ArrayField::new('orderDetails', 'Articles achetés')->hideOnIndex()
        ];
    }
}
