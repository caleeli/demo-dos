<?php

declare(strict_types=1);

namespace ProcessMaker\Package\DemoDos\Projects\Slfi\Application\UseCases;

use ProcessMaker\Package\DemoDos\Projects\Slfi\Application\SlfiProcessSupport;
use ProcessMaker\Package\DemoDos\Projects\Slfi\Domain\Ports\SlfiRepositoryPort;

final class CleanOnCancel
{
  public function __construct(
    private SlfiRepositoryPort $repository,
  ) {
  }

  /**
   * @param array<string, mixed> $data
   * @return array<string, mixed>
   */
  public function handle(array $data): array
  {
    $flag = (string) ($data['SLFI_FLAG_CANCEL_CASE'] ?? '');
    if ($flag === '' || $flag === 'RETURN') {
      return $data;
    }
    $this->repository->deleteInvestorsByApplication(SlfiProcessSupport::applicationUid($data));

    return $data;
  }
}
