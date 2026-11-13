<template>
  <div class="slfi-case-header mb-3">
    <h1 class="h4">{{ title }}</h1>
    <div class="row">
      <div class="col-md-4">
        <label class="text-muted small">Date</label>
        <div>{{ currentDate || '—' }}</div>
      </div>
      <div class="col-md-4">
        <label class="text-muted small">Name</label>
        <div>{{ submitter || '—' }}</div>
      </div>
      <div v-if="showExpiration" class="col-md-4">
        <label class="text-muted small">Expiration Date</label>
        <div>{{ expirationDate || '—' }}</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SlfiCaseHeader',
  props: {
    title: { type: String, required: true },
    currentDate: { type: String, default: '' },
    submitter: { type: String, default: '' },
    expirationDate: { type: String, default: '' },
    showExpiration: { type: Boolean, default: true },
  },
};
</script>
