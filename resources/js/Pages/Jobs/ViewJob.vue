<template>
  <DashboardLayout title="View Job" heading="Job">
    <!--Body-->
    <div class="w-full">
      <!--Top Flex-->
      <div class="grid grid-cols-4">
        <!--Title-->
        <div class="p-4">
          <p class="text-dark-blue text-[16px]">{{ job.title }}</p>
        </div>
        <!--Paid-->
        <div class="p-4">
          <p><i class="text-gray-400 fas fa-credit-card"></i> Paid</p>
          <p class="italic text-gray-400 text-[15px]">
            {{ job.paid ? "Yes" : "No" }}
          </p>
        </div>
        <!--Rate-->
        <div class="p-4">
          <p><i class="text-gray-400 fas fa-percentage"></i> Rate</p>
          <p class="italic text-gray-400 text-[15px]">
            {{ job.paid ? job.rate : "N/A" }}
          </p>
        </div>
        <!--Dates-->
        <div class="p-4">
          <p class="italic text-gray-400 text-[15px]">
            <i class="text-gray-400 fas fa-clock"></i> Posted:
            {{ job.approved ? formatDate(job.date_posted) : "N/A" }}
          </p>
          <p class="italic text-gray-400 text-[15px]">
            Last Edited: {{ formatDate(job.updated_at) }}
          </p>
        </div>
      </div>
      <div class="flex flex-row">
        <!--Description-->
        <div class="p-8 bg-white w-10/12 shadow-lg">
          <div class="w-full border-b-2">
            <h1 class="h3 font-semibold text-dark-blue">Details</h1>
          </div>
          <div
            v-html="job.description"
            class="w-full h-[600px] overflow-auto py-8"
          ></div>
        </div>
        <!--Student Information-->
        <div class="bg-gray">
          <div class="w-full p-4 flex justify-center items-center h-1/6">
            <Link>
              <button
                class="text-white rounded-md w-[200px] h-[50px] capitalize bg-dark-blue"
              >
                Student Profile <i class="ml-2 fas fa-external-link-alt"></i>
              </button>
            </Link>
          </div>
        </div>
      </div>
    </div>
    <div class="p-2">
      <div class="text-dark-blue w-full p-4 mt-4">
        <h1 class="text-[18px]">
          Comments ({{ commentsCount }}) <i class="ml-2 fas fa-comments"></i>
        </h1>
      </div>
      <div v-if="commentsCount > 0" class="bg-white shadow-md rounded-lg p-8">
        <div v-if="userIsStudent()" class="mb-8">
          <h1 class="h3 text-dark-blue font-semibold">Add Comment</h1>
          <form @submit.prevent="submit">
            <textarea
              v-model="form.body"
              class="border-1 border-blue-200 w-full rounded-md"
            ></textarea>
            <button type="submit" class="btn-yellow rounded-full float-right">
              Post <i class="fas fa-paper-plane"></i>
            </button>
          </form>
        </div>
        <CommentCard
          v-for="comment in comments"
          :key="comment.id"
          :comment="comment"
        />
      </div>
    </div>
  </DashboardLayout>
</template>

<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue"
import CommentCard from "@/Components/Jobs/CommentCard.vue"
import { useForm } from "@inertiajs/inertia-vue3"
import { Link } from "@inertiajs/inertia-vue3"
import useDateFormat from "@/composables/useDateFormat"
import useUser from "@/composables/useUser"
import { toRefs } from "vue"
export default {
  components: {
    DashboardLayout,
    CommentCard,
    Link
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
    const formatDate = useDateFormat()
    const { userIsStudent } = useUser()
    const form = useForm({
      body: " ",
      job_id: job.value.id
    })

    function submit() {
      form.post(route("comments.store"), {
        onSuccess: () => form.reset("body")
      })
    }

    return { submit, form, formatDate, userIsStudent }
  }
}
</script>

<style></style>
