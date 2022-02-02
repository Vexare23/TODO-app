<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Entity\TODO;
use App\Form\EditTODOFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditTODO extends AbstractController
{
    /**
     * @Route("editTODO/{id}", name="edit_TODO")
     */
    public function new(TODO $TODO, EntityManagerInterface $manager, Request $request): Response
    {
        if ($TODO->getStatus() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('A TODO that was finished cannot be edited! For more information, please contact the 
                administrator at:admin@admin.com');
        } else {
            $form = $this->createForm(EditTODOFormType::class, $TODO, [
                'is_authenticated' => $this->isGranted('ROLE_ADMIN')
            ]);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                /** @var TODO $TODO */
                $TODO = $form->getData();

                $manager->persist($TODO);
                $manager->flush();

                $this->addFlash('success', 'TODO updated! Congrats! =D');

                return $this->redirectToRoute('homepage');
            }
        }
        return $this->render(
            'TODO/editTODO.html.twig',
            [
                'TODOForm' => $form->createView(),
            ]
        );
    }
}
