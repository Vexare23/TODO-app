<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Entity\TODO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarkTODOAsDone extends AbstractController
{
    /**
     * @Route("TODOAsDone/{id}", name="TODOAsDone")
     */
    public function __invoke($id, TODO $TODO, EntityManagerInterface $manager): Response
    {
        $repository = $manager->getRepository(TODO::class);
        $TODO = $repository->findOneBy(['id' => $id]);
        if (!$TODO) {
            throw $this->createNotFoundException(
                'No TODO found for id '.$id
            );
        }
        if ($TODO->getStatus() && $TODO->getAssignedTo() != null) {
            $TODO->setStatus(true);
            $this->addFlash('success', 'TODO status updated! Congrats! =D');
            $manager->persist($TODO);
            $manager->flush();
        }

        return $this->redirectToRoute('homepage');
    }
}
