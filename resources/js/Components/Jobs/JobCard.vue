<template>
  <!--Card-->
  <div
    class="bg-white rounded-lg border-b-8 shadow-md p-8"
    :class="{
      'border-b-indigo-700': !job.request,
      'border-b-rose-600': job.request
    }"
  >
    <!--Card Header-->
    <div class="flex justify-between items-center">
      <div class="flex">
        <div class="mr-2">
          <i class="text-[40px] fas fa-book-reader text-gray-300"></i>
        </div>
        <div>
          <h1 class="h4">{{ jobCreator }}</h1>
          <p class="text-sm text-gray-400 italic">
            <i class="fas fa-clock"></i> Posted:
            {{ formatDate(job.date_posted) }}
          </p>
        </div>
      </div>
      <!--View Button Link-->
      <div>
        <Link class="text-blue-500" :href="viewJob">
          <i class="fas fa-external-link-alt"></i>
        </Link>
      </div>
    </div>
    <!--Card Body-->
    <div class="text-[18px] font-semibold text-dark-blue h-[200px] mt-3">
      {{ job.title }}
    </div>
    <!--Card Footer-->
    <div class="grid grid-cols-2 gap-x-2">
      <div>
        <p class="text-sm text-green">
          <i class="fas fa-comments"></i> {{ job.comments_count }} Comments
        </p>
      </div>
      <div>
        <p class="text-sm">
          <i class="fas fa-credit-card"></i> Paid:
          <i :class="paidIconClass"></i>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3"
import useDateFormat from "@/composables/useDateFormat"
export default {
  computed: {
    viewJob() {
      return route("student.jobs.show", this.job.id)
    },
    jobCreator() {
      return this.job.user.first_name + " " + this.job.user.last_name
    },
    paidIconClass() {
      if (this.job.paid) return "fas fa-check text-green"
      return "fas fa-times text-red"
    }
  },
  components: {
    Link
  },
  props: {
    job: {
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
