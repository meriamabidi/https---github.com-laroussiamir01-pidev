<?php

namespace App\Controller;

use App\Entity\Favoris;
use App\Entity\Medecin;
use App\Form\MedecinType;
use App\Repository\MedecinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Transport\Serialization\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

#[Route('/medecin')]
class MedecinController extends AbstractController
{
    #[Route('/back', name: 'app_medecin_index', methods: ['GET'])]
    public function index(MedecinRepository $medecinRepository): Response
    {
        return $this->render('medecin/index.html.twig', [
            'medecins' => $medecinRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_medecin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MedecinRepository $medecinRepository,SluggerInterface $slugger): Response
    {
        $medecin = new Medecin();
        $form = $this->createForm(MedecinType::class, $medecin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imgFile = $form->get('photo')->getData();

            if ($imgFile) {
                $originalFilename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imgFile->guessExtension();

               try {
                    $imgFile->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

           
                $medecin->setPhoto($newFilename);
            }
            $medecinRepository->save($medecin, true);


            

            $this->addFlash(
                'info',
                'Medecin ajoutée avec succés!'
            );

        
            return $this->redirectToRoute('app_medecin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medecin/new.html.twig', [
            'medecin' => $medecin,
            'form' => $form,
        ]);
    }

    #[Route('/front', name: 'app_medecin_listdoctors', methods: ['GET'])]
    public function listmedecins(MedecinRepository $medecinRepository): Response
    {
        return $this->render('medecin/listdoctors.html.twig', [
            'medecins' => $medecinRepository->findAll(),
        ]);
      
    }

    #[Route('/{id}', name: 'app_medecin_show', methods: ['GET'])]
    public function show(Medecin $medecin): Response
    {  $this->addFlash(
        'info',
        'Medecin ajoutée avec succés!'
    );
        return $this->render('medecin/show.html.twig', [
            'medecin' => $medecin,
        ]);
    }
    #[Route('operation/{id}', name: 'app_medecin_showOperations', methods: ['GET'])]
    public function showOperations(Medecin $medecin): Response
    {
        return $this->render('medecin/showOperations.html.twig', [
            'medecin' => $medecin,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_medecin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Medecin $medecin, MedecinRepository $medecinRepository,SluggerInterface $slugger): Response
    {
        $form = $this->createForm(MedecinType::class, $medecin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imgFile = $form->get('photo')->getData();

            if ($imgFile) {
                $originalFilename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imgFile->guessExtension();

               try {
                    $imgFile->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

           
                $medecin->setPhoto($newFilename);
            }
            
            $medecinRepository->save($medecin, true);

            return $this->redirectToRoute('app_medecin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medecin/edit.html.twig', [
            'medecin' => $medecin,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_medecin_delete', methods: ['POST'])]
    public function delete(Request $request, Medecin $medecin, MedecinRepository $medecinRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medecin->getId(), $request->request->get('_token'))) {
            $medecinRepository->remove($medecin, true);
        }

        return $this->redirectToRoute('app_medecin_index', [], Response::HTTP_SEE_OTHER);
    }
   
    
    
      #[Route('/TriernomASC/back', name:'trie',methods:['GET'])]
     
    public function Triernom1(Request $request, MedecinRepository $MedRepository): Response
    {
        $MedRepository = $this->getDoctrine()->getRepository(Medecin::class);
        $medecin = $MedRepository->triernom1();

        return $this->render('medecin/index.html.twig', [
            'medecins' => $medecin,
        ]);
    }
  
    
    #[Route('/TriernomDESC/back', name:'triee',methods:['GET'])]
    public function Triernom2(Request $request, MedecinRepository $MedRepository): Response
    {
        $MedRepository = $this->getDoctrine()->getRepository(Medecin::class);
        $medecin = $MedRepository->triernom2();

        return $this->render('medecin/index.html.twig', [
            'medecins' => $medecin,
        ]);
    }
}