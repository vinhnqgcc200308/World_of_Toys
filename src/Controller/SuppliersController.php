<?php

namespace App\Controller;

use App\Entity\Suppliers;
use App\Form\SuppliersType;
use App\Repository\SuppliersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/suppliers")
 */
class SuppliersController extends AbstractController
{
    
    /**
     * @Route("/", name="app_suppliers_index", methods={"GET"})
     */
    public function index(SuppliersRepository $suppliersRepository): Response
    {
        return $this->render('suppliers/index.html.twig', [
            'suppliers' => $suppliersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_suppliers_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SuppliersRepository $suppliersRepository): Response
    {
        $supplier = new Suppliers();
        $form = $this->createForm(SuppliersType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $suppliersRepository->add($supplier);
            return $this->redirectToRoute('app_suppliers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('suppliers/new.html.twig', [
            'supplier' => $supplier,
            'form' => $form,
        ]);
    }
    
    /**
     * @Route("/{id}", name="app_suppliers_show", methods={"GET"})
     */
    public function show(Suppliers $supplier): Response
    {
        return $this->render('suppliers/show.html.twig', [
            'supplier' => $supplier,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_suppliers_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Suppliers $supplier, SuppliersRepository $suppliersRepository): Response
    {
        $form = $this->createForm(SuppliersType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $suppliersRepository->add($supplier);
            return $this->redirectToRoute('app_suppliers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('suppliers/edit.html.twig', [
            'supplier' => $supplier,
            'form' => $form,
        ]);
    }
    
    /**
     * @Route("/{id}", name="app_suppliers_delete", methods={"POST"})
     */
    public function delete(Request $request, Suppliers $supplier, SuppliersRepository $suppliersRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$supplier->getId(), $request->request->get('_token'))) {
            $suppliersRepository->remove($supplier);
        }

        return $this->redirectToRoute('app_suppliers_index', [], Response::HTTP_SEE_OTHER);
    }
}