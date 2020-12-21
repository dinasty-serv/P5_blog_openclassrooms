<?php

namespace Framework\Router;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Router extention Twig
 * @author Nicolas de Fontaine <nicolas.defontaine@apizee.com>
 */
class RouterTwigExtention extends AbstractExtension
{
    /**
     * Inject router
     *
     * @var Object
     */
    private $router;

    /**
     * Inject router
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Déclare new extention twig
     *
     * @return void
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('route', [$this, 'getUrl']),
        ];
    }
    /**
     * Return URL
     *
     * @param string $routeName
     * @param array $params
     * @return string
     */
    public function getUrl(string $routeName, ?array $params = []):string
    {
        return $this->router->url($routeName, $params);
    }
}
