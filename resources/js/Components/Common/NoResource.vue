<template>
  <div class="flex justify-center py-[150px] items-center">
    <div>
      <div class="text-center text-gray-400" v-if="type === 'announcement'">
        <i class="fas fa-newspaper"></i>
        <p>Oops! There's currently no announcements.</p>
      </div>
      <div class="text-center text-gray-400" v-else>
        <i class="text-[70px] fas fa-book-reader"></i>
        <p>Oops! There's currently no jobs.</p>
      </div>
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
      if (this.type === "job") return route("student.jobs.create")
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
    }
  }
}
</script>
