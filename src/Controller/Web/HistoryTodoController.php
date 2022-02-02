<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Entity\TODO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoryTodoController extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/record/todo/{id}", name="app_record")
     */
    public function __invoke(TODO $todo): Response
    {
        $todo = $this->manager->getRepository(TODO::class)->find($todo->getId());

        $recordRepo = $this->manager->getRepository('Gedmo\Loggable\Entity\LogEntry');
        $records = $recordRepo->getLogEntries($todo);

        $name = $description = $datetime = $status = null;

        foreach ($records as $data) {
            $action = $data->getAction();
            $data = $data->getData();

            if (isset($data['name'])) {
                $name = $data['name'];
            }

            if (isset($data['description'])) {
                $description = $data['description'];
            }

            if (isset($data['status'])) {
                $status = $data['status'];
            }

            if (isset($data['datetime'])) {
                $datetime = $data['datetime'];
            }

            $variables = [
                'action' => $action,
                'name' => $name,
                'description' => $description,
                'status' => $status,
                'datetime' => $datetime
            ];

            $datas[] = $variables;
        }

        return $this->render('TODO/records.html.twig', [
            'todo' => $todo,
            'datas' => $datas
        ]);
    }
}
