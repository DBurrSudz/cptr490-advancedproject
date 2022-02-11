<template></template>

<script>
import { Link } from "@inertiajs/inertia-vue3"
import useUser from "@/composables/useUser"
import DashboardLayout from "@/Layouts/DashboardLayout"
export default {
  components: {
    Link,
    DashboardLayout
  },
  props: {
    announcements: {
      type: Array,
      required: true
    }
  },
  setup() {
    const { userIsAdmin, userIsStudent } = useUser()

    return { userIsAdmin, userIsStudent }
  }
}
</script>

<style></style>
