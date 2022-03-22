<template>
  <DashboardLayout
    title="Announcements"
    :heading="userIsStudent() ? 'Announcements' : 'Manage Announcements'"
  >
    <div class="flex justify-between">
      <SearchBar />
      <Link v-if="userIsAdmin()" :href="route('admin.announcements.create')">
        <button class="text-white bg-dark-blue py-2 px-4 shadow-lg rounded-lg">
          <i class="text-[15px] fas fa-plus"></i>
        </button>
      </Link>
    </div>
    <NoResource
      v-if="announcements.length === 0"
      type="announcements"
      :create="userIsAdmin()"
      icon="fas fa-newspaper"
    />
    <div v-else-if="userIsStudent()" class="grid grid-cols-3 gap-x-4 mt-8">
      <AnnouncementCard
        v-for="announcement in announcements"
        :key="announcement.id"
        :announcement="announcement"
      />
    </div>

    <div v-else class="w-full">
      <div class="text-dark-blue w-full p-2 mt-8">
        <h1 class="h3 text-gray-500">Manage Announcements</h1>
      </div>
      <div class="bg-white rounded-lg shadow-md p-2">
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
              <td
                class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
              >
                {{ announcement.title }}
              </td>
              <td
                class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
              >
                {{ announcement.admin.first_name }}
                {{ announcement.admin.last_name }}
              </td>
              <td
                class="text-sm font-medium text-faint-blue px-6 py-4 text-left"
              >
                {{ formatDate(announcement.created_at) }}
              </td>
              <td class="px-6 py-4 flex justify-evenly items-center">
                <Link
                  :href="route('announcements.destroy', announcement.id)"
                  method="delete"
                  as="button"
                  class="text-red mr-3"
                >
                  <i class="fas fa-trash"></i>
                </Link>
                <Link
                  :href="route('admin.announcements.edit', announcement.id)"
                >
                  <i class="fas fa-edit text-green mr-2 pr-4"></i>
                </Link>
                <Link
                  class="text-blue-500"
                  :href="route('admin.announcements.show', announcement.id)"
                >
                  <i class="fas fa-external-link-alt"></i>
                </Link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </DashboardLayout>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3"
import useUser from "@/composables/useUser"
import DashboardLayout from "@/Layouts/DashboardLayout"
import NoResource from "@/Components/Common/NoResource.vue"
import SearchBar from "@/Components/Common/SearchBar.vue"
import AnnouncementCard from "@/Components/Announcements/AnnouncementCard.vue"
import useDateFormat from "@/composables/useDateFormat"
export default {
  components: {
    Link,
    DashboardLayout,
    NoResource,
    SearchBar,
    AnnouncementCard
  },
  props: {
    announcements: {
      type: Array,
      required: true
    }
  },
  setup() {
    const { userIsAdmin, userIsStudent } = useUser()
    const formatDate = useDateFormat()
    return { userIsAdmin, userIsStudent, formatDate }
  }
}
</script>

<style></style>
