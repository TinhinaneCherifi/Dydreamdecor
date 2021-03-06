<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Service\MailJet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User(); // Instenciation de la classe User
        $form = $this->createForm(RegistrationFormType::class, $user); // On crée le forme en indiquant à la méthode createForm qu"il faut utiliser le modèle RegistrationFormType
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encoder le mot de passe
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // envoyer un email de confirmation 
                $mailJet = new MailJet();
                $subject = 'Confirmation de votre inscription';
                $title = 'Bienvenue';
                $content = 'Cher(e) '.$user->getFirstname().' Nous sommes ravis de vous compter parmi nous';
                $button = 'Accédez à mon compte';
                $mailJet->send($user->getEmail(),$user->getFullName(), $subject, $title, $content, $button);

            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
