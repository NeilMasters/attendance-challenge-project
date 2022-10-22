<?php
declare(strict_types=1);

namespace Attendance\Events\Listener\Logging;

use Attendance\Entity\ApiRequestLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Uid\Uuid;

class ApiLogListener
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $this->entityManager->persist(new ApiRequestLog(
            id: (string)Uuid::v4(),
            createdAt: new \DateTime(),
            url: $event->getRequest()->getUri(),
            requestBody: (string)$event->getRequest()->getContent()
        ));
    }
}
