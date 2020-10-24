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
use Oxylion\Framework\Container\ContainerInterface;
use Oxylion\Framework\Http\Response;

abstract class AbstractController
{
    protected ?ContainerInterface $container;

    public function __construct()
    {
    }

    protected function renderView(string $filename, array $parameters = []): string
    {
        if (!$this->container->has('twig')) {
            throw new \LogicException('Twig Template Engine not exist in: '.__METHOD__.'().'.NL);
        }

        return $this->container->get('twig')->render($filename, $parameters);
    }

    protected function render(string $filename, array $parameters = [], Response $response = null): Response
    {
        $content = $this->renderView($filename, $parameters);

        if (null===$response) {
            $response = new Response();
        }

        $response->setContent($content);

        return $response;
    }
}