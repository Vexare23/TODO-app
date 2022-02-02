<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Repository\TODORepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function __invoke(Request $request, TODORepository $TODORepository): Response
    {
        $query = $TODORepository->createQueryBuilder('t');

        if ($request->query->has('status') && $request->query->get('status') === 'open') {
            $query->andWhere('t.status = 0');
        } elseif ($request->query->has('status') && $request->query->get('status') === 'done') {
            $query->andWhere('t.status = 1');
        } else {
            $query->andWhere('t.status = 0');
        }

        $query = $query->getQuery();

        $items = $query->execute();

        return $this->render('index/index.html.twig', [
            'TODOs' => $items,
        ]);
    }
}
