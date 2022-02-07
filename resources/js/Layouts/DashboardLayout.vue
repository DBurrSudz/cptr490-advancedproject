<template>
  <Head :title="title" />

  <div class="flex">
    <!-- Sidebar -->
    <Sidebar />

    <div class="py-8 px-12 grow bg-gray">
      <!-- Header -->
      <header class="mb-12">
        <h1 class="text-[30px]" v-text="heading" />
      </header>

      <!-- Main Content -->
      <main><slot /></main>
    </div>
  </div>
</template>

<script>
import Sidebar from "@/Components/Dashboard/Sidebar"
import { Link, Head } from "@inertiajs/inertia-vue3"

export default {
  components: {
    Head,
    Link,
    Sidebar
  },

  props: {
    heading: String,
    title: String
  }
}
</script>
