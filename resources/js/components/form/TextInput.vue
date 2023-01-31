<template>
  <input :type="type" class="form-control" :id="id" :name="name" :aria-describedby="error_aria" :placeholder="placeholder" :disabled="disabled" :value="value" @input="$emit('input', $event.target.value)" @copy="onCopy($event)" />
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
    type: {
      type: String,
      default: 'text',
    },
    value: {
      type: [String, Number],
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
    no_copy: {
      type: Boolean,
      default: false,
    },
    error_aria: {
      type: String,
      default: '',
    },
  },
  methods: {
    onCopy(e) {
      if (this.no_copy) {
        e.preventDefault();
      }
    },
  },
};
</script>