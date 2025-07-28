<?php

namespace App\Controller;

use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UsuarioController extends AbstractController
{
    #[Route('/api/register', name: 'usuario_register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['email']) || empty($data['password'])) {
            return $this->json(['error' => 'Email y password son obligatorios'], 400);
        }

        // Verificar si el usuario ya existe
        $existingUser = $em->getRepository(Usuario::class)->findOneBy(['email' => $data['email']]);
        if ($existingUser) {
            return $this->json(['error' => 'El usuario ya existe'], 409);
        }

        $usuario = new Usuario();
        $usuario->setEmail($data['email']);
        $hashedPassword = $passwordHasher->hashPassword($usuario, $data['password']);
        $usuario->setPassword($hashedPassword);
        $usuario->setRoles(['ROLE_USER']);

        $em->persist($usuario);
        $em->flush();

        return $this->json(['mensaje' => 'Usuario registrado correctamente'], 201);
    }

    #[Route('/api/login', name: 'usuario_login', methods: ['POST'])]
    public function login(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['email']) || empty($data['password'])) {
            return $this->json(['error' => 'Email y password son obligatorios'], 400);
        }

        $usuario = $em->getRepository(Usuario::class)->findOneBy(['email' => $data['email']]);
        if (!$usuario) {
            return $this->json(['error' => 'Usuario no encontrado'], 404);
        }

        if (!$passwordHasher->isPasswordValid($usuario, $data['password'])) {
            return $this->json(['error' => 'Contraseña incorrecta'], 401);
        }

        return $this->json(['mensaje' => 'Login correcto']);
    }
}
