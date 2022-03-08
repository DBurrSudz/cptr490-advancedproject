<template>
  <div class="bg-white mb-8 w-10/12 border-b-2">
    <p class="text-dark-blue font-semibold">
      {{ comment.user.first_name }} {{ comment.user.last_name }}
    </p>
    <p>{{ comment.body }}</p>
    <div class="flex justify-between items-center">
      <div>
        <span class="text-gray-300 italic mr-2 text-xs"
          >Posted: {{ formatDate(comment.created_at) }}</span
        >
        <span
          class="text-gray-300 italic text-xs"
          v-if="
            formatDate(comment.created_at) !== formatDate(comment.updated_at)
          "
          >(edited)</span
        >
      </div>
      <div v-if="$page.props.auth.user.id === comment.user.id || userIsAdmin()">
        <Link v-if="!userIsAdmin()" class="mr-2" href="">
          <i class="fas fa-edit text-lime-500"></i>
        </Link>
        <i
          class="fas fa-trash text-red cursor-pointer"
          @click="$inertia.delete(route('comments.destroy', comment.id))"
        ></i>
      </div>
    </div>
  </div>
</template>

<script>
import useDateFormat from "@/composables/useDateFormat"
import useUser from "@/composables/useUser"
import { Link } from "@inertiajs/inertia-vue3"
export default {
  components: {
    Link
  },
  props: {
    comment: {
      type: Object,
      required: true
    }
  },
  data() {
    const { userIsAdmin } = useUser()
    return {
      formatDate: useDateFormat(),
      userIsAdmin: userIsAdmin
    }
  }
}
</script>
