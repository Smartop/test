<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Article;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class ArticleChanges
{
    private $fields = ['title', 'content', 'category'];
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getObject();
        if ($args->hasChangedField('title') && $args->hasChangedField('content')) {
            $this->logger->alert('Old title value - ' . $args->getOldValue('title'));
            $this->logger->alert('Old content value - ' . $args->getOldValue('content'));
            $this->logger->alert('New title value - ' . $args->getNewValue('title'));
            $this->logger->alert('New content value - ' . $args->getNewValue('content'));
        } elseif ($args->hasChangedField('title') && $entity instanceof Article) {
            $this->logger->alert('Old title value - ' . $args->getOldValue('title'));
            $this->logger->alert('New title value - ' . $args->getNewValue('title'));
        } elseif ($args->hasChangedField('content') && $entity instanceof Article) {
            $this->logger->alert('Old content value - ' . $args->getOldValue('content'));
            $this->logger->alert('New content value - ' . $args->getNewValue('content'));
        }

        $entityManager = $args->getObjectManager();
    }

}