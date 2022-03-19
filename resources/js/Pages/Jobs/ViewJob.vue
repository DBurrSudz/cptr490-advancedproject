<template>
  <DashboardLayout :title="job.title" heading="Job">
    <div class="shadow-md bg-white w-full">
      <div class="w-full h-[10px] flex flex-row">
        <div class="h-full w-10/12 bg-dark-blue"></div>
        <div class="h-full w-2/12 bg-yellow"></div>
      </div>
      <div class="p-4 h-[700px]">
        <div class="w-full flex justify-between">
          <div class="w-full h-[100px] p-8 mb-3">
            <h1 class="h3 text-dark-blue font-semibold">{{ job.title }}</h1>
            <span><i class="text-gray-400 fas fa-clock mr-2"></i></span>
            <span
              class="italic text-gray-400 text-[12px] mr-2"
              v-if="job.approved"
              >Posted: {{ formatDate(job.date_posted) }}</span
            >
            <span class="italic text-gray-400 text-[12px]"
              >Last updated: {{ formatDate(job.updated_at) }}</span
            >
          </div>
          <div class="flex justify-center items-center">
            <h1
              class="h4 font-medium"
              v-if="job.closed && user.id !== $page.props.auth.user.id"
            >
              Student has stopped accepting applicants.
            </h1>
            <button
              v-if="
                job.request &&
                userIsStudent() &&
                user.id !== $page.props.auth.user.id &&
                !job.closed
              "
              @click="apply"
              :disabled="applied"
              class="bg-dark-blue text-white rounded-lg shadow-lg capitalize w-[150px] h-[50px]"
              :class="{ 'bg-gray-300': applied }"
            >
              {{ applied ? "Submitted" : "Apply!" }}
            </button>
            <button
              v-if="
                job.request &&
                userIsStudent() &&
                user.id === $page.props.auth.user.id
              "
              @click="$inertia.put(route('jobs.toggle_closed', job.id))"
              class="bg-dark-blue text-white rounded-lg shadow-lg capitalize w-[150px] h-[50px]"
              :class="{ 'bg-gray-300': applied }"
            >
              {{ job.closed ? "Open" : "Close" }}
            </button>
          </div>
        </div>
        <div class="w-full h-[550px] flex flex-row">
          <div class="h-full w-2/12 overflow-auto p-4">
            <div class="text-center p-2 mb-8 shadow-md rounded-md">
              <h1 class="h4 font-medium text-dark-blue">
                <i class="text-faint-blue fas fa-clipboard mr-2"></i>Type
              </h1>
              <p
                class="text-white text-[14px] rounded-lg p-2"
                :class="{
                  'bg-indigo-700': !job.request,
                  'bg-rose-600': job.request
                }"
              >
                {{ job.request ? "Request" : "Advertisement" }}
              </p>
            </div>
            <div class="text-center p-2 mb-8 shadow-md rounded-md">
              <h1 class="h4 font-medium text-dark-blue">
                <i class="text-faint-blue fas fa-user mr-2"></i>Student
              </h1>
              <p class="text-[14px]">
                {{ user.first_name }} {{ user.last_name }}
              </p>
            </div>
            <div class="text-center p-2 mb-8 shadow-md rounded-md">
              <h1 class="h4 font-medium text-dark-blue">
                <i class="text-rose-700 fas fa-credit-card mr-2"></i>Paid
              </h1>
              <p class="text-dark-blue text-[14px]">
                {{ job.paid ? "Yes" : "No" }}
              </p>
            </div>
            <div class="text-center p-2 shadow-md rounded-md">
              <h1 class="h4 font-medium text-dark-blue">
                <i class="text-rose-700 fas fa-percentage mr-2"></i>Rate
              </h1>
              <p class="text-dark-blue text-[14px]">
                {{ job.paid ? job.rate : "N/A" }}
              </p>
            </div>
          </div>
          <div class="h-full w-10/12">
            <div class="w-full p-4 border-b-2">
              <h1 class="h3 text-dark-blue font-semibold">Details</h1>
            </div>
            <div
              v-html="job.description"
              class="p-4 w-full overflow-auto h-[500px]"
            ></div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="!job.request" class="p-2">
      <div class="text-dark-blue w-full p-4 mt-4">
        <h1 class="text-[18px]">
          Comments ({{ commentsCount }}) <i class="ml-2 fas fa-comments"></i>
        </h1>
      </div>
      <div class="bg-white shadow-md rounded-lg p-8">
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
import { useForm, Link, usePage } from "@inertiajs/inertia-vue3"
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
      type: Array
    },
    user: {
      required: true,
      type: Object
    },
    commentsCount: {
      type: Number
    },
    applied: {
      type: Boolean
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

    const applyForm = useForm({
      user_id: usePage().props.value.auth.user.id,
      job_id: job.value.id
    })

    function submit() {
      form.post(route("comments.store"), {
        onSuccess: () => form.reset("body")
      })
    }

    function apply() {
      applyForm.post(route("bookings.store"))
    }

    return { submit, form, formatDate, userIsStudent, apply }
  }
}
</script>

<style></style>
