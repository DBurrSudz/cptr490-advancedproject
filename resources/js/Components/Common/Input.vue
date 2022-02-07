<template>
  <div class="mb-6">
    <!--Label for the Input Field-->
    <label
      class="block mb-2"
      v-if="label"
      :for="id"
      :class="{
        'text-white': darkBackground,
        'text-dark-blue': !darkBackground
      }"
    >
      {{ label }}
    </label>

    <!--TextArea-->
    <textarea
      :value="modelValue"
      :name="id"
      :id="id"
      v-if="type === 'textarea'"
      @input="$emit('update:modelValue', $event.target.value)"
    >
    </textarea>

    <select
      class="rounded focus:ring-[3px] transition-all duration-250 ease w-full"
      v-if="type === 'select'"
      :id="id"
      :name="id"
      :type="type"
      :value="modelValue"
      :class="{
        'border-gray-300 focus:border-dark-blue focus:ring-dark-blue focus:ring-opacity-50':
          !darkBackground,
        'focus:border-yellow focus:ring-yellow focus:ring-opacity-50':
          darkBackground,
        'border-red': error
      }"
      @input="$emit('update:modelValue', $event.target.value)"
    >
      <slot />
    </select>

    <!--Normal Input-->
    <input
      class="rounded focus:ring-[3px] transition-all duration-250 ease w-full"
      v-else
      :id="id"
      :name="id"
      :type="type"
      :value="modelValue"
      :placeholder="placeholder"
      :class="{
        'border-gray-300 focus:border-dark-blue focus:ring-dark-blue focus:ring-opacity-50':
          !darkBackground,
        'focus:border-yellow focus:ring-yellow focus:ring-opacity-50':
          darkBackground,
        'border-red border-2': error
      }"
      @input="$emit('update:modelValue', $event.target.value)"
    />
    <p class="text-red mt-2 text-sm" v-if="error">{{ error }}</p>
  </div>
</template>

<script>
export default {
  props: {
    label: String,
    modelValue: {
      type: String
    },
    type: {
      type: String,
      default: "text"
    },
    id: {
      required: true,
      type: String
    },
    darkBackground: {
      type: Boolean
    },
    placeholder: {
      type: String,
      required: true
    },
    error: {
      type: String
    }
  },
  emits: ["update:modelValue"]
}
</script>
