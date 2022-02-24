<template>
  <div class="bg-white shadow-md rounded-lg items-center w-10/12 py-8 px-4">
    <div class="w-full" :style="{ maxWidth: maxWidth }">
      <form class="rounded" @submit.prevent="$emit('submit')">
        <slot />
      </form>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    maxWidth: {
      type: String,
      default: "480px"
    }
  }
}
</script>
