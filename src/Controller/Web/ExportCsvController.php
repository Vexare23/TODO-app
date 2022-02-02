<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Entity\TODO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExportCsvController extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    /**
     * @Route("/export/{id}", name="app_exportcsv")
     */
    public function __invoke(TODO $todo): Response
    {
        $todo = $this->manager->getRepository(TODO::class)->find($todo->getId());

        if ($todo->getStatus()) {
            $TODOStatus = 'Already done';
        } else {
            $TODOStatus = 'To be done';
        }
        if ($todo->getAssignedTo()) {
            $TODOAssigned = $todo->getAssignedTo()->getEmail();
        } else {
            $TODOAssigned = 'Nobody';
        }

        $list = array(
            $todo->getId(),
            $todo->getName(),
            $todo->getDescription(),
            $todo->getDatetime()->format('Y-m-d H:i:s'),
            $TODOStatus,
            $TODOAssigned
        );

        $fp = fopen('php://temp', 'w');

        fputcsv($fp, array('ID', 'TODO name', 'Description', 'To be done by', 'Status', 'Assigned to'));
        fputcsv($fp, $list);
        rewind($fp);
        $response = new Response(stream_get_contents($fp));
        fclose($fp);
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="TODO.csv"');

        return $response;
    }
}
