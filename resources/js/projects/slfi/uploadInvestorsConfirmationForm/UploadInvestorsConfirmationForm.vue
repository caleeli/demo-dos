<template>
  <div class="slfi-upload-form">
    <slfi-case-header
      title="Submit Investors Confirmation Form"
      :current-date="localData.SLFI_CURRENT_DATE"
      :submitter="localData.SLFI_SUBMITTER"
      :expiration-date="localData.SLFI_EXPIRATION_DATE"
    />
    <b-form-group label="Investors List">
      <b-form-file
        v-model="fileSelection"
        multiple
        accept=".csv,.xlsx,.xls"
        placeholder="Choose investor list file..."
      />
      <small class="text-muted d-block mt-1">Upload the annual investor confirmation spreadsheet.</small>
    </b-form-group>
    <b-button variant="primary" class="mt-2" @click="onPreview">Preview</b-button>
  </div>
</template>

<script>
import SlfiCaseHeader from '../shared/components/SlfiCaseHeader.vue';

export default {
  name: 'UploadInvestorsConfirmationForm',
  components: { SlfiCaseHeader },
  props: {
    value: { type: Object, default: () => ({}) },
    submit: { type: Function, default: () => undefined },
  },
  data() {
    return {
      fileSelection: null,
    };
  },
  computed: {
    localData() {
      return this.value || {};
    },
  },
  watch: {
    fileSelection(files) {
      if (!files) {
        return;
      }
      const payload = Array.isArray(files) ? files : [files];
      this.$emit('input', { ...this.localData, SLFI_UPLOAD_INVESTORS: payload });
    },
  },
  methods: {
    onPreview() {
      if (typeof this.submit === 'function') {
        this.submit();
      }
    },
  },
};
</script>
