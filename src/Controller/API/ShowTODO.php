<?php

namespace App\Controller\API;

use App\Entity\TODO;
use App\Serializer\ApiSerializer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowTODO extends AbstractController
{
    #[Route('api/showTODO/{id}', name: 'api_TODO_show', methods: 'GET')]
    public function new($id, ManagerRegistry $manager, ApiSerializer $apiSerializer): Response
    {
        $repository = $manager->getRepository(TODO::class);
        $TODO = $repository->findOneBy(['id' => $id]);

        if (!$TODO) {
            throw $this->createNotFoundException(sprintf(
                'No TODO found for this id "%s"',
                $TODO
            ));
        }

        $data = $apiSerializer->serializeTODO($TODO);

        $response = new Response(json_encode($data));

        $response->headers->set('Content-Type', 'application/Json');

        return $response;
    }
}
