<template>
  <div>
    <!--Label-->
    <label v-if="label" :for="id">
      {{ label }}
    </label>
    <!--DateField-->
    <input :type="type" :name="id" :id="id" />
  </div>
</template>

<script>
export default {
  props: {
    label: String,
    type: {
      type: String,
      default: "date"
    },
    id: {
      type: String,
      required: true
    }
  }
}
</script>
