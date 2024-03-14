<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;
    protected function configure()
    {
        $this->addCommands([
            new \App\Command\GetPtrRecords(),
        ]);
    }
}
