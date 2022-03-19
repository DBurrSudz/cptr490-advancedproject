<template>
  <nav class="h-screen sticky top-0 left-0 w-60 bg-dark-blue py-8 px-6">
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
    <SidebarLink
      label="Announcements"
      icon="fas fa-newspaper"
      :active="route().current('*.announcements.index')"
      :href="
        userIsAdmin()
          ? route('admin.announcements.index')
          : route('student.announcements.index')
      "
    />
    <SidebarLink
      label="Jobs/Requests"
      icon="fas fa-book-reader"
      :active="route().current('*.jobs.*')"
      :href="
        userIsAdmin() ? route('admin.jobs.index') : route('student.jobs.index')
      "
    />
    <SidebarLink
      :label="userIsAdmin() ? 'My Announcements' : 'My Jobs'"
      icon="fas fa-smile-beam"
      :active="
        route().current('admin.my-announcements.index') ||
        route().current('student.my-jobs.index')
      "
      :href="
        userIsAdmin()
          ? route('admin.my-announcements.index')
          : route('student.my-jobs.index')
      "
    />
    <SidebarLink
      v-if="!userIsAdmin()"
      label="Bookings"
      icon="fas fa-calendar-day"
      :active="route().current('student.bookings.index')"
      :href="route('student.bookings.index')"
    />
    <SidebarLink
      label="Profile"
      icon="fas fa-id-card"
      :active="route().current('*.profile')"
      :href="userIsAdmin() ? route('admin.profile') : route('student.profile')"
    />
    <SidebarLink
      class="text-white"
      label="Sign Out"
      icon="fas fa-sign-out-alt"
      as="button"
      :href="userIsAdmin() ? route('admin.logout') : route('logout')"
      method="post"
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
