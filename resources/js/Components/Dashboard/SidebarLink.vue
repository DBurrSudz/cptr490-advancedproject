<template>
  <!-- Nav Link -->
  <Link
    class="flex items-center py-4 px-6 rounded-md"
    :class="{
      'bg-lime-500 text-white': active,
      'text-gray-400': !active
    }"
  >
    <i class="mr-3" :class="icon" />
    <span v-text="label" class="font-medium" />
  </Link>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3"

export default {
  components: {
    Link
  },

  props: {
    icon: String,
    label: String,
    active: Boolean
  }
}
</script>
