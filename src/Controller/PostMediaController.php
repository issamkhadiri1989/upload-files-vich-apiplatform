<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\MediaObject;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class PostMediaController extends AbstractController
{
    public function __construct(private EntityManagerInterface $manager, private NormalizerInterface $serializer)
    {
    }

    public function __invoke(Request $request)
    {
//        $cover = $request->files->

        $entity = new MediaObject();
        $entity->filePath = "https://api-platform.com/images/con/logo.svg";
        $this->manager->persist($entity);
        $this->manager->flush();

        return $this->serializer->normalize($entity, 'json');

    }
}
