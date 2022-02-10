<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * A simple twig extension that adds a to_array filter
 * It will convert an object to array so that you can iterate over it's properties
 */
class GetTypeExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return array(
            new TwigFunction('getType', array($this, 'get_type')),
        );
    }

    public function get_type($object)
    {
        return gettype($object);
    }

    public function getName()
    {
        return 'get_type_extension';
    }
}