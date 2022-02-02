<?php

namespace App\Controller\API;

use App\Entity\TODO;
use App\Form\ApiTODOFormType;
use App\Serializer\ApiSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditTODO extends AbstractController
{
    #[Route('api/editTODO/{id}', methods: ['PUT'])]
    public function new($id, EntityManagerInterface $manager, Request $request, ApiSerializer $apiSerializer): Response
    {
        $repository = $manager->getRepository(TODO::class);
        $TODO = $repository->findOneBy(['id' => $id]);

        if (!$TODO) {
            throw $this->createNotFoundException(sprintf(
                'No TODO found for this id "%s"',
                $TODO
            ));
        }

        $body = $request->getContent();
        $data = json_decode($body,true);


        $form = $this->createForm(ApiTODOFormType::class, $TODO);

        $form->submit($data);

        $manager->persist($TODO);
        $manager->flush();

        $data = $apiSerializer->serializeTODO($TODO);

        $response = new Response(json_encode($data), 200);
        $response->headers->set('Content-Type', 'application/Json');

        return $response;
    }
}
