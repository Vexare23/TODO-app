<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Entity\TODO;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowTODO extends AbstractController
{
    /**
     * @Route("TODO/{id}", name="TODO_show")
     */
    public function __invoke($id, ManagerRegistry $manager): Response
    {
        $repository = $manager->getRepository(TODO::class);
        $TODO = $repository->findOneBy(['id' => $id]);
        if (!$TODO) {
            throw $this->createNotFoundException(
                'No TODO found for id '.$id
            );
        }

        return $this->render('TODO/ShowTODO.html.twig', [
            'TODO' => $TODO,
        ]);
    }
}
