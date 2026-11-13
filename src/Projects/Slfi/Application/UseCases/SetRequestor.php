<?php

declare(strict_types=1);

namespace ProcessMaker\Package\DemoDos\Projects\Slfi\Application\UseCases;

/**
 * Sets submitter display name and tax user id from the logged-in user payload.
 */
final class SetRequestor
{
  /**
   * @param array<string, mixed> $data
   * @return array<string, mixed>
   */
  public function handle(array $data): array
  {
    $userId = (string) ($data['USER_LOGGED'] ?? $data['_user']['id'] ?? '');
    $firstName = (string) ($data['_user']['firstname'] ?? '');
    $lastName = (string) ($data['_user']['lastname'] ?? '');
    $fullName = trim($firstName . ' ' . $lastName);
    if ($fullName !== '') {
      $data['SLFI_SUBMITTER'] = $fullName;
    }
    if ($userId !== '') {
      $data['SLFI_TAX_USER'] = $userId;
    }

    return $data;
  }
}
