<?php

namespace App\Controller\API;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;
    private EntityManagerInterface $entityManager;

    public function __construct(EmailVerifier $emailVerifier, EntityManagerInterface $entityManager)
    {
        $this->emailVerifier = $emailVerifier;
        $this->entityManager = $entityManager;
    }

    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function __invoke(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $body = $request->getContent();
        $data = json_decode($body, true);

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->submit($data);

        $user->setPassword(
            $userPasswordHasher->hashPassword(
                $user,
                $form->get('plainPassword')->getData()
            )
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->emailVerifier->sendEmailConfirmation(
            'app_verify_email',
            $user,
            (new TemplatedEmail())
                ->from(new Address('admin@example.com', 'TODO Bot'))
                ->to($user->getEmail())
                ->subject('Please Confirm your Email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
        );

        return new Response($body, 200);
    }
}
