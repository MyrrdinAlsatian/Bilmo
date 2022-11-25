<?php

namespace App\Events;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\Product;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $request = $event->getRequest();
        // dd($request);
        // Check if request come from REST API :
        if ('application/json' === $request->headers->get('Content-Type') || 'application/merge-patch+json' === $request->headers->get('Content-Type') ) {

            $response = new JsonResponse([
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
                // 'traces' => $exception->getTrace(),
            ]);

            if ($exception instanceof HttpExceptionInterface) {
                $response->setStatusCode($exception->getStatusCode());
                $response->headers->replace($exception->getHeaders());

                $id = $event->getRequest()->get('id');
                // dd($event->getRequest());
                // If we encountered 404 error and ID param is not valid, send a 400 error instead of 404
                if ($response->isNotFound() && !filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])) {
                    $response->setStatusCode(400);
                    $response->setData([
                        'message' => "Bad Request",
                        'code'    => Response::HTTP_BAD_REQUEST,
                        // 'traces'  => $exception->getTrace(),
                    ]);
                }
            } else {
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $event->setResponse($response);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}