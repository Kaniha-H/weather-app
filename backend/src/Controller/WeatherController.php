<?php

namespace App\Controller;

use App\Entity\Weather;
use App\Form\WeatherForm;
use App\Repository\WeatherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/weather')]
final class WeatherController extends AbstractController
{
    #[Route('', name: 'weather', methods: ['GET'])]
    public function index(WeatherRepository $weatherRepository): Response
    {
        return $this->render('weather/index.html.twig', [
            'weather' => $weatherRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'weather_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $weather = new Weather();
        $form = $this->createForm(WeatherForm::class, $weather);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($weather);
            $em->flush();

            return $this->redirectToRoute('weather', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('weather/new.html.twig', [
            'weather' => $weather,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'weather_show', methods: ['GET'])]
    public function show(Weather $weather): Response
    {
        return $this->render('weather/show.html.twig', [
            'weather' => $weather,
        ]);
    }

    #[Route('/{id}/edit', name: 'weather_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Weather $weather, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(WeatherForm::class, $weather);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('weather', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('weather/edit.html.twig', [
            'weather' => $weather,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'weather_delete', methods: ['POST'])]
    public function delete(Request $request, Weather $weather, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$weather->getId(), $request->getPayload()->getString('_token'))) {
            $em->remove($weather);
            $em->flush();
        }

        return $this->redirectToRoute('weather', [], Response::HTTP_SEE_OTHER);
    }
}
