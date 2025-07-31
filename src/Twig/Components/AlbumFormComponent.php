<?php

namespace App\Twig\Components;

use App\Entity\Album;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('album_form')]
final class AlbumFormComponent
{
    use DefaultActionTrait;

    public ?Album $album = null;

    public function mount()
    {
        $this->album ??= new Album();
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->formFactory->create(AlbumType::class, $this->album);
    }
}
