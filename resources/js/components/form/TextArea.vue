<template>
  <textarea class="form-control" :id="id" :name="name" :rows="rows" :aria-describedby="error_aria" :placeholder="placeholder" :disabled="disabled" :value="value" @input="$emit('input', $event.target.value)"></textarea>
</template>

<script>
export default {
  props: {
    id: {
      type: String,
      default: '',
    },
    name: {
      type: String,
      default: '',
    },
    value: {
      type: String,
      default: '',
    },
    rows: {
      type: String,
      default: '',
    },
    placeholder: {
      type: String,
      default: '',
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    error_aria: {
      type: String,
      default: '',
    },
  },
};
</script>