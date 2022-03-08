<template>
  <DashboardLayout title="Profile" heading="Profile">
    <div class="w-full flex flex-row justify-between">
      <div
        class="bg-white rounded-md shadow-lg h-[350px] w-3/12 p-4 flex flex-col mr-8"
      >
        <div class="p-4 flex flex-col justify-center items-center">
          <i class="fas fa-user-alt text-gray-400 text-[100px]"></i>
          <h1 class="h3 font-medium mt-2 text-dark-blue">
            {{ user.first_name }} {{ user.last_name }}
          </h1>
          <h1 class="h3 font-medium mt-2 text-gray-300">
            {{ userIsStudent() ? "Jobs" : "Announcements" }}
          </h1>
          <h1 class="h3 font-normal text-gray-300">
            {{ userIsStudent() ? jobs : announcements }}
          </h1>
        </div>
      </div>
      <div class="w-9/12">
        <FormLayout @submit="submit">
          <h1 class="h3 font-semibold">Edit Profile</h1>
          <Input
            id="first_name"
            label="First Name"
            v-model="form.first_name"
            placeholder="First Name"
            :error="form.errors.first_name"
          />
          <Input
            id="last_name"
            label="Last Name"
            v-model="form.last_name"
            :error="form.errors.last_name"
            placeholder="Last Name"
          />
          <Input
            v-if="userIsAdmin()"
            type="select"
            id="title"
            label="Title"
            v-model="form.title"
            :error="form.errors.title"
          >
            <option selected disabled>Title</option>
            <option v-for="title in titles" :key="title" :value="title">
              {{ title }}
            </option>
          </Input>

          <Input
            v-if="userIsAdmin()"
            id="position"
            label="Position"
            v-model="form.position"
            :error="form.errors.position"
            placeholder="Position"
          />

          <Input
            v-if="userIsStudent()"
            id="dob"
            type="date"
            label="Date of Birth"
            v-model="form.dob"
            :error="form.errors.dob"
            placeholder="Date of Birth"
          />
          <Input
            v-if="userIsStudent()"
            id="address"
            type="textarea"
            label="Address"
            v-model="form.address"
            :error="form.errors.address"
            placeholder="Address"
          />
          <Input
            v-if="userIsStudent()"
            id="description"
            type="textarea"
            label="About me"
            v-model="form.description"
            :error="form.errors.description"
            placeholder="Description"
          />
          <button type="submit" class="btn-dark-blue w-full mt-2">
            Save changes
            <i class="ml-2 fas fa-edit"></i>
          </button>
        </FormLayout>
      </div>
    </div>
  </DashboardLayout>
</template>

<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue"
import Input from "@/Components/Common/Input.vue"
import useUser from "@/composables/useUser"
import FormLayout from "@/Layouts/FormLayout.vue"
import useDateFormat from "@/composables/useDateFormat"

import { usePage, useForm } from "@inertiajs/inertia-vue3"
export default {
  props: {
    jobs: {
      type: Number
    },
    announcements: {
      type: Number
    },
    titles: {
      type: Array
    }
  },
  components: {
    DashboardLayout,
    FormLayout,
    Input
  },
  setup() {
    const user = usePage().props.value?.auth?.user
    const { userIsAdmin, userIsStudent } = useUser()
    const formatDate = useDateFormat()
    const form = useForm({
      first_name: user?.first_name,
      last_name: user?.last_name,
      email: user?.email,
      dob: user?.dob,
      description: user?.description,
      address: user?.address,
      title: user?.title,
      position: user?.position
    })

    function submit() {
      if (userIsStudent()) form.put(route("student.profile.update", user.id))
      else form.put(route("admin.profile.update", user.id))
    }

    return {
      user,
      formatDate,
      form,
      userIsStudent,
      userIsAdmin,
      submit
    }
  }
}
</script>
