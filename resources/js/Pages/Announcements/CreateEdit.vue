<template>
  <DashboardLayout
    title="Announcements"
    :heading="mode === 'create' ? 'Create announcement' : 'Edit announcement'"
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
        type="select"
        id="category"
        label="Category"
        v-model="form.category"
        :error="form.errors.category"
      >
        <option selected disabled>Category</option>
        <option
          v-for="category in categories"
          :key="category"
          :value="category"
        >
          {{ category }}
        </option>
      </Input>

      <Input
        label="Description"
        id="description"
        type="textarea"
        placeholder="Description of announcement..."
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
          images_upload_url: route('announcements.upload'),
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
    DashboardLayout,
    FormLayout,
    Input,
    Editor
  },
  props: {
    announcement: {
      type: Object
    },
    mode: {
      type: String,
      required: true
    },
    categories: {
      type: Array,
      required: true
    }
  },
  setup(props) {
    const { mode, announcement } = toRefs(props)
    const tinyKEY = process.env.MIX_VUE_APP_TINY_MCE_KEY
    let form
    if (mode.value === "create") {
      form = useForm({
        title: "",
        description: "",
        category: ""
      })
    }
    if (mode.value === "edit") {
      form = useForm({
        title: announcement.value?.title,
        description: announcement.value?.description,
        category: announcement.value?.category
      })
    }

    function submit() {
      if (mode.value === "create") {
        form.post(route("announcements.store"))
      }
      if (mode.value === "edit") {
        form.put(route("announcements.update", announcement.value.id))
      }
    }
    return { form, mode, submit, tinyKEY }
  }
}
</script>
