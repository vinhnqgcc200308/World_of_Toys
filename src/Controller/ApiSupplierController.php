<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class ApiSupplierController
 * @Route("/api",name="api_")
 */
class ApiSupplierController extends AbstractController
{
    /**
     * @Route('/supplier', name= 'app_api_supplier', methods={"GET"})
     */
    public function index(): Response
    {
        $supplier = $this->getDoctrine()
            ->getRepository('Supplier::class')
            ->findAll();

        $data = [];
        
        foreach ($supplier as $supp){
            $data[] = [
                'id' => $supp->getId(),
                'name' => $supp->getName(),
                'supplier_nation' => $supp->getSupplierNation(),
            ];
        }
        return $this->json($data);
    }

    /**
     * @Route("/supplier/{id}", name="supplier_show", methods={"GET"})
     */
    public function show(int $id): Response{
        $supplier = $this->getDoctrine()
            ->getRepository(Supplier::class)
            ->find($id);
        if (!$supplier) {
            return $this->json('No Supplier found.');
        }

        $data = [
            'id' => $supp->getId(),
            'name' => $supp->getName(),
            'supplier_nation' => $supp->getSupplierNation(),
        ];
    }
    /**
     * @Route("/suppliers", name="suppliers_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $supplier = new Supplier();
        $supplier->setName($request->request->get('name'));
        $supplier->setDescription($request->request->get('description'));

        $entityManager->persist($supplier);
        $entityManager->flush();

        return $this->json('Created new suppler successfully');
    }
}