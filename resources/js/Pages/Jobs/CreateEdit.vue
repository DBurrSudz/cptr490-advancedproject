<template>
  <DashboardLayout
    title="Jobs"
    :heading="mode === 'create' ? 'Create job' : 'Edit job'"
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
        v-if="form.paid"
        id="rate"
        label="Pay Rate"
        v-model="form.rate"
        placeholder="Pay Rate"
        :error="form.errors.rate"
        :disabled="!form.paid"
      />
      <Input
        id="request"
        label="Request"
        v-model="form.request"
        :error="form.errors.request"
        type="checkbox"
      />
      <Input
        v-if="form.request"
        id="limit"
        label="Limit"
        v-model="form.limit"
        :error="form.errors.limit"
        type="number"
      />

      <Input
        label="Description"
        id="description"
        type="textarea"
        placeholder="Description of job..."
        v-model="form.description"
        :error="form.errors.description"
      />
      <!--
      <Editor
        :api-key="tinyKEY"
        v-model="form.description"
        :init="{
          menubar: false,
          width: 800,
          height: 400,
          plugins: ['lists link image paste emoticons'],
          toolbar: [
            'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | emoticons image | link unlink | fontselect fontsizeselect forecolor backcolor'
          ],
          placeholder: 'Description...',
          images_upload_url: route('jobs.upload'),
          file_picker_types: 'image',
          automatic_uploads: true
        }"
      />
      -->
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
import Editor from "@tinymce/tinymce-vue"
import { toRefs } from "vue"

export default {
  components: {
    Editor,
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
    const tinyKEY = process.env.MIX_VUE_APP_TINY_MCE_KEY

    let form
    if (mode.value === "create") {
      form = useForm({
        title: "",
        description: "",
        paid: false,
        rate: "",
        request: false,
        limit: 0
      })
    }
    if (mode.value === "edit") {
      form = useForm({
        title: job.value?.title,
        description: job.value?.description,
        paid: job.value?.paid,
        rate: job.value?.rate,
        request: job.value?.request,
        limit: job.value?.limit
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
    return { form, userIsAdmin, userIsStudent, mode, submit, tinyKEY }
  }
}
</script>
