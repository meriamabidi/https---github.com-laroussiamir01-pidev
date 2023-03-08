<?php

namespace App\Controller;

use App\Entity\Appreciation;
use App\Form\AppreciationType;
use App\Repository\AppreciationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/appreciation')]
class AppreciationController extends AbstractController
{
    #[Route('/', name: 'app_appreciation_index', methods: ['GET'])]
    public function index(AppreciationRepository $appreciationRepository): Response
    {
        return $this->render('appreciation/index.html.twig', [
            'appreciations' => $appreciationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_appreciation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AppreciationRepository $appreciationRepository): Response
    {
        $appreciation = new Appreciation();
        $form = $this->createForm(AppreciationType::class, $appreciation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $appreciationRepository->save($appreciation, true);

            return $this->redirectToRoute('app_appreciation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('appreciation/new.html.twig', [
            'appreciation' => $appreciation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_appreciation_show', methods: ['GET'])]
    public function show(Appreciation $appreciation): Response
    {
        return $this->render('appreciation/show.html.twig', [
            'appreciation' => $appreciation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_appreciation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Appreciation $appreciation, AppreciationRepository $appreciationRepository): Response
    {
        $form = $this->createForm(AppreciationType::class, $appreciation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $appreciationRepository->save($appreciation, true);

            return $this->redirectToRoute('app_appreciation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('appreciation/edit.html.twig', [
            'appreciation' => $appreciation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_appreciation_delete', methods: ['POST'])]
    public function delete(Request $request, Appreciation $appreciation, AppreciationRepository $appreciationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appreciation->getId(), $request->request->get('_token'))) {
            $appreciationRepository->remove($appreciation, true);
        }

        return $this->redirectToRoute('app_appreciation_index', [], Response::HTTP_SEE_OTHER);
    }
}
