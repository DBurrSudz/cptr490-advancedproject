<template>
  <DashboardLayout
    :title="userIsStudent() ? 'Jobs' : 'Manage Jobs'"
    :heading="userIsStudent() ? 'Available Jobs' : 'Manage Jobs'"
  >
    <SearchBar />
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
            class="bg-white border-l-8 border-b hover:bg-gray-100"
            :class="{
              'border-l-lime-500': job.approved,
              'border-l-red': !job.approved
            }"
          >
            <td class="text-sm font-medium text-faint-blue px-6 py-4 text-left">
              {{ job.title }}
            </td>
            <td class="text-sm font-medium text-faint-blue px-6 py-4 text-left">
              {{ job.user.first_name }} {{ job.user.last_name }}
            </td>
            <td class="text-sm font-medium text-faint-blue px-6 py-4 text-left">
              {{ job.created_at }}
            </td>
            <td class="text-sm font-medium text-faint-blue px-6 py-4 text-left">
              <i
                class="mr-2"
                :class="{
                  'fas fa-check text-lime-500': job.approved,
                  'fas fa-times-circle text-red': !job.approved
                }"
              ></i>
              <span v-text="job.approved ? 'Approved' : 'Unapproved'" />
            </td>
            <td
              v-text="
                job.approved
                  ? job.admin.first_name + '' + job.admin.last_name
                  : 'N/A'
              "
              class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
            ></td>
            <td
              v-text="job.approved ? job.date_posted : 'N/A'"
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
import { toRefs } from "vue"
import JobCard from "@/Components/Jobs/JobCard.vue"
import SearchBar from "@/Components/Common/SearchBar.vue"

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
    const { jobs } = toRefs(props)
    const { userIsAdmin, userIsStudent } = useUser()
    return { userIsAdmin, userIsStudent }
  }
}
</script>

<style></style>
