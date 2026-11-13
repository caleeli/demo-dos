# slfi frontend

Domain Vue under `resources/js/projects/slfi/`. Catalog: `resources/js/designer/public-screen-components.json`.

## Components

| Story group | Root | Children |
| --- | --- | --- |
| `Projects/Slfi/UploadInvestorsConfirmationForm` | `UploadInvestorsConfirmationForm` | `SlfiCaseHeader` |
| `Projects/Slfi/ShowInvestorsConfirmation` | `ShowInvestorsConfirmation` | `SlfiCaseHeader`, `SlfiInvestorsGrid` |
| `Projects/Slfi/ReviewInvestorsList` | `ReviewInvestorsList` | `ReviewInvestorsActions`, `SlfiCaseHeader`, `SlfiInvestorsGrid` |
| `Projects/Slfi/TrackingForm` | `TrackingForm` | `SlfiCaseHeader`, `SlfiInvestorsGrid` |

## Screens

| Screen title | YAML | Vue root |
| --- | --- | --- |
| `slfi-upload-investors-confirmation-form` | `projects/slfi/screens/slfi-upload-investors-confirmation-form.yaml` | `uploadInvestorsConfirmationForm/UploadInvestorsConfirmationForm.vue` |
| `slfi-show-investors-confirmation` | `projects/slfi/screens/slfi-show-investors-confirmation.yaml` | `showInvestorsConfirmation/ShowInvestorsConfirmation.vue` |
| `slfi-review-investors-list` | `projects/slfi/screens/slfi-review-investors-list.yaml` | `reviewInvestorsList/ReviewInvestorsList.vue` |
| `slfi-tracking-form` | `projects/slfi/screens/slfi-tracking-form.yaml` | `trackingForm/TrackingForm.vue` |

## Screen Builder

All FORM screens use `VueComponentRenderTemplate` with `handlerVue` guarding `this.data`.

## Build

```bash
npm run prod
php artisan vendor:publish --tag=demo-dos --force
```
