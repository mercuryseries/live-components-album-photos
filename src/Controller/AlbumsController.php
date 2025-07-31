<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Photo;
use App\Form\AlbumType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AlbumsController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $album = new Album();
        $album->addPhoto(new Photo());

        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($form->getData());
            $entityManager->flush();
            $this->addFlash('success', 'Excellent! Album created.');

            return $this->redirectToRoute('app_albums_show', [
                'id' => $album->getId(),
            ]);
        }

        return $this->render('albums/new.html.twig', [
            'form' => $form,
            'album' => $album
        ]);
    }

    #[Route('/albums/{id}', name: 'app_albums_show', methods: ['GET'])]
    public function show(Album $album)
    {
        return $this->render('albums/show.html.twig', [
            'album' => $album
        ]);
    }
}
