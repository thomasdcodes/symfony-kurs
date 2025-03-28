<?php

namespace App\Controller\Api;

use App\Repository\AppointmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class AppointmentController extends AbstractController
{

    #[Route(path: '/api/appointments', name: 'api_appointment_index', methods: ['GET'])]
    public function index(AppointmentRepository $appointmentRepository, NormalizerInterface $normalizer): JsonResponse
    {
        $appointments = $appointmentRepository->findAll();
        $normalizedAppointments = [];

        foreach ($appointments as $appointment) {
            $normalizedAppointments[] = $normalizer->normalize($appointment, null, ['groups' => ['appointment']]);
        }

        return $this->json($normalizedAppointments);
    }
}