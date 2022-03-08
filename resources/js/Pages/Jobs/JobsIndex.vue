<template>
  <DashboardLayout
    :title="userIsStudent() ? 'Jobs' : 'Manage Jobs'"
    :heading="userIsStudent() ? 'Available Jobs' : 'Manage Jobs'"
  >
    <div class="flex justify-between">
      <SearchBar />
      <Link v-if="userIsStudent()" :href="route('student.jobs.create')">
        <button class="text-white bg-dark-blue py-2 px-4 shadow-lg rounded-lg">
          <i class="text-[15px] fas fa-plus"></i>
        </button>
      </Link>
    </div>
    <NoResource
      v-if="jobs.length === 0"
      type="jobs"
      :create="userIsStudent()"
      icon="fas fa-book-reader"
    />

    <div v-else-if="userIsStudent()" class="grid grid-cols-3 gap-x-4 mt-8">
      <JobCard v-for="job in jobs" :key="job.id" :job="job" />
    </div>

    <div v-else class="bg-white rounded-lg shadow-md p-2 mt-2">
      <table class="min-w-full">
        <thead class="bg-white border-b-faint-blue">
          <tr>
            <th
              scope="col"
              class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
            >
              Title
            </th>
            <th
              scope="col"
              class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
            >
              Created By
            </th>
            <th
              scope="col"
              class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
            >
              Created On
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
              Request
            </th>
            <th
              scope="col"
              class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
            >
              Approved By
            </th>
            <th
              scope="col"
              class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
            >
              Date Approved
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
            v-for="job in jobs"
            :key="job.id"
            class="bg-white border-b hover:bg-gray-100"
          >
            <td class="text-sm font-medium text-faint-blue px-6 py-4 text-left">
              {{ job.title }}
            </td>
            <td class="text-sm font-medium text-faint-blue px-6 py-4 text-left">
              {{ job.user.first_name }} {{ job.user.last_name }}
            </td>
            <td class="text-sm font-medium text-faint-blue px-6 py-4 text-left">
              {{ formatDate(job.created_at) }}
            </td>
            <td class="text-sm font-medium text-faint-blue px-6 py-4 text-left">
              <p
                class="p-2 text-center text-xs rounded-full w-[120px]"
                :class="{
                  'bg-green-300 text-green-700': job.approved,
                  'bg-rose-400 text-rose-700': !job.approved
                }"
              >
                {{ job.approved ? "Approved" : "Pending.." }}
              </p>
            </td>
            <td class="text-sm font-medium text-faint-blue px-6 py-4 text-left">
              {{ job.request ? "Yes" : "No" }}
            </td>
            <td
              v-text="
                job.approved
                  ? job.admin.first_name + ' ' + job.admin.last_name
                  : 'N/A'
              "
              class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
            ></td>
            <td
              v-text="job.approved ? formatDate(job.date_posted) : 'N/A'"
              class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
            ></td>
            <td class="px-6 py-4 flex justify-evenly items-center">
              <Link
                :href="route('jobs.destroy', job.id)"
                method="delete"
                as="button"
                class="text-red mr-3"
              >
                <i class="fas fa-trash"></i>
              </Link>
              <Link
                class="mr-3"
                :class="{
                  'text-lime-500': !job.approved,
                  'text-red': job.approved
                }"
                method="put"
                as="button"
                :href="route('admin.jobs.status', job.id)"
              >
                <i
                  :class="{
                    'fas fa-check': !job.approved,
                    'fas fa-times': job.approved
                  }"
                ></i>
              </Link>
              <Link
                class="text-blue-500"
                :href="route('admin.jobs.show', job.id)"
              >
                <i class="fas fa-external-link-alt"></i>
              </Link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </DashboardLayout>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3"
import useUser from "@/composables/useUser"
import DashboardLayout from "@/Layouts/DashboardLayout"
import NoResource from "@/Components/Common/NoResource.vue"
import JobCard from "@/Components/Jobs/JobCard.vue"
import SearchBar from "@/Components/Common/SearchBar.vue"
import useDateFormat from "@/composables/useDateFormat"

export default {
  components: {
    Link,
    DashboardLayout,
    NoResource,
    JobCard,
    SearchBar
  },
  props: {
    jobs: {
      type: Array,
      required: true
    }
  },
  setup(props) {
    const { userIsAdmin, userIsStudent } = useUser()
    const formatDate = useDateFormat()
    return { userIsAdmin, userIsStudent, formatDate }
  }
}
</script>

<style></style>
