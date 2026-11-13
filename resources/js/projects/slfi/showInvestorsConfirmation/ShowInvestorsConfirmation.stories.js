import ShowInvestorsConfirmation from './ShowInvestorsConfirmation.vue';

export default {
  title: 'Projects/Slfi/ShowInvestorsConfirmation',
  component: ShowInvestorsConfirmation,
};

export const Default = () => ({
  components: { ShowInvestorsConfirmation },
  template: '<ShowInvestorsConfirmation :value="data" />',
  data() {
    return {
      data: {
        SLFI_INVESTORS_GRID: [
          {
            SLFI_GRID_INVESTORS_EMAIL: 'inv@example.com',
            SLFI_GRID_INVESTORS_DISPLAY_NAME: 'Investor',
            SLFI_GRID_INVESTORS_INVESTOR_NAME: 'Fund',
            SLFI_GRID_INVESTORS_INVESTOR_ID: '1',
            SLFI_GRID_INVESTORS_CLASS: 'A',
          },
        ],
      },
    };
  },
});
