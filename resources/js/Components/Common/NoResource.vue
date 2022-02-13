<template>
  <div class="flex justify-center py-[150px] items-center">
    <div class="text-center text-gray-400">
      <i class="text-[60px]" :class="icon"></i>
      <p class="py-4">Oops! There's currently no {{ type }}</p>
      <div v-if="create" class="text-center">
        <Link :href="formRoute">
          <button class="btn-dark-blue w-40 mt-2">
            Create <i class="fas fa-plus"></i>
          </button>
        </Link>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3"
export default {
  components: {
    Link
  },
  computed: {
    formRoute() {
      if (this.type === "jobs") return route("student.jobs.create")
      return route("admin.announcements.create")
    }
  },
  props: {
    type: {
      required: true,
      type: String
    },
    create: {
      required: true,
      type: Boolean
    },
    icon: {
      type: String,
      required: true
    }
  }
}
</script>
