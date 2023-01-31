<template>
    <div>
        <div v-for="(val, key) in options" :key="val">
            <label class="form-input-radio radio radio-gradient">
              <span class="radio__input">
                <input type="radio" 
                    :name="labelName" 
                    :value="val" 
                    :checked="val == value" 
                    @change="$emit('input', val)">
                <span class="radio__control"></span>
              </span>
              <span class="radio__label">{{key}}</span>
            </label>
            <div class="description">
                {{description[val]}}
            </div>
        </div>
  </div>
</template>

<script>
export default {
  name: "Radioset",
  props: {
    labelName: '',
    value: '',
    options: '',
    description: {
        type: Array,
        default: [],
    },
  }
}

</script>