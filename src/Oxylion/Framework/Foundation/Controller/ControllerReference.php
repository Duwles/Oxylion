<?php
/*
 * This file is part of the Oxylion package.
 *
 * (c) Bartosz Zwski <duwless@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Oxylion\Framework\Foundation\Controller;

class ControllerReference
{
    public string $controller;
    public array  $attributes = [];
    public array  $query      = [];

    /**
     * ControllerReference
     *
     * @param string $controller The controller name
     * @param array  $attributes An array of parameters to add to the Request attributes
     * @param array  $query      An array of parameters to add to the Request query string
     */
    public function __construct(string $controller, array $attributes = [], array $query = [])
    {
        $this->controller = $controller;
        $this->attributes = $attributes;
        $this->query      = $query;
    }
}