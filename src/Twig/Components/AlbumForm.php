<?php

namespace App\Twig\Components;

use App\Entity\Album;
use App\Form\AlbumType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\LiveCollectionTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent]
final class AlbumForm extends AbstractController
{
    use DefaultActionTrait;
    use LiveCollectionTrait;

    #[LiveProp(fieldName: 'formData')]
    public ?Album $album = null;

    // public function mount()
    // {
    //     $this->album ??= new Album();
    // }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(AlbumType::class, $this->album);
    }

    public function handleSubmit(EntityManagerInterface $em)
    {
        if (!$this->form->isValid()) {
            return;
        }

        foreach ($this->album->getPhotos() as $photo) {
            $photo->setAlbum($this->album);
        }

        $em->persist($this->album);
        $em->flush();
    }
}
