<?php

namespace App\Twig;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class SidebarExtension extends AbstractExtension
{
    private $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('filter_name', [$this, 'doSomething'], ['is_safe' => ['html']]),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('relations', [$this, 'relations'], ['is_safe' => ['html'], 'needs_environment' => true]),
        ];
    }

    public function relations(Environment $twig,Category $category): string
    {
        $articles = $this->repository->findByCategory($category->getId());

        return $twig->render('/article/sidebar.html.twig',['articles'=>$articles]);
    }
}
