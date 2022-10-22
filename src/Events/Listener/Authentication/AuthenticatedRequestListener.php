<?php
declare(strict_types=1);

namespace Attendance\Events\Listener\Authentication;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class AuthenticatedRequestListener
{
    // Used in integration tests
    public const API_KEY_OK = 'does-not-matter';

    public function onKernelRequest(RequestEvent $event): void
    {
        // Keep it simple for a demo, just check the api key matches
        // what we expect.
        //
        // Realistically this would do a db lookup, role access check etc.
        // Ideally in a secure system it would not even happen in the codebase.
        if ($event->getRequest()->headers->get('api-key') !== self::API_KEY_OK) {
            // How much information you bleed here is quite important. If you let
            // a potential attacked know 'oh that key IS one of ours buuuut not for
            // that action' then you have disclosed it is legit, just for something
            // else.
            $event->setResponse(new JsonResponse([
                'status' => Response::HTTP_UNAUTHORIZED,
                'errors' => 'You are not authorised to perform this action',
            ], Response::HTTP_UNAUTHORIZED));
        }
    }
}
