import UploadInvestorsConfirmationForm from './UploadInvestorsConfirmationForm.vue';

export default {
  title: 'Projects/Slfi/UploadInvestorsConfirmationForm',
  component: UploadInvestorsConfirmationForm,
};

export const Default = () => ({
  components: { UploadInvestorsConfirmationForm },
  template: '<UploadInvestorsConfirmationForm :value="data" />',
  data() {
    return {
      data: {
        SLFI_CURRENT_DATE: '2026-11-13',
        SLFI_SUBMITTER: 'Tax User',
        SLFI_EXPIRATION_DATE: '2026-12-01',
      },
    };
  },
});

export const Empty = () => ({
  components: { UploadInvestorsConfirmationForm },
  template: '<UploadInvestorsConfirmationForm :value="{}" />',
});
