<?php

declare(strict_types=1);

namespace ProcessMaker\Package\DemoDos\Projects\Slfi\Application\UseCases;

use ProcessMaker\Package\DemoDos\Projects\Slfi\Application\SlfiProcessSupport;
use ProcessMaker\Package\DemoDos\Projects\Slfi\Domain\Ports\SlfiRepositoryPort;

final class SaveInvestorEmails
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
    if ((string) ($data['SLFI_FLAG_CANCEL_CASE'] ?? '') !== '') {
      return $data;
    }
    $applicationUid = SlfiProcessSupport::applicationUid($data);
    $template = $this->repository->fetchNotificationTemplate('review', 'INVESTORS');
    if ($template === null) {
      return $data;
    }
    $subject = $template['subject'];
    $bodyTemplate = $template['body'];
    $contact = (string) ($data['SLFI_CONTACT_INFORMATION'] ?? '');
    $year = (string) ($data['SLFI_CURRENT_YEAR'] ?? date('Y'));
    $bodyTemplate = str_replace('SLFI_CONTACT_INFORMATION', $contact, $bodyTemplate);
    $bodyTemplate = str_replace('SLFI_CURRENT_YEAR', $year, $bodyTemplate);

    $investors = $this->repository->fetchInvestorsByApplication($applicationUid);
    foreach ($investors as $investor) {
      $link = (string) ($data['SLFI_EXTERNAL_FORM'] ?? '') . '&investor=' . ($investor['SID_UID'] ?? '');
      $body = str_replace('SLFI_LINK_INVESTORS', $link, $bodyTemplate);
      $body = str_replace('SLFI_INVESTOR_NAME', (string) ($investor['SID_INVESTOR_NAME'] ?? ''), $body);
      $this->repository->insertInvestorEmail($applicationUid, [
        'displayName' => (string) ($investor['SID_DISPLAY_NAME'] ?? ''),
        'investorEmail' => (string) ($investor['SID_EMAIL'] ?? ''),
        'subject' => $subject,
        'body' => $body,
        'sidUid' => (int) ($investor['SID_UID'] ?? 0),
      ]);
    }

    return $data;
  }
}
