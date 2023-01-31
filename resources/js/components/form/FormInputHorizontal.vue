<template>
  <div class="form-group row">
    <slot name="label">
      <label v-if="title.length" :for="id" class="col-sm-2 col-form-label">{{ title }}</label>
    </slot>
    <div class="col-sm-10">
      <SelectInput v-if="type === 'select'"
        :id="id"
        :name="name"
        :options="options"
        :placeholder="placeholder"
        :disabled="disabled"
        :error_aria="errorAriaId"
        v-model="innerValue"
      ></SelectInput>
      <TextArea v-else-if="type === 'textarea'"
        :id="id"
        :name="name"
        :rows="rows"
        :placeholder="placeholder"
        :disabled="disabled"
        :error_aria="errorAriaId"
        v-model="innerValue"
      ></TextArea>
      <TextInput v-else
        :id="id"
        :name="name"
        :type="type"
        :placeholder="placeholder"
        :disabled="disabled"
        :no_copy="no_copy"
        :error_aria="errorAriaId"
        v-model="innerValue"
      ></TextInput>
      <small v-for="errorText in errorData" :key="errorText" :id="errorAriaId" class="form-text text-danger">{{ errorText }}</small>
    </div>
  </div>
</template>

<script>
import TextInput from "js/components/form/TextInput.vue";
import SelectInput from "js/components/form/SelectInput.vue";
import TextArea from "js/components/form/TextArea.vue";

export default {
  props: {
    div_class: {
      type: String,
      default: 'form-group',
    },
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
    title: {
      type: String,
      default: '',
    },
    label_description: {
      type: String,
      default: '',
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
    options: {
      type: [Array, Object],
      default: () => [],
    },
    rows: {
      type: String,
      default: '',
    },
    errors: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      errorData: [],
    };
  },
  watch: {
    errors(value) {
      this.errorData = value;
    }
  },
  computed: {
    errorAriaId() {
      return this.id + '_help';
    },
    innerValue: {
      get() {
        return this.$props.value;
      },
      set(value) {
        this.$emit('input', value)
      },
    }
  },
  components: {
    TextInput,
    SelectInput,
    TextArea,
  },
};
</script>