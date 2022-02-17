<template>
  <DashboardLayout title="View Job" heading="Job">
    <div class="w-full h-[400px] bg-white shadow-md rounded-lg"></div>
    <div class="w-full mt-4">
      <form @submit.prevent="submit">
        <input
          type="text"
          name="body"
          id="body"
          :value="form.body"
          placeholder="Add a comment..."
          class="bg-gray focus:outline-none focus:ring-0 focus:border-b-blue-500 ease-in border-0 border-b-2 border-b-dark-blue w-10/12"
        />
        <button type="submit" class="btn-green rounded-full">
          Post <i class="fas fa-paper-plane"></i>
        </button>
      </form>
    </div>
    <div class="p-4">
      <div class="text-dark-blue w-full p-4 mt-4">
        <h1 class="text-[18px]">
          Comments ({{ commentsCount }}) <i class="ml-2 fas fa-comments"></i>
        </h1>
      </div>
      <CommentCard
        v-for="comment in comments"
        :key="comment.id"
        :comment="comment"
      />
    </div>
  </DashboardLayout>
</template>

<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue"
import CommentCard from "@/Components/Jobs/CommentCard.vue"
import { useForm } from "@inertiajs/inertia-vue3"
import { toRefs } from "vue"
export default {
  components: {
    DashboardLayout,
    CommentCard
  },
  props: {
    job: {
      required: true,
      type: Object
    },
    comments: {
      type: Array,
      required: true
    },
    user: {
      required: true,
      type: Object
    },
    commentsCount: {
      type: Number,
      required: true
    }
  },
  setup(props) {
    const { job } = toRefs(props)
    const form = useForm({
      body: " ",
      job_id: job.value.id
    })

    function submit() {
      form.submit(route("comments.store"), {
        onSuccess: () => form.reset("body")
      })
    }

    return { submit, form }
  }
}
</script>

<style></style>
