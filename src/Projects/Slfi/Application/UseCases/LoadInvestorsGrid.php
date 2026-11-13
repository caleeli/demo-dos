<?php

declare(strict_types=1);

namespace ProcessMaker\Package\DemoDos\Projects\Slfi\Application\UseCases;

use ProcessMaker\Package\DemoDos\Projects\Slfi\Application\SlfiProcessSupport;
use ProcessMaker\Package\DemoDos\Projects\Slfi\Domain\Ports\SlfiRepositoryPort;

final class LoadInvestorsGrid
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
    $applicationUid = SlfiProcessSupport::applicationUid($data);
    $databaseRows = $this->repository->fetchInvestorsByApplication($applicationUid);
    $data['SLFI_INVESTORS_GRID'] = SlfiProcessSupport::buildReviewGrid($databaseRows);

    return $data;
  }
}
