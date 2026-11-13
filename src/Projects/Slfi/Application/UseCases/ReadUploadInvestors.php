<?php

declare(strict_types=1);

namespace ProcessMaker\Package\DemoDos\Projects\Slfi\Application\UseCases;

use ProcessMaker\Package\DemoDos\Projects\Slfi\Application\SlfiProcessSupport;
use ProcessMaker\Package\DemoDos\Projects\Slfi\Domain\Ports\SlfiRepositoryPort;

final class ReadUploadInvestors
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
    $rows = SlfiProcessSupport::parseUploadedInvestors($data);
    $expirationDate = (string) ($data['SLFI_EXPIRATION_DATE'] ?? date('Y-m-d'));
    $this->repository->deleteInvestorsByApplication($applicationUid);
    if ($rows !== []) {
      $this->repository->insertInvestorRows($applicationUid, $rows, $expirationDate);
    }
    $databaseRows = $this->repository->fetchInvestorsByApplication($applicationUid);
    $data['SLFI_INVESTORS_GRID'] = SlfiProcessSupport::buildReviewGrid($databaseRows);
    $data['SLFI_BACK_FORM'] = 1;

    return $data;
  }
}
