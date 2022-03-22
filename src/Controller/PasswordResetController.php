<?php

namespace App\Controller;

use App\Entity\User;
use DateTimeImmutable;
use App\Service\MailJet;
use App\Entity\PasswordReset;
use App\Form\PasswordResetType;
use Doctrine\SqlFormatter\Token;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordResetController extends AbstractController
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/mot-de-passe-oublie', name: 'forgotten_password')]
    public function index(Request $request): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('account');
        }

        if ($request->get('email')){
            $user = $this->entityManager->getRepository(User::class)->findOneByEmail($request->get('email'));
            if ($user){
                // Store password reset request in db with user, token, createdAt
                $passwordReset = new PasswordReset();
                $passwordReset->setUser($user);
                $passwordReset->setToken(uniqid());
                $passwordReset->setCreatedAt(new DateTimeImmutable());
                $this->entityManager->persist($passwordReset);
                $this->entityManager->flush();
                
                //Send the user an email with a password reset link/button
                $url = $this->generateUrl('password_reset', [
                    'token' => $passwordReset->getToken()
                ]);

                $mailJet = new MailJet();
                $subject = 'Réinitialisation de votre mot de passe sur DDD';
                $title = 'Vous avez demandé à réinitialiser votre mot de passe ?';
                $content = 'Bonjour '.$user->getFirstname().', vous avez oublié votre mot de passe ? Pas de panique. Pour retrouver l\'accès à votre compte cliquez sur Réinitialiser.';
                $button = '<a href="'.$url.'">Réinitialiser</a>';
                $mailJet->send($user->getEmail(),$user->getFullName(), $subject, $title, $content, $button);
                $this ->addFlash('notice', 'Un email contenant un lien de réinitialisation vient de vous être envoyé. Consultez votre boite mail.');        
            }else{
                $this ->addFlash('notice', 'Adresse inconnue.');
            }  
        }
        return $this->render('password_reset/forgotten.html.twig');
    }

    #[Route('/reinitialiser-mot-de-passe/{token}', name: 'password_reset')]
    public function reset(Request $request,$token, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $passwordReset = $this->entityManager->getRepository(PasswordReset::class)->findOneByToken($token);
        if (!$passwordReset) { // if there is no passwordReset object in the db
            return $this->redirectToRoute('forgotten_password');// redirect to forgotten password page
        }
        
        // Check if the link is still valide
        $now = new DateTimeImmutable(); // this will give us the current datetime the we store in $now
        if ($now > $passwordReset->getCreatedAt()->modify('+ 3 hour')){ // if the createdAt object in the data base + 3 hours is inferior to now
            $this ->addFlash('notice', 'Votre demande de réinitialisatin de mot de passe a expiré. Merci de rééssayer.');
            return $this->redirectToRoute('forgotten_password');
        }
        
        $form = $this->createForm(PasswordResetType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $new_password = $form->get('new_password')->getData();
            
            //hash password
            $password = $userPasswordHasher->hashPassword($passwordReset->getUser(), $new_password);
            $passwordReset->getUser()->setpassword($password);

            //flush data into db
            // $this->entityManager->persist($user); // no need for a persist as it is a data update and not a creation
            $this->entityManager->flush();
            
            //redirect to login page
            $this->addFlash('notice','Votre mot de passe a bien été modifié.');
            return $this->redirectToRoute('app_login');
        }
        return $this->render('password_reset/reset.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
