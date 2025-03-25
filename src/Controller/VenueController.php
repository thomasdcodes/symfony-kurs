<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Venue;
use App\Form\VenueType;
use App\Repository\VenueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VenueController extends AbstractController
{
    #[Route(path: '/veranstaltungsorte', name: 'app_venue_list', methods: ['GET'])]
    public function list(VenueRepository $venueRepository): Response
    {
        $venues = $venueRepository->findAll();

        return $this->render('web/venue/list.html.twig', [
            'venues' => $venues,
        ]);
    }

    #[Route(path: '/venue/add', name: 'app_venue_add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VenueType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $entityManager->persist($data);
            $entityManager->flush();

            $this->addFlash('success', 'Veranstaltungsort erfolgreich angelegt.');

            return $this->redirectToRoute('app_venue_list');
        }

        return $this->render('web/venue/add.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(path: '/venue/{id}/edit', name: 'app_venue_edit', methods: ['GET', 'POST'])]
    public function edit(Venue $venue, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VenueType::class, $venue);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Veranstaltungsort erfolgreich bearbeitet.');

            return $this->redirectToRoute('app_venue_list');
        }

        return $this->render('web/venue/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(path: '/venue/{id}', name: 'app_venue_show', methods: ['GET'])]
    public function show(Venue $venue): Response
    {
        return $this->render('web/venue/show.html.twig', [
            'venue' => $venue,
        ]);
    }

    #[Route(path: '/venue/{id}/delete', name: 'app_venue_delete', methods: ['GET'])]
    public function delete(Venue $venue, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($venue);
        $entityManager->flush();

        $this->addFlash('success', 'Veranstaltungsort erfolgreich gelöscht.');

        return $this->redirectToRoute('app_venue_list');
    }
}