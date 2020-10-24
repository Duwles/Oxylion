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

trait MicroTraits
{
    public function isDebug()
    {
        return $this->debug;
    }

    public function getName()
    {
        if (null === $this->name) {
            $this->name = preg_replace(
                '/[^a-zA-Z0-9_]+/',
                '',
                basename($this->directoryRoot)
            );

            if (ctype_digit($this->name[0])) {
                $this->name = '_'.$this->name;
            }
        }

        return $this->name;
    }

    public function getCharset()
    {
        return "UTF-8";
    }

    public function getEnvironment()
    {
        return $this->environment;
    }

    public function getStartTime()
    {
        return $this->debug && null !== $this->startTime ? $this->startTime : -INF;
    }

    public function getDirectoryCache()
    {
        return $this->directoryRoot.'/storage/cache/'.$this->environment;
    }

    public function getDirectoryLogs()
    {
        return $this->directoryRoot.'/storage/logs';
    }
}

/**
 * Alternative get name function
 *
public function getName()
{
    if (null === $this->name) {
        $r = new \ReflectionObject($this);

        $this->name = strtolower(preg_replace(
            ['/(.+?)Kernel$/', '/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'],
            ['\\1', '\\1_\\2', '\\1_\\2'],
            $r->getName()
        ));
    }

    return $this->name;
}
 */