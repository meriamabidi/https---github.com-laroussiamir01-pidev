<?php

namespace App\Controller;

use App\Entity\Operations;
use App\Form\Operations1Type;
use App\Repository\OperationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/operations')]
class OperationsController extends AbstractController
{
    #[Route('/', name: 'app_operations_index', methods: ['GET'])]
    public function index(OperationsRepository $operationsRepository): Response
    {
        return $this->render('operations/index.html.twig', [
            'operations' => $operationsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_operations_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OperationsRepository $operationsRepository,SluggerInterface $slugger): Response
    {
        $operation = new Operations();
        $form = $this->createForm(Operations1Type::class, $operation);
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

           
                $operation->setImage($newFilename);
            }
            $operationsRepository->save($operation, true);

            return $this->redirectToRoute('app_operations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('operations/new.html.twig', [
            'operation' => $operation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_operations_show', methods: ['GET'])]
    public function show(Operations $operation): Response
    {
        return $this->render('operations/show.html.twig', [
            'operation' => $operation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_operations_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Operations $operation, OperationsRepository $operationsRepository,SluggerInterface $slugger): Response
    {
        $form = $this->createForm(Operations1Type::class, $operation);
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

           
                $operation->setImage($newFilename);
            }
            $operationsRepository->save($operation, true);

            return $this->redirectToRoute('app_operations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('operations/edit.html.twig', [
            'operation' => $operation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_operations_delete', methods: ['POST'])]
    public function delete(Request $request, Operations $operation, OperationsRepository $operationsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$operation->getId(), $request->request->get('_token'))) {
            $operationsRepository->remove($operation, true);
        }

        return $this->redirectToRoute('app_operations_index', [], Response::HTTP_SEE_OTHER);
    }
}
