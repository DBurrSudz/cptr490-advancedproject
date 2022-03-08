<template>
  <DashboardLayout heading="Applicants" title="Applications">
    <h1 class="h3 font-semibold">Applicants ({{ bookings.length }})</h1>
    <div class="w-full mt-2 bg-white rounded-lg shadow-lg h-[500px] p-4">
      <table class="min-w-full">
        <thead class="bg-white border-b-faint-blue">
          <tr>
            <th
              scope="col"
              class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
            >
              Student
            </th>
            <th
              scope="col"
              class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
            >
              Date Applied
            </th>
            <th
              scope="col"
              class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
            >
              Status
            </th>
            <th
              scope="col"
              class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
            >
              Actions
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="booking in bookings"
            :key="booking.id"
            class="bg-white border-b hover:bg-gray-100"
          >
            <td class="text-sm font-medium text-faint-blue px-6 py-4 text-left">
              {{ booking.user.first_name }} {{ booking.user.last_name }}
            </td>
            <td class="text-sm font-medium text-faint-blue px-6 py-4 text-left">
              {{ formatDate(booking.created_at) }}
            </td>
            <td class="text-sm font-medium text-faint-blue px-6 py-4 text-left">
              <p
                class="p-2 text-center text-xs rounded-full w-[120px]"
                :class="{
                  'bg-green-300 text-green-700': booking.accepted,
                  'bg-rose-400 text-rose-700': !booking.accepted
                }"
              >
                {{ booking.accepted ? "Accepted" : "Pending.." }}
              </p>
            </td>
            <td class="text-blue-500 px-6 py-4 text-center">
              <button
                @click="$inertia.put(route('bookings.update', booking.id))"
                class="rounded-md py-2 px-4 bg-rose-600 text-sm text-white"
              >
                {{ booking.accepted ? "Decline" : "Accept" }}
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </DashboardLayout>
</template>

<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue"
import useDateFormat from "@/composables/useDateFormat"
export default {
  components: {
    DashboardLayout
  },
  props: {
    bookings: {
      type: Array,
      required: true
    }
  },
  setup() {
    const formatDate = useDateFormat()

    return { formatDate }
  }
}
</script>
