<template>
  <DashboardLayout
    title="Dashboard"
    :heading="userIsStudent() ? 'Dashboard' : 'Dashboard - Admin'"
  >
    <div class="grid grid-cols-3 gap-x-2">
      <DashboardCard
        class="text-faint-blue"
        :count="userIsStudent() ? jobsCreatedCount : announcementsPostedCount"
        :label="userIsStudent() ? 'Jobs Created' : 'Announcements Posted'"
        :icon="
          userIsStudent()
            ? 'fas fa-scroll text-faint-blue'
            : 'fas fa-bullhorn text-faint-blue'
        "
      />

      <DashboardCard
        :class="{
          'text-lime-500': userIsAdmin(),
          'text-blue-500': userIsStudent()
        }"
        :count="userIsAdmin() ? jobsApprovedCount : bookingsCount"
        :label="userIsStudent() ? 'Bookings' : 'Jobs Approved'"
        :icon="
          userIsStudent()
            ? 'fas fa-calendar-day text-blue-500'
            : 'fas fa-tasks text-lime-500'
        "
      />

      <DashboardCard
        class="text-rose-600"
        :count="userIsStudent() ? unapprovedCount : jobsUnapproved"
        :label="
          userIsStudent()
            ? 'Jobs Pending Approval'
            : 'Total Jobs Pending Approval'
        "
        icon="fas fa-exclamation-circle text-rose-600"
      />
    </div>

    <div v-if="userIsStudent()" class="text-dark-blue w-full p-2 mt-8">
      <h1 class="h3 text-gray-500">Recently Created Jobs</h1>
    </div>
    <!--Recently Created Jobs-->
    <div v-if="userIsStudent()" class="bg-white rounded-lg shadow-md p-2">
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
              Created
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
            v-for="job in jobsStudent"
            :key="job.id"
            class="bg-white border-b hover:bg-gray-100"
          >
            <td class="text-sm font-medium text-faint-blue px-6 py-4 text-left">
              {{ job.title }}
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
            <td class="text-blue-500 px-6 py-4 text-center">
              <Link
                :href="
                  userIsStudent()
                    ? route('student.jobs.show', job.id)
                    : route('admin.jobs.show', job.id)
                "
              >
                <i class="fas fa-external-link-alt"></i>
              </Link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="userIsStudent()" class="text-dark-blue w-full p-2 mt-8">
      <h1 class="h3 text-gray-500">Recently Posted Comments</h1>
    </div>
    <!--Recently Posted Comments-->
    <div v-if="userIsStudent()" class="bg-white rounded-lg shadow-md p-2">
      <table class="min-w-full">
        <thead class="bg-white border-b-faint-blue">
          <tr>
            <th
              scope="col"
              class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
            >
              Message
            </th>
            <th
              scope="col"
              class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
            >
              Posted On
            </th>
            <th
              scope="col"
              class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
            >
              Last Updated
            </th>
            <th
              scope="col"
              class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
            >
              Posted To
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="comment in comments"
            :key="comment.id"
            class="bg-white border-b hover:bg-gray-100"
          >
            <td class="text-sm font-medium text-faint-blue px-6 py-4 text-left">
              {{ comment.body }}
            </td>
            <td class="text-sm font-medium text-faint-blue px-6 py-4 text-left">
              {{ formatDate(comment.created_at) }}
            </td>
            <td class="text-sm font-medium text-faint-blue px-6 py-4 text-left">
              {{ formatDate(comment.updated_at) }}
            </td>
            <td class="text-sm font-medium text-faint-blue px-6 py-4 text-left">
              {{ comment.job.title }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="userIsAdmin()" class="text-dark-blue w-full p-2 mt-8">
      <h1 class="h3 text-gray-500">Jobs Recently Approved</h1>
    </div>
    <!--Jobs Recently Approved-->
    <div v-if="userIsAdmin()" class="bg-white rounded-lg shadow-md p-2">
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
              Request
            </th>
            <th
              scope="col"
              class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
            >
              Approved On
            </th>
            <th
              scope="col"
              class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
            >
              Submitted On
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
            v-for="job in jobsAdmin"
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
              {{ job.request ? "Yes" : "No" }}
            </td>
            <td class="text-sm font-medium text-faint-blue px-6 py-4 text-left">
              {{ formatDate(job.date_posted) }}
            </td>
            <td class="text-sm font-medium text-faint-blue px-6 py-4 text-left">
              {{ formatDate(job.created_at) }}
            </td>
            <td class="text-blue-500 px-6 py-4 text-center">
              <Link :href="route('admin.jobs.show', job.id)">
                <i class="fas fa-external-link-alt"></i>
              </Link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="userIsAdmin()" class="text-dark-blue w-full p-2 mt-8">
      <h1 class="h3 text-gray-500">Announcements Recently Created</h1>
    </div>
    <!--Announcements Recently Created-->
    <div v-if="userIsAdmin()" class="bg-white rounded-lg shadow-md p-2">
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
              Category
            </th>
            <th
              scope="col"
              class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
            >
              Posted
            </th>
            <th
              scope="col"
              class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
            >
              Last Updated
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
            v-for="announcement in announcements"
            :key="announcement.id"
            class="bg-white border-b hover:bg-gray-100"
          >
            <td class="text-sm font-medium text-faint-blue px-6 py-4 text-left">
              {{ announcement.title }}
            </td>
            <td class="text-sm font-medium text-faint-blue px-6 py-4 text-left">
              {{ announcement.category }}
            </td>
            <td class="text-sm font-medium text-faint-blue px-6 py-4 text-left">
              {{ formatDate(announcement.created_at) }}
            </td>
            <td class="text-sm font-medium text-faint-blue px-6 py-4 text-left">
              {{ formatDate(announcement.updated_at) }}
            </td>
            <td class="text-blue-500 px-6 py-4 text-center">
              <Link :href="route('admin.announcements.show', announcement.id)">
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
import DashboardLayout from "@/Layouts/DashboardLayout"
import DashboardCard from "@/Components/Home/DashboardCard.vue"
import { Link } from "@inertiajs/inertia-vue3"
import useUser from "@/composables/useUser"
import useDateFormat from "@/composables/useDateFormat"

export default {
  props: {
    jobsStudent: Array,
    unapprovedCount: Number,
    comments: Array,
    jobsCreatedCount: Number,
    jobsAdmin: Array,
    announcements: Array,
    announcementsPostedCount: Number,
    jobsApprovedCount: Number,
    jobsUnapproved: Number,
    bookingsCount: Number
  },
  components: {
    DashboardLayout,
    DashboardCard,
    Link
  },
  setup() {
    const { userIsStudent, userIsAdmin } = useUser()
    const formatDate = useDateFormat()

    return {
      userIsStudent,
      userIsAdmin,
      formatDate
    }
  }
}
</script>

