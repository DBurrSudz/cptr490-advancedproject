<template>
  <DashboardLayout title="Bookings" heading="Bookings">
    <SearchBar />
    <NoResource
      v-if="bookings.length === 0"
      icon="fas fa-calendar-day"
      type="bookings"
      :create="false"
    />
    <div class="w-full" v-else>
      <div class="text-dark-blue w-full p-2 mt-8">
        <h1 class="h3 text-gray-500">Bookings</h1>
      </div>
      <div class="mt-2">
        <table class="min-w-full">
          <thead class="bg-white border-b-faint-blue">
            <tr>
              <th
                scope="col"
                class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
              >
                Job
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
              <td
                class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
              >
                <Link :href="route('student.jobs.show', booking.job.id)">
                  {{ booking.job.title }}
                </Link>
              </td>
              <td
                class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
              >
                {{ formatDate(booking.created_at) }}
              </td>
              <td
                class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
              >
                <p
                  class="p-2 text-center text-xs rounded-full w-[120px]"
                  :class="{
                    'bg-green-300 text-green-700': booking.accepted,
                    'bg-rose-400 text-rose-700': !booking.eligible,
                    'bg-blue-300 text-blue-700':
                      !booking.accepted && booking.eligible
                  }"
                >
                  {{ bookingTag(booking) }}
                </p>
              </td>
              <td class="text-blue-500 px-6 py-4 text-center">
                <button
                  @click="
                    $inertia.delete(route('bookings.destroy', booking.id))
                  "
                  class="rounded-md py-2 px-4 bg-rose-600 text-sm text-white"
                >
                  Remove
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </DashboardLayout>
</template>
<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue"
import SearchBar from "@/Components/Common/SearchBar.vue"
import NoResource from "@/Components/Common/NoResource.vue"
import { Link } from "@inertiajs/inertia-vue3"
import useDateFormat from "@/composables/useDateFormat"
import useBookingTag from "@/composables/useBookingTag"
export default {
  props: {
    bookings: {
      type: Array,
      required: true
    }
  },
  components: {
    DashboardLayout,
    SearchBar,
    NoResource,
    Link
  },
  data() {
    return {
      formatDate: useDateFormat(),
      bookingTag: useBookingTag()
    }
  }
}
</script>
