<template>
  <nav class="h-screen sticky w-60 bg-dark-blue py-8 px-6">
    <!-- Logo -->
    <Link href="/" class="block text-center mb-8">
      <img
        src="@/assets/img/logo/jortal-logo.svg"
        alt="Jortal Logo"
        class="mx-auto"
      />
    </Link>

    <!-- Nav Links -->
    <SidebarLink
      icon="fas fa-tachometer-alt"
      label="Dashboard"
      :active="route().current('*.dashboard')"
      :href="
        userIsAdmin() ? route('admin.dashboard') : route('student.dashboard')
      "
    />
  </nav>
</template>

<script>
import SidebarLink from "@/Components/Dashboard/SidebarLink"
import { Link } from "@inertiajs/inertia-vue3"
import useUser from "@/composables/useUser"

export default {
  components: {
    Link,
    SidebarLink
  },

  setup() {
    const { userIsAdmin } = useUser()

    return { userIsAdmin }
  }
}
</script>
