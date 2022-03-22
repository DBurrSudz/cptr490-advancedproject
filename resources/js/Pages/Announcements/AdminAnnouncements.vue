<template>
  <DashboardLayout title="My Announcements" heading="My Announcements">
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
      icon="fas fa-newspaper"
      :create="true"
    />
    <div class="w-full" v-else>
      <div class="text-dark-blue w-full p-2 mt-8">
        <h1 class="h3 text-gray-500">Announcements</h1>
      </div>
      <div class="bg-white rounded-[20px] p-8 shadow-lg">
        <ul
          v-for="announcement in announcements"
          :key="announcement.id"
          class="text-faint-blue text-sm font-sans bg-white rounded-r-xl py-3 px-6 w-full drop-shadow-lg grid grid-cols-5 gap-x-4 mb-4 hover:bg-gray-200"
        >
          <li>{{ announcement.title }}</li>
          <li>Created: {{ formatDate(announcement.created_at) }}</li>
          <li class="pl-2">
            Last Edited: {{ formatDate(announcement.updated_at) }}
          </li>
          <li class="pl-32">Category: {{ announcement.category }}</li>
          <li>
            <div style="float: right">
              <Link :href="route('admin.announcements.show', announcement.id)">
                <i class="fas fa-external-link-alt text-blue-500 mr-2 pr-4"></i>
              </Link>
              <Link :href="route('admin.announcements.edit', announcement.id)">
                <i class="fas fa-edit text-green mr-2 pr-4"></i>
              </Link>
              <i
                class="fas fa-trash text-red mr-2 cursor-pointer"
                @click="
                  $inertia.delete(
                    route('announcements.destroy', announcement.id)
                  )
                "
              ></i>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </DashboardLayout>
</template>

<script>
import DashboardLayout from "@/Layouts/DashboardLayout"
import NoResource from "@/Components/Common/NoResource.vue"
import { Link } from "@inertiajs/inertia-vue3"
import SearchBar from "@/Components/Common/SearchBar.vue"
import useUser from "@/composables/useUser"
import useDateFormat from "@/composables/useDateFormat"
export default {
  components: {
    DashboardLayout,
    NoResource,
    Link,
    SearchBar
  },
  props: {
    announcements: {
      type: Array,
      required: true
    }
  },
  setup() {
    const formatDate = useDateFormat()
    const { userIsAdmin, userIsStudent } = useUser()
    return { formatDate, userIsAdmin, userIsStudent }
  }
}
</script>
