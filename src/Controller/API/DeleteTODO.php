<?php

namespace App\Controller\API;

use App\Entity\TODO;
use App\Serializer\ApiSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteTODO extends AbstractController
{
    #[Route('api/deleteTODO/{id}', methods: ['DELETE'])]
    public function new($id, EntityManagerInterface $manager, Request $request, ApiSerializer $apiSerializer): Response
    {
        $repository = $manager->getRepository(TODO::class);
        $TODO = $repository->findOneBy(['id' => $id]);

        if ($TODO && $this->isGranted('ROLE_ADMIN')) {
            $manager->remove($TODO);
            $manager->flush();
        }

        return new Response(null, 204);
    }
}
