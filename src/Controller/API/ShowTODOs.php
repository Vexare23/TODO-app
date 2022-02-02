<?php

namespace App\Controller\API;

use App\Serializer\ApiSerializer;
use App\Entity\TODO;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowTODOs extends AbstractController
{
    #[Route('api/showTODOs', name: 'api_TODOs_show', methods: 'GET')]
    public function new(ManagerRegistry $manager, ApiSerializer $apiSerializer): Response
    {
        $repository = $manager->getRepository(TODO::class);
        $TODOs = $repository->findAll();

        $data = ['TODO' => []];
        foreach ($TODOs as $TODO) {
            $data['TODO'][] = $apiSerializer->serializeTODO($TODO);
        }
        $response = new Response(json_encode($data));

        $response->headers->set('Content-Type', 'application/Json');

        return $response;
    }

}
