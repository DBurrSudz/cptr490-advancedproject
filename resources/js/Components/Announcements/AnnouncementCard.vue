<template>
  <!--Card-->
  <div class="bg-white rounded-lg shadow-md">
    <!--Card Header-->
    <div
      class="w-full text-center p-2 rounded-t-xl"
      :class="{
        'bg-sky-800': announcement.category === 'Scholarship',
        'bg-rose-700': announcement.category === 'General',
        'bg-indigo-800': announcement.category === 'Other',
        'bg-yellow-700': announcement.category === 'Internship/Job'
      }"
    >
      <h1 class="h3 text-white">{{ announcement.category }}</h1>
    </div>

    <div class="p-8">
      <!--Card Body 1-->
      <div class="flex justify-between items-center">
        <div class="flex">
          <div class="mr-2">
            <i class="text-[40px] fas fa-newspaper text-gray-300"></i>
          </div>
          <div>
            <h1 class="h4">N.C.U</h1>
            <p class="text-sm text-gray-400 italic">
              <i class="fas fa-clock"></i> Posted:
              {{ formatDate(announcement.created_at) }}
            </p>
          </div>
        </div>
        <!--View Button Link-->
        <div>
          <Link class="text-blue-500" :href="viewAnnouncement">
            <i class="fas fa-external-link-alt"></i>
          </Link>
        </div>
      </div>
      <!--Card Body-->
      <div class="text-[18px] font-semibold text-dark-blue h-[200px] mt-3">
        {{ announcement.title }}
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3"
import useDateFormat from "@/composables/useDateFormat"
export default {
  components: {
    Link
  },
  computed: {
    viewAnnouncement() {
      return route("student.announcements.show", this.announcement.id)
    },
    backgroundColor() {
      if (this.announcement.category === "Scholarship") return "bg-indigo-800"
      else if (this.announcement.category === "General") return "bg-pink-800"
      else if (this.announcement.category === "Other") return "bg-faint-blue"
      else return "bg-teal-800"
    }
  },
  props: {
    announcement: {
      required: true,
      type: Object
    }
  },
  setup() {
    const formatDate = useDateFormat()
    return { formatDate }
  }
}
</script>
