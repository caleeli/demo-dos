<?php

declare(strict_types=1);

namespace ProcessMaker\Package\DemoDos\Projects\Slfi\Application\UseCases;

final class SetFlagFirstDynaform
{
  /**
   * @param array<string, mixed> $data
   * @return array<string, mixed>
   */
  public function handle(array $data): array
  {
    $data['SLFI_BACK_FORM'] = 1;

    return $data;
  }
}
