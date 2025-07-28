<?php

namespace App\Controller;

use App\Entity\Restaurante;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Dompdf\Dompdf;
use Dompdf\Options;

#[Route('/api/restaurantes')]
class RestauranteController extends AbstractController
{
    #[Route('', name: 'restaurante_list', methods: ['GET'])]
    public function list(EntityManagerInterface $em): JsonResponse
    {
        $restaurantes = $em->getRepository(Restaurante::class)->findAll();

        $data = [];

        foreach ($restaurantes as $restaurante) {
            $data[] = [
                'id' => $restaurante->getId(),
                'nombre' => $restaurante->getNombre(),
                'direccion' => $restaurante->getDireccion(),
                'telefono' => $restaurante->getTelefono(),
            ];
        }

        return $this->json($data);
    }

    #[Route('/{id}', name: 'restaurante_show', methods: ['GET'])]
    public function show(EntityManagerInterface $em, int $id): JsonResponse
    {
        $restaurante = $em->getRepository(Restaurante::class)->find($id);

        if (!$restaurante) {
            return $this->json(['error' => 'Restaurante no encontrado'], 404);
        }

        $data = [
            'id' => $restaurante->getId(),
            'nombre' => $restaurante->getNombre(),
            'direccion' => $restaurante->getDireccion(),
            'telefono' => $restaurante->getTelefono(),
        ];

        return $this->json($data);
    }

    #[Route('', name: 'restaurante_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $params = json_decode($request->getContent(), true);

        if (!isset($params['nombre'], $params['direccion'], $params['telefono'])) {
            return $this->json(['error' => 'Faltan datos'], 400);
        }

        $restaurante = new Restaurante();
        $restaurante->setNombre($params['nombre']);
        $restaurante->setDireccion($params['direccion']);
        $restaurante->setTelefono($params['telefono']);

        $em->persist($restaurante);
        $em->flush();

        return $this->json(['mensaje' => 'Restaurante creado', 'id' => $restaurante->getId()], 201);
    }

    #[Route('/{id}', name: 'restaurante_update', methods: ['PUT', 'PATCH'])]
    public function update(Request $request, EntityManagerInterface $em, int $id): JsonResponse
    {
        $restaurante = $em->getRepository(Restaurante::class)->find($id);

        if (!$restaurante) {
            return $this->json(['error' => 'Restaurante no encontrado'], 404);
        }

        $params = json_decode($request->getContent(), true);

        if (isset($params['nombre'])) {
            $restaurante->setNombre($params['nombre']);
        }
        if (isset($params['direccion'])) {
            $restaurante->setDireccion($params['direccion']);
        }
        if (isset($params['telefono'])) {
            $restaurante->setTelefono($params['telefono']);
        }

        $em->flush();

        return $this->json(['mensaje' => 'Restaurante actualizado']);
    }

    #[Route('/{id}', name: 'restaurante_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $em, int $id): JsonResponse
    {
        $restaurante = $em->getRepository(Restaurante::class)->find($id);

        if (!$restaurante) {
            return $this->json(['error' => 'Restaurante no encontrado'], 404);
        }

        $em->remove($restaurante);
        $em->flush();

        return $this->json(['mensaje' => 'Restaurante eliminado']);
    }

    // 👇 NUEVO MÉTODO PARA EXPORTAR PDF
    #[Route('/exportar-pdf', name: 'restaurante_exportar_pdf', methods: ['GET'])]
    public function exportarPDF(EntityManagerInterface $em): Response
    {
        $restaurantes = $em->getRepository(Restaurante::class)->findAll();

        $options = new Options();
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);

        $html = '<h1>Lista de Restaurantes</h1>';
        $html .= '<table border="1" cellpadding="5" cellspacing="0">';
        $html .= '<thead><tr><th>ID</th><th>Nombre</th><th>Dirección</th><th>Teléfono</th></tr></thead><tbody>';

        foreach ($restaurantes as $r) {
            $html .= '<tr>';
            $html .= '<td>' . $r->getId() . '</td>';
            $html .= '<td>' . $r->getNombre() . '</td>';
            $html .= '<td>' . $r->getDireccion() . '</td>';
            $html .= '<td>' . $r->getTelefono() . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="restaurantes.pdf"',
        ]);
    }
}
