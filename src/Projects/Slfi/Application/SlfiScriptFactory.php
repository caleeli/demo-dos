<?php

declare(strict_types=1);

namespace ProcessMaker\Package\DemoDos\Projects\Slfi\Application;

use ProcessMaker\Package\DemoDos\Projects\Slfi\Domain\Ports\SlfiRepositoryPort;
use ProcessMaker\Package\DemoDos\Projects\Slfi\Infrastructure\Persistence\PdoSlfiRepository;

final class SlfiScriptFactory
{
  public static function repository(): SlfiRepositoryPort
  {
    global $slfiRepositoryPort;
    if (isset($slfiRepositoryPort) && $slfiRepositoryPort instanceof SlfiRepositoryPort) {
      return $slfiRepositoryPort;
    }

    return new PdoSlfiRepository();
  }
}
