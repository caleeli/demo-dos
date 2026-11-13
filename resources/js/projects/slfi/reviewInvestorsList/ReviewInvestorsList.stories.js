import ReviewInvestorsList from './ReviewInvestorsList.vue';

export default {
  title: 'Projects/Slfi/ReviewInvestorsList',
  component: ReviewInvestorsList,
};

export const Default = () => ({
  components: { ReviewInvestorsList },
  template: '<ReviewInvestorsList :value="data" />',
  data() {
    return {
      data: {
        SLFI_INVESTORS_GRID: [],
        SLFI_FLAG_CANCEL_CASE: '',
      },
    };
  },
});
