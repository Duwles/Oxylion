<?php
/*
 * This file is part of the Oxylion package.
 *
 * (c) Bartosz Zwski <duwless@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Atlax\Component\HttpKernel;

final class KernelEvents
{
    public const REQUEST                = 'kernel.request';
    public const EXCEPTION              = 'kernel.exception';
    public const VIEW                   = 'kernel.view';
    public const CONTROLLER             = 'kernel.controller';
    public const CONTROLLER_ARGUMENTS   = 'kernel.controller_arguments';
    public const RESPONSE               = 'kernel.response';
    public const TERMINATE              = 'kernel.terminate';
    public const FINISH_REQUEST         = 'kernel.finish_request';
}