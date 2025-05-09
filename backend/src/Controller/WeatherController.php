<?php

namespace App\Controller;

use App\Entity\Weather;
use App\Repository\WeatherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/api/weather')]
final class WeatherController extends AbstractController
{

    #[Route('/show', name: 'weather', methods: ['GET'])]
    public function index(WeatherRepository $weatherRepository): Response
    {
        $weatherData = $weatherRepository->findAll();

        $data = array_map(function ($weather) {
            return [
                'id' => $weather->getId(),
                'city' => $weather->getCity(),
                'country' => $weather->getCountry(),
                'lat' => $weather->getLat(),
                'lon' => $weather->getLon(),
                'temperature' => $weather->getTemperature(),
                'humidity' => $weather->getHumidity(),
            ];
        }, $weatherData);

    return new JsonResponse($data);
    }

    #[Route('/new', name: 'weather_new', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new JsonResponse(['error' => 'Données invalides'], 400);
        }

        $weather = new Weather();
        $weather->setCity($data['city'] ?? '');
        $weather->setCountry($data['country'] ?? '');
        $weather->setLat($data['lat'] ?? 0);
        $weather->setLon($data['lon'] ?? 0);
        $weather->setTemperature($data['temperature'] ?? 0);
        $weather->setHumidity($data['humidity'] ?? 0);

        $em->persist($weather);
        $em->flush();

        return new JsonResponse(['success' => true], 201);
    }

    #[Route('/update/{id}', name: 'update_weather', methods: ['PUT'])]
    public function update(Request $request, Weather $weather, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $weather->setCity($data['city']);
        $weather->setCountry($data['country']);
        $weather->setLat($data['lat']);
        $weather->setLon($data['lon']);
        $weather->setTemperature($data['temperature']);
        $weather->setHumidity($data['humidity']);

        $em->flush();

        return new JsonResponse(['success' => true]);
    }


    #[Route('/{id}', name: 'weather_delete', methods: ['DELETE'])]
    public function delete(Weather $weather, EntityManagerInterface $em): Response
    {
        try {
            $em->remove($weather);
            $em->flush();
            return new Response(null, Response::HTTP_NO_CONTENT);
        } catch (\Throwable $e) {
            return new Response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

}
