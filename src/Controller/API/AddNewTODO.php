<?php

namespace App\Controller\API;

use App\Entity\TODO;
use App\Form\ApiTODOFormType;
use App\Serializer\ApiSerializer;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddNewTODO extends AbstractController
{
    #[Route('api/newTODO', methods: ['POST'])]
    public function new(EntityManagerInterface $manager, Request $request, ApiSerializer $apiSerializer): Response
    {
        $body = $request->getContent();
        $data = json_decode($body,true);
        $TODO = new TODO();
        $datetime = new DateTime();
        $newDate = $datetime->createFromFormat('d/m/Y', $data['datetime']);

        $form = $this->createForm(ApiTODOFormType::class, $TODO);

        $TODO->setDatetime($newDate);
        $TODO->setName($data['name']);
        $TODO->setDescription($data['description']);
        $TODO->setAssignedTo(null);

        $form->submit($data);

        $manager->persist($TODO);
        $manager->flush();

        $data = $apiSerializer->serializeTODO($TODO);
        $response = new Response(json_encode($data), 201);
        $response->headers->set('Content-Type', 'application/Json');

        $location = $this->generateUrl('api_TODO_show', [
            'id' => $TODO->getId()
        ]);
        $response->headers->set('Location', $location);

        return $response;
    }
}
