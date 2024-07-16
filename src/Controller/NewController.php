<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class NewController extends AbstractController
{

  #[Route('api/news/{id}', name: 'api_new', methods: ['GET'])]
  public function getNew(int $id=null): Response
  {
    // TODO - cirar uma query real
    $new= [
      'id' => $id,
      'title' => 'pré treino ta batendo rs'
    ];
    return new JsonResponse($new);
  }
}