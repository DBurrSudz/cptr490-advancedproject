<template>
  <DashboardLayout title="Dashboard" heading="Dashboard">
    <div class="grid grid-cols-3 gap-x-2">
      <DashboardCard
        class="bg-gradient-to-r from-faint-blue to-dark-blue"
        :count="userIsStudent() ? jobsCreatedCount : announcementsPostedCount"
        :label="userIsStudent() ? 'Jobs Created' : 'Announcements Posted'"
        :icon="
          userIsStudent()
            ? 'fas fa-scroll text-white'
            : 'fas fa-bullhorn text-white'
        "
      />

      <DashboardCard
        v-if="userIsAdmin()"
        class="bg-gradient-to-r from-green-500 to-green-700"
        :count="jobsApprovedCount"
        label="Jobs Approved"
        icon="fas fa-tasks text-white"
      />

      <DashboardCard
        class="bg-gradient-to-r from-red-500 to-red-400"
        :count="userIsStudent() ? unapprovedCount : jobsUnapproved"
        :label="
          userIsStudent()
            ? 'Jobs Pending Approval'
            : 'Total Jobs Pending Approval'
        "
        icon="fas fa-exclamation-circle text-white"
      />
    </div>

    <!--Recently Created Jobs-->
    <div v-if="userIsStudent()" class="mt-4 bg-white rounded-lg shadow-md p-2">
      <div class="text-dark-blue w-full p-2">
        <h1 class="h4">Recently Created Jobs</h1>
      </div>
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
              {{ formatDate(job.created_at) }}
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

    <!--Recently Posted Comments-->
    <div v-if="userIsStudent()" class="mt-4 bg-white rounded-lg shadow-md p-2">
      <div class="text-dark-blue w-full p-2">
        <h1 class="h4">Recently Posted Comments</h1>
      </div>
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

    <!--Jobs Recently Approved-->
    <div v-if="userIsAdmin()" class="mt-4 bg-white rounded-lg shadow-md p-2">
      <div class="text-dark-blue w-full p-2">
        <h1 class="h4">Jobs Recently Approved</h1>
      </div>
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

    <!--Announcements Recently Created-->
    <div v-if="userIsAdmin()" class="mt-4 bg-white rounded-lg shadow-md p-2">
      <div class="text-dark-blue w-full p-2">
        <h1 class="h4">Announcements Recently Created</h1>
      </div>
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
    jobsUnapproved: Number
  },
  components: {
    DashboardLayout,
    DashboardCard,
    Link
  },
  setup(props) {
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
