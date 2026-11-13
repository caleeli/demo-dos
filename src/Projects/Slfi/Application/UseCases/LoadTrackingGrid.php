<?php

declare(strict_types=1);

namespace ProcessMaker\Package\DemoDos\Projects\Slfi\Application\UseCases;

use ProcessMaker\Package\DemoDos\Projects\Slfi\Application\SlfiProcessSupport;
use ProcessMaker\Package\DemoDos\Projects\Slfi\Domain\Ports\SlfiRepositoryPort;

final class LoadTrackingGrid
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
    $applicationNumber = SlfiProcessSupport::applicationNumber($data);
    $externalForm = (string) ($data['SLFI_EXTERNAL_FORM'] ?? '');
    $databaseRows = $this->repository->fetchInvestorsByApplication($applicationUid);
    $data['SLFI_INVESTORS_GRID_TRACKING'] = SlfiProcessSupport::buildTrackingGrid($databaseRows, $externalForm);

    $pendingCount = $this->repository->countInvestorsInStatuses(
      $applicationUid,
      ['Pending', 'Sent', 'Re-sent']
    );
    $data['SLFI_FLAG_SUBMIT'] = $pendingCount > 0 ? 'NO' : 'YES';

    $data['SLFI_DISABLED_BUTTON_INVESTORS_ZIP'] = 0;
    $zipDate = $this->repository->fetchLatestZipMessageDate($applicationNumber);
    if ($zipDate !== null) {
      $emailDateAddOneDay = strtotime($zipDate . ' +1 day');
      if (time() < $emailDateAddOneDay) {
        $data['SLFI_DISABLED_BUTTON_INVESTORS_ZIP'] = 1;
      }
    }
    if ($this->repository->countCompletedInvestors($applicationUid) === 0) {
      $data['SLFI_DISABLED_BUTTON_INVESTORS_ZIP'] = 1;
    }

    return $data;
  }
}
