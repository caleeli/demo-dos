<?php

declare(strict_types=1);

namespace ProcessMaker\Package\DemoDos\Projects\Slfi\Domain\Entities;

use ProcessMaker\Package\DemoDos\Projects\Shared\Domain\Model;

/**
 * Single investor row for SLFI grids and persistence.
 */
final class InvestorRow extends Model
{
  public static function schemaPath(): string
  {
    return __DIR__ . '/../Schemas/investor-row.schema.json';
  }

  /**
   * @param array<string, mixed> $databaseRow
   */
  public static function fromDatabaseRow(array $databaseRow): self
  {
    return new self([
      'uid' => $databaseRow['SID_UID'] ?? null,
      'email' => (string) ($databaseRow['SID_EMAIL'] ?? ''),
      'displayName' => (string) ($databaseRow['SID_DISPLAY_NAME'] ?? ''),
      'investorName' => (string) ($databaseRow['SID_INVESTOR_NAME'] ?? ''),
      'investorId' => (string) ($databaseRow['SID_INVESTOR_ID'] ?? ''),
      'className' => (string) ($databaseRow['SID_CLASS'] ?? ''),
      'status' => (string) ($databaseRow['SID_STATUS'] ?? ''),
      'sendDate' => (string) ($databaseRow['SID_SEND_DATE'] ?? ''),
    ]);
  }

  /**
   * @return array<string, mixed>
   */
  public function toGridRow(bool $tracking = false): array
  {
    $base = [
      'SLFI_GRID_INVESTORS_EMAIL' => $this->attributes['email'] ?? '',
      'SLFI_GRID_INVESTORS_DISPLAY_NAME' => $this->attributes['displayName'] ?? '',
      'SLFI_GRID_INVESTORS_INVESTOR_NAME' => $this->attributes['investorName'] ?? '',
      'SLFI_GRID_INVESTORS_INVESTOR_ID' => $this->attributes['investorId'] ?? '',
      'SLFI_GRID_INVESTORS_CLASS' => $this->attributes['className'] ?? '',
      'SLFI_GRID_INVESTORS_UID' => (string) ($this->attributes['uid'] ?? ''),
    ];

    if (!$tracking) {
      return $base;
    }

    return array_merge($base, [
      'SLFI_GRID_INVESTORS_SEND_DATE' => $this->attributes['sendDate'] ?? '',
      'SLFI_GRID_INVESTORS_STATUS' => $this->attributes['status'] ?? '',
      'SLFI_GRID_INVESTORS_VIEW' => $this->attributes['viewLink'] ?? '',
      'SLFI_GRID_INVESTORS_CANCEL' => $this->attributes['cancelLink'] ?? '',
      'SLFI_GRID_INVESTORS_RESENT' => $this->attributes['resentLink'] ?? '',
      'SLFI_GRID_INVESTORS_EDIT' => $this->attributes['editLink'] ?? '',
      'SLFI_GRID_INVESTORS_COPY_LINK' => $this->attributes['copyLink'] ?? '',
      'SLFI_GRID_INVESTORS_COPY_LINK_VALUE' => $this->attributes['copyLinkValue'] ?? '',
    ]);
  }
}
