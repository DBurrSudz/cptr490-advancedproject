<template>
  <DashboardLayout :title="announcement.title" heading="Announcement">
    <div class="shadow-md bg-white w-full">
      <div class="w-full h-[10px] flex flex-row">
        <div class="h-full w-10/12 bg-dark-blue"></div>
        <div class="h-full w-2/12 bg-yellow"></div>
      </div>
      <div class="p-4 h-[700px]">
        <div class="w-full h-[100px] p-8 mb-3">
          <h1 class="h3 text-dark-blue font-semibold">
            {{ announcement.title }}
          </h1>
          <span><i class="text-gray-400 fas fa-clock mr-2"></i></span>
          <span class="italic text-gray-400 text-[12px] mr-2"
            >Posted: {{ formatDate(announcement.created_at) }}</span
          >
          <span class="italic text-gray-400 text-[12px]"
            >Last updated: {{ formatDate(announcement.updated_at) }}</span
          >
        </div>
        <div class="w-full h-[550px] flex flex-row">
          <div class="h-full w-2/12 overflow-auto p-4">
            <div class="text-center p-2 mb-8 shadow-md rounded-md">
              <h1 class="h4 font-medium text-dark-blue">
                <i class="text-faint-blue fas fa-user mr-2"></i>Admin
              </h1>
              <p class="text-[14px]">
                {{ admin.first_name }} {{ admin.last_name }}
              </p>
            </div>
            <div class="text-center p-2 mb-8 shadow-md rounded-md">
              <h1 class="h4 font-medium text-dark-blue">
                <i class="text-amber-400 fas fa-certificate mr-2"></i>Type
              </h1>
              <p
                class="text-white text-[14px] rounded-lg p-2"
                :class="{
                  'bg-indigo-700': announcement.category === 'Scholarship',
                  'bg-cool-gray-600': announcement.category === 'General',
                  'bg-amber-600': announcement.category === 'Other',
                  'bg-rose-600': announcement.category === 'Internship/Job'
                }"
              >
                {{ announcement.category }}
              </p>
            </div>
          </div>
          <div class="h-full w-10/12">
            <div class="w-full p-4 border-b-2">
              <h1 class="h3 text-dark-blue font-semibold">Details</h1>
            </div>
            <div
              v-html="announcement.description"
              class="p-4 w-full overflow-auto h-[500px]"
            ></div>
          </div>
        </div>
      </div>
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
  data() {
    return {
      formatDate: useDateFormat()
    }
  },
  computed: {
    announcementFlair() {
      if (this.announcement.category === "Scholarship") return "bg-indigo-700"
      else if (this.announcement.category === "Internship/Job")
        return "bg-rose-600"
      else if (this.announcement.category === "General")
        return "bg-cool-gray-600"
      else return "bg-amber-600"
    }
  },
  props: {
    announcement: {
      type: Object,
      required: true
    },
    admin: {
      type: Object,
      required: true
    }
  }
}
</script>
