<template>
  <Head title="Welcome" />

  <div
    class="min-h-screen bg-gradient-to-r from-sky-500 to-indigo-500 sm:items-center sm:pt-0 flex justify-center items-center"
  >
    <div class="text-center">
      <h1 class="h2 text-white font-semibold">Welcome</h1>
      <Link :href="route('login')">
        <h1 class="mt-4 h3 text-white hover:text-yellow">
          Login <i class="fas fa-sign-in-alt"></i>
        </h1>
      </Link>
    </div>
  </div>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3"

export default {
  components: {
    Head,
    Link
  }
}
</script>
