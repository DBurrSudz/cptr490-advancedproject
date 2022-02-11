<template>
  <DashboardLayout heading="My Jobs" title="My Jobs">
    <SearchBar />

    <Link v-if="jobs.length > 0" :href="route('student.jobs.create')">
      <i class="mt-4 text-[25px] text-lime-500 fas fa-plus-circle"></i>
    </Link>

    <NoResource v-if="jobs.length === 0" type="job" :create="true" />
    <div v-else class="bg-white rounded-[20px] p-8 shadow-lg mt-4">
      <ul
        v-for="job in jobs"
        :key="job.id"
        class="text-faint-blue text-sm font-sans bg-white rounded-xl py-3 px-6 w-full drop-shadow-lg grid grid-cols-5 gap-x-4 mb-4 hover:bg-gray-200"
        :class="{
          'border-l-4 border-lime-500': job.approved,
          'border-l-4 border-red': !job.approved
        }"
      >
        <li>{{ job.title }}</li>
        <li>Created: {{ job.created_at }}</li>
        <li class="pl-2">Last Edited: {{ job.updated_at }}</li>
        <li class="pl-32">Approved: ({{ job.date_posted }})</li>
        <li>
          <div style="float: right">
            <Link :href="route('student.jobs.show', job.id)">
              <i class="fas fa-external-link-alt text-blue-500 mr-2 pr-4"></i>
            </Link>
            <Link :href="route('student.jobs.edit', job.id)">
              <i class="fas fa-edit text-green mr-2 pr-4"></i>
            </Link>
            <i
              class="fas fa-trash text-red mr-2 cursor-pointer"
              @click="$inertia.delete(route('jobs.destroy', job.id))"
            ></i>
          </div>
        </li>
      </ul>
    </div>
  </DashboardLayout>
</template>

<script>
import DashboardLayout from "@/Layouts/DashboardLayout"
import NoResource from "@/Components/Common/NoResource.vue"
import { Link } from "@inertiajs/inertia-vue3"
import SearchBar from "@/Components/Common/SearchBar.vue"
export default {
  components: {
    DashboardLayout,
    NoResource,
    Link,
    SearchBar
  },
  props: {
    jobs: {
      type: Array,
      required: true
    }
  }
}
</script>

<style></style>