<?php

declare(strict_types=1);

namespace Waaz\PaylinePlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class WaazPaylinePlugin extends Bundle
{
    use SyliusPluginTrait;
}
