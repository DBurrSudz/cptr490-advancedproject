<template>
  <AuthLayout
    @submit="submit"
    maxWidth="580px"
    pageTitle="Register Now!"
    formTitle="Sign Up!"
  >
    <div class="grid grid-cols-2 gap-x-4">
      <!--First Name-->
      <Input
        id="first_name"
        label="First Name"
        v-model="form.first_name"
        placeholder="First Name"
        :error="form.errors.first_name"
        dark-background
      />

      <!--Last Name-->
      <Input
        id="last_name"
        label="Last Name"
        v-model="form.last_name"
        :error="form.errors.last_name"
        placeholder="Last Name"
        dark-background
      />

      <!--Title-->
      <Input
        v-if="route().current('admin.register.create')"
        type="select"
        id="title"
        label="Title"
        v-model="form.title"
        :error="form.errors.title"
        dark-background
      >
        <option selected disabled>Title</option>
        <option v-for="title in titles" :key="title" :value="title">
          {{ title }}
        </option>
      </Input>

      <!--Northern Caribbean University ID-->
      <Input
        id="ncu_id"
        label="NCU ID"
        v-model="form.ncu_id"
        placeholder="NCU ID"
        :error="form.errors.ncu_id"
        dark-background
      />

      <Input
        v-if="route().current('register')"
        id="dob"
        type="date"
        label="Date of Birth"
        v-model="form.dob"
        :error="form.errors.dob"
        placeholder="Date of Birth"
        dark-background
      />
    </div>
    <!--Position-->
    <Input
      v-if="route().current('admin.register.create')"
      id="position"
      label="Position"
      v-model="form.position"
      :error="form.errors.position"
      placeholder="Position"
      dark-background
    />

    <!--Email Address-->
    <Input
      type="email"
      id="email"
      label="Email Address"
      v-model="form.email"
      placeholder="Email"
      :error="form.errors.email"
      dark-background
    />
    <div class="grid grid-cols-2 gap-x-4">
      <!--Password-->
      <Input
        type="password"
        id="password"
        label="Password"
        v-model="form.password"
        :error="form.errors.password"
        placeholder="Password"
        dark-background
      />

      <!--Confirm Password-->
      <Input
        type="password"
        id="password_confirmation"
        label="Confirm Password"
        v-model="form.password_confirmation"
        :error="form.errors.password"
        placeholder="Confirm Password"
        dark-background
      />
    </div>
    <button type="submit" class="btn-yellow w-full mt-2">
      Sign Up <i class="fas fa-user-plus"></i>
    </button>
    <p class="mt-4 text-sm">
      <span class="text-white">Already have an account?</span>&nbsp;
      <Link class="text-green" :href="loginLink">Sign In!</Link>
    </p>
  </AuthLayout>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3"
import AuthLayout from "@/Layouts/AuthLayout.vue"
import Input from "@/Components/Common/Input.vue"

export default {
  props: {
    titles: {
      type: Array
    }
  },
  components: {
    AuthLayout,
    Input,
    Link
  },
  computed: {
    loginLink() {
      if (route().current("register")) return route("login")
      return route("admin.login.create")
    }
  },
  data() {
    return {
      form: this.$inertia.form({
        first_name: "",
        last_name: "",
        ncu_id: "",
        title: "",
        position: "",
        dob: "",
        email: "",
        password: "",
        password_confirmation: ""
      })
    }
  },

  methods: {
    submit() {
      const route = this.route().current("register")
        ? "register"
        : "admin.register.store"
      this.form.post(this.route(route), {
        onFinish: () => this.form.reset("password", "password_confirmation")
      })
    }
  }
}
</script>
