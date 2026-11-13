<?php

declare(strict_types=1);

namespace ProcessMaker\Package\DemoDos\Projects\Slfi\Application\UseCases;

use ProcessMaker\Package\DemoDos\Projects\Slfi\Application\SlfiProcessSupport;
use ProcessMaker\Package\DemoDos\Projects\Slfi\Domain\Ports\SlfiRepositoryPort;

final class InitializeSubmit
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
    $data['SLFI_YEAR'] = date('Y');
    $data['SLFI_CURRENT_YEAR'] = date('Y');
    $data['SLFI_CURRENT_DATE'] = date('Y-m-d H:i:s');
    $data['APP_UID'] = SlfiProcessSupport::applicationUid($data);
    $data['CASE_NUMBER'] = (string) SlfiProcessSupport::applicationNumber($data);
    $data['TASK_UID'] = (string) ($data['TASK'] ?? $data['TASK_UID'] ?? '');
    $data['SLFI_CONTACT_INFORMATION'] = $this->repository->fetchExternalFormVariable('SLFI_CONTACT_INFORMATION');
    $minDays = $this->repository->fetchMinExpirationDays();
    $minDate = date('Y-m-d', strtotime('+' . $minDays . ' days'));
    $data['SLFI_MIN_EXPIRATION_DATE'] = $minDate;
    if (empty($data['SLFI_EXPIRATION_DATE'])) {
      $data['SLFI_EXPIRATION_DATE'] = $minDate;
    }
    $data['SLFI_EXTERNAL_FORM'] = $this->buildExternalFormLink($data);
    $data['IMG_LOGO'] = $this->buildLogoHtml($data);

    return $data;
  }

  /**
   * @param array<string, mixed> $data
   */
  private function buildExternalFormLink(array $data): string
  {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $host = (string) ($_SERVER['HTTP_HOST'] ?? 'localhost');
    $sys = (string) ($data['SYS_SYS'] ?? 'en');

    return $scheme . $host . '/api/1.0/slfi/external-form?sys=' . rawurlencode($sys);
  }

  /**
   * @param array<string, mixed> $data
   */
  private function buildLogoHtml(array $data): string
  {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $host = (string) ($_SERVER['HTTP_HOST'] ?? 'localhost');
    $imageUrl = $scheme . $host . '/vendor/processmaker/demo-dos/images/northleaf_logo_small.png';

    return "<img src='" . htmlspecialchars($imageUrl, ENT_QUOTES) . "' style='margin-bottom:10px;width:200px;'>";
  }
}
