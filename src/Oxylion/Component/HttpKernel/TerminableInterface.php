<?php
/*
 * This file is part of the Oxylion package.
 *
 * (c) Bartosz Zwski <duwless@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oxylion\Component\HttpKernel;

use Oxylion\Component\HttpFoundation\Request;
use Oxylion\Component\HttpFoundation\Response;

interface TerminableInterface
{
    /**
     * Terminates a request/response cycle.
     *
     * Should be called after sending the response and before shutting down the kernel.
     *
     * @param Request $request
     * @param Response $response
     */
    public function terminate(Request $request, Response $response);
}