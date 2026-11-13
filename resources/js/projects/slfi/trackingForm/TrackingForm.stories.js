import TrackingForm from './TrackingForm.vue';

export default {
  title: 'Projects/Slfi/TrackingForm',
  component: TrackingForm,
};

export const Default = () => ({
  components: { TrackingForm },
  template: '<TrackingForm :value="data" />',
  data() {
    return {
      data: {
        SLFI_INVESTORS_GRID_TRACKING: [],
        SLFI_DISABLED_BUTTON_INVESTORS_ZIP: 1,
      },
    };
  },
});

export const ZipEnabled = () => ({
  components: { TrackingForm },
  template: '<TrackingForm :value="data" />',
  data() {
    return {
      data: {
        SLFI_INVESTORS_GRID_TRACKING: [],
        SLFI_DISABLED_BUTTON_INVESTORS_ZIP: 0,
      },
    };
  },
});
