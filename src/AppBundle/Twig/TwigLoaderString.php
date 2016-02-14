<?php

namespace AppBundle\Twig;

use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Templating\TemplateReferenceInterface;

class TwigLoaderString implements \Twig_LoaderInterface, EngineInterface
{
    /**
     * @param string $name
     * @return string
     */
    public function getSource($name)
    {
        return $name;
    }

    /**
     * @param string $name
     * @param int $time
     * @return bool
     */
    public function isFresh($name, $time)
    {
        return true;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getCacheKey($name)
    {
        return 'twigStringService' . md5($name);
    }

    /**
     * @param string|TemplateReferenceInterface $name
     * @return bool
     */
    public function exists($name)
    {
        return is_string($name);
    }

    /**
     * @param string|TemplateReferenceInterface $name
     * @return bool
     */
    public function supports($name) {
        return is_string($name);
    }

    /**
     * @param string|$name
     * @param array $parameters
     * @return string
     */
    public function render($name, array $parameters = array())
    {
        $twig = new \Twig_Environment($this);

        return $twig->render($name, $parameters);
    }
}