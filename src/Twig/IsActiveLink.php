<?php

namespace App\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class IsActiveLink extends AbstractExtension
{

    private $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction("isActive1", [$this, "isActive1"])
        ];
    }

    public function isActive1($lien = [])
    {
        $routeActuel = $this->request->getCurrentRequest()->get("_route");

        if (in_array($routeActuel, $lien)) {
            
            return "active";
        }
        return "";
    }

}