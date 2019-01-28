<?php
/**
 * Author: 烽行天下
 * Date: 2019\1\27 0027
 * Time: 17:09
 * QQ: 233238526
 */

namespace App\EventListener;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Service\UrlContainerInterface;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;

class SitemapSubscriber implements EventSubscriberInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * @param UrlGeneratorInterface $urlGenerator
     * @param ManagerRegistry       $doctrine
     */
    public function __construct(UrlGeneratorInterface $urlGenerator, ManagerRegistry $doctrine)
    {
        $this->urlGenerator = $urlGenerator;
        $this->doctrine = $doctrine;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            SitemapPopulateEvent::ON_SITEMAP_POPULATE => 'populate',
        ];
    }

    /**
     * @param SitemapPopulateEvent $event
     */
    public function populate(SitemapPopulateEvent $event): void
    {
        $this->registerBlogPostsUrls($event->getUrlContainer());
        $this->registerCategoryUrls($event->getUrlContainer());
    }

    /**
     * @param UrlContainerInterface $urls
     */
    public function registerBlogPostsUrls(UrlContainerInterface $urls): void
    {
        $posts = $this->doctrine->getRepository(Article::class)->findAll();

        foreach ($posts as $post) {
            $urls->addUrl(
                new UrlConcrete(
                    $this->urlGenerator->generate(
                        'article_show',
                        ['slug' => $post->getSlug()],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    )
                ),
                'article'
            );
        }
    }

    /**
     * @param UrlContainerInterface $urls
     */
    public function registerCategoryUrls(UrlContainerInterface $urls): void
    {
        $categories = $this->doctrine->getRepository(Category::class)->findAll();

        foreach ($categories as $category) {
            $urls->addUrl(
                new UrlConcrete(
                    $this->urlGenerator->generate(
                        'category_show',
                        ['slug' => $category->getSlug()],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    )
                ),
                'category.show'
            );
        }
    }
}