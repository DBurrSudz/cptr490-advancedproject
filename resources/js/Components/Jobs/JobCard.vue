<template>
  <!--Card-->
  <div class="bg-white rounded-lg border-t-4 border-faint-blue shadow-md p-8">
    <!--Card Header-->
    <div class="flex justify-between items-center">
      <div class="flex">
        <div class="mr-2">
          <i class="text-[40px] fas fa-book-reader text-gray-300"></i>
        </div>
        <div>
          <h1 class="h4">{{ jobCreator }}</h1>
          <p class="text-sm text-gray-400 italic">
            Posted: {{ job.date_posted }}
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
        <p class="text-sm text-green">{{ job.comments_count }} Comments</p>
      </div>
      <div>
        <p class="text-sm">Paid: <i :class="paidIconClass"></i></p>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3"
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
  }
}
</script>
