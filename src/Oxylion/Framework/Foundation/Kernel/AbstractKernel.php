<?php
/*
 * This file is part of the Oxylion package.
 *
 * (c) Bartosz Zwski <duwless@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Oxylion\Framework\Foundation\Kernel;
use Oxylion\Framework\Container\Container;
use Oxylion\Framework\Container\ContainerInterface;
use Oxylion\Framework\Exception\ResourceNotFoundException;
use Oxylion\Framework\Http\Request;
use Oxylion\Framework\Http\Response;
use Exception;

abstract class AbstractKernel
{
    use MicroTraits;

    protected ?ContainerInterface $container;

    protected bool   $booted = false;

    protected bool   $debug;

    protected string $environment;

    protected string $directoryRoot;

    protected ?string $name = null;

    protected float  $startTime;

    protected int    $requestStack;

    /**
     * Construct function
     *
     * @param string $environment The environment
     * @param bool   $debug       Whether to enable debugging or not
     */
    public function __construct(string $environment, bool $debug = false)
    {
        $this->debug            = $debug;
        $this->environment      = $environment;
        $this->directoryRoot    = $this->getDirectoryRoot();
        $this->name             = $this->getName();
    }

    public function __clone()
    {
        $this->booted             = false;
        $this->container          = null;
        $this->requestStack       = 0;
    }

    public function boot()
    {
        if($this->booted) {
            return;
        }

        if ($this->debug) {
            $this->startTime = microtime(true);
        }

        $this->initContainer();
        $this->requestStack = 0;
        $this->booted = true;
    }

    public function shutdown()
    {
        if(false === $this->booted) {
            return;
        }

        $this->booted = false;
        $this->container = null;
        $this->requestStack = 0;
    }

    public function handle(Request $request, $type = 1, $catch = true): Response
    {
        $this->boot();
        ++$this->requestStack;

        try {
            //return call_user_func_array([],);
            return new Response();
        } catch (ResourceNotFoundException $e) {
            return new Response('Not Found', 404);
        } catch (Exception $e) {
            return new Response('An error occurred: ' . $e->getMessage() . '<br> File: ' . $e->getFile() . '<br> Line: ' . $e->getLine(), 500);
        } finally {
            --$this->requestStack;
        }
    }

    public function terminate($request, $response)
    {
    }

    protected function initContainer()
    {
        $this->container = Container::make();
        $this->container->set('hw', "HelloWorld".__METHOD__);
        $this->container->set('view', "TwigServiceProvider");
    }

    public function getHttpKernel()
    {
        return $this->container->get('http_kernel');
    }

    public function dispatch() { }

    public abstract function getDirectoryRoot();
}