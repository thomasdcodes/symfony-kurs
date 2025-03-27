<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Appointment;
use App\Service\PdfGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Attribute\Route;

class PdfGeneratorController extends AbstractController
{
    #[Route(path: '/generate-appointment-pdf/{id}', name: 'app_pdf_generator_generate_appointment_pdf', methods: ['GET'])]
    public function generateAppointmentPdf(Appointment $appointment, PdfGenerator $pdfGenerator): BinaryFileResponse
    {
        $view = $this->renderView('pdf/appointment/detail.html.twig', [
            'appointment' => $appointment,
        ]);

        $output = $pdfGenerator->generate($view);
        $tmpFile = tempnam(sys_get_temp_dir(), 'pdf_');
        file_put_contents($tmpFile, $output);

        $binFileResp = new BinaryFileResponse($tmpFile);
        $binFileResp->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            sprintf('PDF-Appointment-%d.pdf', $appointment->getId())
        );

        return $binFileResp;
    }
}