<?php

namespace App\EventSubscriber;

use App\Entity\UserLog;
use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class LogSubscriber implements EventSubscriberInterface
{
    private $container;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $currentUrl = $request->server->get('REQUEST_URI');
        $token = $this->container->get('security.token_storage')->getToken();
        $ip = $request->getClientIp();
        if($ip == "127.0.0.1"){
            return;
        }
        if(!is_null($token) && !preg_match('/\/userlog\//',$currentUrl) && $request->get('filter') === null){
            $em = $this->container->get('doctrine.orm.entity_manager');
            $userLog = new UserLog();
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $username = is_string($user) ? '匿名用户' : $user->getUsername();
            $userLog->setUsername($username);
            $userLog->setCurrentUrl($currentUrl);
            $userLog->setIp($ip);
            $userLog->setReferrer($request->server->get('HTTP_REFERRER'));
            $userLog->setAction($request->getMethod());
            $userLog->setData(json_encode($request->request->all()));
            $userLog->setCreatedAt(new \DateTime('now'));
            $em->persist($userLog);
            $em->flush();
        }

    }

    public static function getSubscribedEvents()
    {
        return [
           'kernel.request' => 'onKernelRequest',
        ];
    }
}
