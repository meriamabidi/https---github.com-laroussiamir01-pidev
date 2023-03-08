<?php

namespace App\Controller;

use App\Entity\Hospitalisation;
use App\Form\HospitalisationType;
use App\Repository\HospitalisationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/hospitalisation')]
class HospitalisationController extends AbstractController
{
    #[Route('/', name: 'app_hospitalisation_index', methods: ['GET'])]
    public function index(HospitalisationRepository $hospitalisationRepository): Response
    {
        return $this->render('hospitalisation/index.html.twig', [
            'hospitalisations' => $hospitalisationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_hospitalisation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HospitalisationRepository $hospitalisationRepository): Response
    {
        $hospitalisation = new Hospitalisation();
        $form = $this->createForm(HospitalisationType::class, $hospitalisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hospitalisationRepository->save($hospitalisation, true);

            return $this->redirectToRoute('app_hospitalisation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hospitalisation/new.html.twig', [
            'hospitalisation' => $hospitalisation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hospitalisation_show', methods: ['GET'])]
    public function show(Hospitalisation $hospitalisation): Response
    {
        return $this->render('hospitalisation/show.html.twig', [
            'hospitalisation' => $hospitalisation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_hospitalisation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Hospitalisation $hospitalisation, HospitalisationRepository $hospitalisationRepository): Response
    {
        $form = $this->createForm(HospitalisationType::class, $hospitalisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hospitalisationRepository->save($hospitalisation, true);

            return $this->redirectToRoute('app_hospitalisation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hospitalisation/edit.html.twig', [
            'hospitalisation' => $hospitalisation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hospitalisation_delete', methods: ['POST'])]
    public function delete(Request $request, Hospitalisation $hospitalisation, HospitalisationRepository $hospitalisationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hospitalisation->getId(), $request->request->get('_token'))) {
            $hospitalisationRepository->remove($hospitalisation, true);
        }

        return $this->redirectToRoute('app_hospitalisation_index', [], Response::HTTP_SEE_OTHER);
    }
}
