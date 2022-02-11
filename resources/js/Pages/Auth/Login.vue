<template>
  <AuthLayout @submit="submit" pageTitle="Sign In" formTitle="Sign In">
    <Input
      type="email"
      id="email"
      label="Email Address"
      v-model="form.email"
      placeholder="Email"
      :error="form.errors.email"
      dark-background
    />
    <Input
      v-if="route().current('admin.login.create')"
      id="ncu_id"
      label="NCU ID"
      v-model="form.ncu_id"
      placeholder="NCU ID"
      :error="form.errors.ncu_id"
      dark-background
    />
    <Input
      type="password"
      id="password"
      label="Password"
      v-model="form.password"
      placeholder="Password"
      :error="form.errors.password"
      dark-background
    />
    <button type="submit" class="btn-yellow w-full mt-2">
      Sign In <i class="fas fa-sign-in-alt"></i>
    </button>
    <p class="mt-4 text-sm">
      <span class="text-white">Don't have an account?</span>&nbsp;
      <Link class="text-green" :href="registerLink">Register Now!</Link>
    </p>
  </AuthLayout>
</template>

<script>
import Input from "@/Components/Common/Input.vue"
import AuthLayout from "@/Layouts/AuthLayout.vue"
import { Link } from "@inertiajs/inertia-vue3"

export default {
  components: {
    Link,
    Input,
    AuthLayout
  },
  data() {
    return {
      form: this.$inertia.form({
        email: "",
        password: "",
        ncu_id: ""
      })
    }
  },
  computed: {
    registerLink() {
      if (route().current("login")) return route("register")
      return route("admin.register.create")
    }
  },
  methods: {
    submit() {
      const route = this.route().current("login")
        ? "login"
        : "admin.login.store"
      this.form.post(this.route(route), {
        onFinish: () => {
          this.form.reset("password")
          this.form.reset("email")
        }
      })
    }
  }
}
</script>
