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

    <!--Checkbox-->
    <input
      v-if="type === 'checkbox'"
      class="rounded focus:ring-[3px] transition-all duration-250 ease"
      :id="id"
      :name="id"
      :type="type"
      :checked="modelValue"
      :class="{
        'border-gray-300 focus:border-dark-blue focus:ring-dark-blue focus:ring-opacity-50':
          !darkBackground,
        'focus:border-yellow focus:ring-yellow focus:ring-opacity-50':
          darkBackground,
        'border-red border-2': error
      }"
      @change="$emit('update:modelValue', $event.target.checked)"
    />
    <!--TextArea-->
    <textarea
      :value="modelValue"
      :name="id"
      :id="id"
      v-else-if="type === 'textarea'"
      :class="{
        'border-gray-300 focus:border-dark-blue focus:ring-dark-blue focus:ring-opacity-50':
          !darkBackground,
        'focus:border-yellow focus:ring-yellow focus:ring-opacity-50':
          darkBackground,
        'border-red': error
      }"
      @input="$emit('update:modelValue', $event.target.value)"
    >
    </textarea>
    <!--DropDown-->
    <select
      class="rounded focus:ring-[3px] transition-all duration-250 ease w-full"
      v-else-if="type === 'select'"
      :id="id"
      :name="id"
      :value="modelValue"
      :class="{
        'border-gray-300 focus:border-dark-blue focus:ring-dark-blue focus:ring-opacity-50':
          !darkBackground,
        'focus:border-yellow focus:ring-yellow focus:ring-opacity-50':
          darkBackground,
        'border-red': error
      }"
      @change="$emit('update:modelValue', $event.target.value)"
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
      :disabled="disabled"
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
import Editor from "@tinymce/tinymce-vue"
export default {
  components: {
    Editor
  },
  props: {
    label: String,
    modelValue: {
      required: true
    },
    type: {
      type: String,
      default: "text"
    },
    id: {
      type: String
    },
    darkBackground: {
      type: Boolean
    },
    placeholder: {
      type: String
    },
    error: {
      type: String
    },
    disabled: {
      type: Boolean,
      default: false
    }
  },
  emits: ["update:modelValue"]
}
</script>
