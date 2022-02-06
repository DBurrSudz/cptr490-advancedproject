<template>
  <Head :title="pageTitle" />
  <div
    class="flex justify-center items-center min-h-screen w-screen bg-dark-blue py-8 px-4"
  >
    <div class="w-full" :style="{ maxWidth: maxWidth }">
      <div class="text-center text-white mb-4">
        <h1 class="h2 mb-2">{{ formTitle }}</h1>
        <p>Post jobs and stay informed about what is going on at NCU</p>
      </div>
      <form class="rounded" @submit.prevent="$emit('submit')">
        <slot />
      </form>
    </div>
  </div>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue3"

export default {
  props: {
    pageTitle: {
      type: String,
      required: true
    },
    formTitle: {
      type: String,
      required: true
    },
    maxWidth: {
      type: String,
      default: "480px"
    }
  },
  components: {
    Head
  }
}
</script>
