<?php

namespace AppBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use AppBundle\Entity\Book;

class BookManager
{
    protected $kernel_root_dir;
    protected $objectManager;
    protected $repository;
    protected $tokenStorage;

    public function __construct($kernel_root_dir, ObjectManager $objectManager, TokenStorageInterface $tokenStorage)
    {
        $this->objectManager = $objectManager;
        $this->repository = $objectManager->getRepository('AppBundle:Book');
        $this->tokenStorage = $tokenStorage;
        $this->kernel_root_dir = $kernel_root_dir;
    }

    public function save(Book $book)
    {
        $book->setUser($this->tokenStorage->getToken()->getUser());

        //upload coverImg
        $book->setCoverImg($this->upload($book->getCoverImg(), $book->getName()));

        //upload enetity images
        foreach ($book->getBookImages() as $bookImage) {
            if ($bookImage->getFilename()) {
                $bookImage->setFilename($this->upload($bookImage->getFilename()));
            }
        }
        $this->objectManager->persist($book);
        $this->objectManager->flush();
    }

    public function upload($file, $filename = '')
    {
        $filename .= '_'.md5(uniqid()).'.'.$file->guessExtension();
        $fileDir = $this->kernel_root_dir.'/../web/uploads/files';
        $file->move($fileDir, $filename);
        return $filename;
    }
}