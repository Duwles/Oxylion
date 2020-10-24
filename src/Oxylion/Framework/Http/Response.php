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

class Response
{
    protected string $content;
    protected int    $status_code;
    protected array  $headers;
    protected string $protocol;

    public function __construct($content = null, int $status_code = 200, array $headers = [], string $protocol = '1.0')
    {
        $this->headers = $headers;
        $this->setContent($content);
        $this->setStatusCode($status_code);
        $this->setProtocol($protocol);
    }

    public function setContent($content)
    {
        $this->content = $content ?? "";
        return $this;
    }

    public function setStatusCode(int $status_code)
    {
        $this->status_code = (int) $status_code ?? 200;
        return $this;
    }

    public function send()
    {
        $this->sendHeaders();
        $this->sendContent();

        if (\function_exists('fastcgi_finish_request')) {
            \fastcgi_finish_request();
        } elseif (!\in_array(\PHP_SAPI, ['cli', 'phpdbg'], true)) {
            static::closeOutputBuffers(0, true);
        }
    }

    private function setProtocol(string $protocol)
    {
        $this->protocol = $protocol ?? '1.0';
    }

    private function getContent(): string
    {
        return $this->content;
    }

    private function sendHeaders()
    {
        if(\headers_sent()) {
            throw new \LogicException("Headers were sent before the Response object call send method.");
        }

        foreach ($this->headers as $header) {
            header($header);
        }

        return $this;
    }

    private function sendContent()
    {
        echo $this->getContent();
        return $this;
    }

    /**
     * Cleans or flushes output buffers up to target level.
     *
     * Resulting level can be greater than target level if a non-removable buffer has been encountered.
     *
     * @final
     * @param int $targetLevel
     * @param bool $flush
     */
    public static function closeOutputBuffers(int $targetLevel, bool $flush): void
    {
        $status = \ob_get_status(true);
        $level = \count($status);
        $flags = \PHP_OUTPUT_HANDLER_REMOVABLE | ($flush ? \PHP_OUTPUT_HANDLER_FLUSHABLE : \PHP_OUTPUT_HANDLER_CLEANABLE);

        while ($level-- > $targetLevel && ($s = $status[$level]) && (!isset($s['del']) ? !isset($s['flags']) || ($s['flags'] & $flags) === $flags : $s['del'])) {
            if ($flush) {
                \ob_end_flush();
            } else {
                \ob_end_clean();
            }
        }
    }
}