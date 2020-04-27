<?php

namespace App\EventSubscriber;

use App\Entity\UserLog;
use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;


class LogSubscriber implements EventSubscriberInterface
{
    private $container;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onKernelResponse(ResponseEvent $event)
    {

        $request = $event->getRequest();
        $server = $request->server;
        $header = $server->getHeaders();
        $userAgent = $header['USER_AGENT'];

        $currentUrl = $server->get('REQUEST_URI');
        $token = $this->container->get('security.token_storage')->getToken();
        $ip = $request->getClientIp();
        if($ip == "127.0.0.1"){
            return;
        }
        if(!is_null($token) && !preg_match('/\/userlog\//',$currentUrl) && $request->get('filter') === null){
            $em = $this->container->get('doctrine.orm.entity_manager');
            $userLog = new UserLog();
            $username = $this->isCrawler($userAgent);
            if($username == "自然人")
            {
                $user = $this->container->get('security.token_storage')->getToken()->getUser();
                $username = is_string($user) ? '匿名用户' : $user->getUsername();
            }
            $userLog->setUsername($username);
            $userLog->setCurrentUrl($currentUrl);
            $userLog->setIp($ip);
            $userLog->setUserAgent($userAgent);
            $userLog->setReferrer($server->get('HTTP_REFERRER'));
            $userLog->setAction($request->getMethod());
            $userLog->setData(json_encode($request->request->all()));
            $userLog->setCreatedAt(new \DateTime('now'));
            $em->persist($userLog);
            $em->flush();
        }

    }

    public static function getSubscribedEvents()
    {
        return [KernelEvents::RESPONSE=>'onKernelResponse'];
    }

    function isCrawler($agent) {
        $agent= strtolower($agent);
        if (!empty($agent)) {
            $spiderSite= array(
                'Googlebot'=>' Google 爬虫', // Google 爬虫
                'Baiduspider'=>'百度爬虫', // 百度爬虫
                'Yahoo! Slurp'=>'雅虎爬虫', // 雅虎爬虫
                'YodaoBot'=>'有道爬虫', // 有道爬虫
                'bingbot'=>'Bing爬虫',
                'Sogou web spider' => '搜狗爬虫',
                '360Spider' => '360爬虫',
                'msnbot' => 'msn爬虫',
                'Sosospider' => 'SOSO爬虫',
                'ia_archiver' => 'Alexa蜘蛛',
                'EasouSpider' => '宜搜蜘蛛',
                'JikeSpider' => '即刻蜘蛛',
                'YisouSpider' => '一搜蜘蛛',
            );
            foreach($spiderSite as $spider => $name) {
                $spider = strtolower($spider);
                if (strpos($agent, $spider) !== false) {
                    return $name;
                }
            }
        }
        return "自然人";
    }

}
