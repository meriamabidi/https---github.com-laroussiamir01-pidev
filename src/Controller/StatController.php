<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use App\Entity\Favoris;
use App\Entity\Medecin;
use App\Form\MedecinType;
use App\Repository\FavorisRepository;
use App\Repository\MedecinRepository;
use Doctrine\ORM\EntityManagerInterface;

class StatController extends AbstractController
{
   /* #[Route('/stat', name: 'app_stat')]
    public function index(): Response
    {
        return $this->render('stat/index.html.twig', [
            'controller_name' => 'StatController',
        ]);
    }*/

     /**
     * @Route("/stats1", name="stats")
     */
    public function statistiques1(FavorisRepository $FavorisRepository){
        // On va chercher toutes les menus
        $medecin = $FavorisRepository->findAll();

//Data Category
        $chahra = $FavorisRepository->createQueryBuilder('a')
            ->select('count(a.id)')
            ->Where('a.note= :note')
            ->setParameter('note',"10")
            ->getQuery()
            ->getSingleScalarResult();

        $oui = $FavorisRepository->createQueryBuilder('a')
            ->select('count(a.id)')
            ->Where('a.note= :note')
            ->setParameter('note',"20")
            ->getQuery()
            ->getSingleScalarResult();




        return $this->render('stat/stats1.html.twig', [
            'liv' => $chahra,
            'cl' => $oui,



        ]);

    }
}
