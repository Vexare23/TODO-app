<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Entity\TODO;
use App\Form\TODOFormType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddNewTODO extends AbstractController
{
    /**
     * @Route("newTODO", name="new_TODO")
     * @throws \Exception
     */
    public function new(EntityManagerInterface $manager, Request $request): Response
    {
        $form = $this->createForm(TODOFormType::class, new TODO(), [
            'is_authenticated' => $this->isGranted('ROLE_ADMIN')
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var TODO $TODO */
            $TODO = $form->getData();


            if (!$this->isGranted('ROLE_ADMIN')) {
                $TODO->setAssignedTo(null);
            }
            $TODO->setStatus(false);

            if ($TODO->getDatetime() < new DateTime(date('Y-m-d H:i:s'))) {
                $this->addFlash('failed', 'The To be done by date cannot be in the past!');
                return $this->render(
                    'TODO/newTODO.html.twig',
                    [
                        'TODOForm' =>$form->createView(),
                    ]
                );
            }

            $manager->persist($TODO);
            $manager->flush();

            $this->addFlash('success', 'TODO added! Congrats! =D');

            return $this->redirectToRoute('homepage');
        }
        return $this->render(
            'TODO/newTODO.html.twig',
            [
                'TODOForm' =>$form->createView(),
            ]
        );
    }
}
