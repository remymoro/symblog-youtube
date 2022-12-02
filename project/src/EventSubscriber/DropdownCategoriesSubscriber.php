<?php

namespace App\EventSubscriber;

use Twig\Environment;
use App\Repository\Post\CategoryRepository;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DropdownCategoriesSubscriber implements EventSubscriberInterface
{

    const ROUTES = ["post_index", "category_index"];


    public function __construct(
        private  CategoryRepository $categoryRepository,
        private   Environment $twig
    ) {
    }






    public function injectGlobalVariable(RequestEvent $event): void
    {
        $route = $event->getRequest()->get('_route');
        if (in_array($route, DropdownCategoriesSubscriber::ROUTES)) {
            $categories = $this->categoryRepository->findAll();
            $this->twig->addGlobal('allCategories', $categories);
        }
    }






    public static function getSubscribedEvents()
    {

        return [KernelEvents::REQUEST => 'injectGlobalVariable'];
    }
}
