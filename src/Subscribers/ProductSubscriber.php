<?php


namespace App\Subscribers;

use DateTime;
use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProductSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['SetDates']
        ];
    }

    public function SetDates(BeforeEntityPersistedEvent $event) {
    $entity = $event->getEntityInstance();
    if($entity instanceof Product) {
        $entity->setCreatedAt(new DateTime('now'));
        $entity->setUpdatedAt(new DateTime('now'));
    }
    }

}