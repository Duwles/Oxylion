<?php
/*
 * This file is part of the Oxylion package.
 *
 * (c) Bartosz Zwski <duwless@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Oxylion\Framework\Foundation\Http;

interface RebootableInterface
{
    /**
     * Reboots a kernel.
     *
     * The getCacheDir() method of a rebootable kernel should not be called
     * while building the container. Use the %kernel.cache_dir% parameter instead.
     *
     * @param string|null $warmup_dir pass null to reboot in the regular cache directory
     */
    public function reboot(string $warmup_dir);
}