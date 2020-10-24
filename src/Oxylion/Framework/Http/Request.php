<?php
/*
 * This file is part of the Oxylion package.
 *
 * (c) Bartosz Zwski <duwless@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Oxylion\Framework\Http;

class Request
{
    private const HIDEIT = ['COMSPEC', 'PATH', 'PATHEXT', 'SystemRoot', 'WINDIR'];

    private array $attributes    = [];

    private static $requestFactory = null;

    protected string $method    = "";
    protected string $uri       = "";
    protected array  $headers   = [];

    public array $cookies       = [];
    public array $query         = [];
    public array $request       = [];
    public array $files         = [];
    public array $server        = [];

    public string $scheme       = "";
    public string $charset      = "";
    public string $encoding     = "";
    public string $language     = "";
    public string $base_url     = "";
    public string $base_path    = "";
    public string $path_info    = "";
    public string $script_name  = "";

    private static function createRequestFromFactory(array $cookies = [], array $query = [], array $request = [], array $files = [], array $server = [])
    {
        if (self::$requestFactory) {
            $request = \call_user_func(self::$requestFactory, $cookies, $query, $request, $files, $server);

            if (!$request instanceof self) {
                throw new \LogicException("The RequestFactory must be an instance of Oxylion\Framework\Http class.");
            }

            return $request;
        }

        return new static($cookies, $query, $request, $files, $server);
    }

    private static function serverContentPrepare(): array
    {
        foreach (self::HIDEIT as $hide)
            if (isset($_SERVER[$hide]) && !empty($_SERVER[$hide]))
                unset($_SERVER[$hide]);

        foreach ($_ENV as $key=>$value)
            if (isset($_SERVER[$key]) && !empty($_SERVER[$key]))
                unset($_SERVER[$key]);

        if (isset($_SERVER)) {
            $_server = $_SERVER;

            if ('cli-server' === PHP_SAPI) {
                if (array_key_exists('HTTP_CONTENT_LENGTH', $_SERVER)) {
                    $_server['CONTENT_LENGTH'] = $_SERVER['HTTP_CONTENT_LENGTH'];
                }
                if (array_key_exists('HTTP_CONTENT_TYPE', $_SERVER)) {
                    $_server['CONTENT_TYPE'] = $_SERVER['HTTP_CONTENT_TYPE'];
                }
            }

            ksort($_server);
            unset($_SERVER);
            $_SERVER = [];
            return $_server;
        }

        return [];
    }

    private function initialize(array $cookies = [], array $query = [], array $request = [],  array $files = [], array $server = [])
    {
        $this->cookies    = $cookies;
        $this->query      = $query;
        $this->request    = $request;
        $this->files      = $files;
        $this->server     = $server;
    }

    private function __construct(array $cookies = [], array $query = [], array $request = [],  array $files = [], array $server = [])
    {
        $this->initialize($cookies, $query, $request, $files, $server);
    }

    public static function createFromGlobals()
    {
        $server = self::serverContentPrepare();
        if ('cli-server' === PHP_SAPI) {
            if (array_key_exists('HTTP_CONTENT_LENGTH', $_SERVER)) {
                $server['CONTENT_LENGTH'] = $_SERVER['HTTP_CONTENT_LENGTH'];
            }
            if (array_key_exists('HTTP_CONTENT_TYPE', $_SERVER)) {
                $server['CONTENT_TYPE'] = $_SERVER['HTTP_CONTENT_TYPE'];
            }
        }

        $request = self::createRequestFromFactory($_COOKIE, $_GET, $_POST, $_FILES, $server);

        $request->uri         = $server['REQUEST_URI'];
        $request->method      = $server['REQUEST_METHOD'];
        $request->scheme      = $server['REQUEST_SCHEME'];
        $request->charset     = "UTF-8";
        $request->encoding    = $server['HTTP_ACCEPT_ENCODING'];
        $request->language    = substr($server['HTTP_ACCEPT_LANGUAGE'],0,2);
        $request->base_url    = $server['REQUEST_SCHEME']."://".$server['HTTP_HOST']."/";
        $request->base_path   = $server['REQUEST_URI'];
        $request->path_info   = ltrim(str_replace($server['SCRIPT_NAME'], '', $server['REQUEST_URI']),'/');
        $request->script_name = $server['SCRIPT_NAME'];


        return $request;
    }
}

/**
(new Request())
    ->getMethod()
    ->getUri()
    ->getHeaders()
    ->getCookieParams()
    ->getQueryParams()
    ->getRequestParams()
    ->getFilesUploader()
    ->getServerParams();
 */
