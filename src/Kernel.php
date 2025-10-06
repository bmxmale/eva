<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

// Guard against duplicate class declaration in certain test/runtime contexts
if (!class_exists(\App\Kernel::class, false)) {
    class Kernel extends BaseKernel
    {
        use MicroKernelTrait;
    }
}
