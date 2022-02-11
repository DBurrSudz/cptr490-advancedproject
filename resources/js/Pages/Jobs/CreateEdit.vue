<template>
  <DashboardLayout
    title="Jobs"
    :heading="mode === 'create' ? 'Create a Job' : 'Edit Job'"
  >
    <FormLayout @submit="submit">
      <Input
        id="title"
        label="Title"
        v-model="form.title"
        placeholder="Title"
        :error="form.errors.title"
      />
      <Input
        id="paid"
        label="Paid"
        v-model="form.paid"
        :error="form.errors.paid"
        type="checkbox"
      />
      <Input
        id="rate"
        label="Pay Rate"
        v-model="form.rate"
        placeholder="Pay Rate"
        :error="form.errors.rate"
        :disabled="!form.paid"
      />
      <Input
        id="description"
        label="Description"
        v-model="form.description"
        :error="form.errors.description"
        type="textarea"
      />
      <button type="submit" class="btn-dark-blue w-full mt-2">
        {{ mode === "create" ? "Create" : "Save" }}
        <i
          :class="{
            'fas fa-plus': mode === 'create',
            'fas fa-edit': mode === 'edit'
          }"
        ></i>
      </button>
    </FormLayout>
  </DashboardLayout>
</template>

<script>
import { Link, useForm } from "@inertiajs/inertia-vue3"
import useUser from "@/composables/useUser"
import DashboardLayout from "@/Layouts/DashboardLayout"
import FormLayout from "@/Layouts/FormLayout.vue"
import Input from "@/Components/Common/Input.vue"
import { toRefs } from "vue"

export default {
  components: {
    Link,
    DashboardLayout,
    Input,
    FormLayout
  },
  props: {
    job: {
      type: Object
    },
    mode: {
      type: String,
      required: true
    }
  },
  setup(props) {
    const { mode, job } = toRefs(props)
    const { userIsAdmin, userIsStudent } = useUser()
    let form
    if (mode.value === "create") {
      form = useForm({
        title: "",
        description: "",
        paid: false,
        rate: ""
      })
    }
    if (mode.value === "edit") {
      form = useForm({
        title: job.value?.title,
        description: job.value?.description,
        paid: job.value?.paid,
        rate: job.value?.rate
      })
    }

    function submit() {
      if (mode.value === "create") {
        form.post(route("jobs.store"))
      }
      if (mode.value === "edit") {
        form.put(route("jobs.update", job.value.id))
      }
    }
    return { form, userIsAdmin, userIsStudent, mode, submit }
  }
}
</script>

<style></style>
