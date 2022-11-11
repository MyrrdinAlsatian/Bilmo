<?php

namespace App\Events;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\Product;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ProductSubscriber implements EventSubscriberInterface
{
    static function getSubscribedEvents(): array
    {
        return[
            KernelEvents::VIEW =>['prePersist', EventPriorities::PRE_WRITE]
        ];
    }

    public function prePersist(ViewEvent $event):void
    {
            $entity = $event->getControllerResult();
            $method = $event->getRequest()->getMethod();

        if($entity instanceof Product && $method === 'POST')
        {
            $entity->setCreatedAt(new \DateTimeImmutable());
        }
    }
}