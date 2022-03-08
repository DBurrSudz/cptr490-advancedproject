<template>
  <teleport to="body">
    <transition name="slide-up">
      <div
        class="py-4 px-6 rounded-lg bg-lime-500 fixed top-10 right-1/2 transform translate-x-1/2 text-white flex justify-between xl:bottom-8 xl:top-auto"
        v-if="show"
      >
        <span>
          {{ message }}
        </span>
      </div>
    </transition>
  </teleport>
</template>

<script>
export default {
  data() {
    return {
      show: false,
      message: null
    }
  },
  watch: {
    "$page.props.flash.success": {
      handler: "showFlash",
      deep: true
    }
  },
  methods: {
    showFlash() {
      const message = this.$page.props.flash.success
      if (message) {
        this.show = true
        this.message = message
        setTimeout(() => {
          this.show = false
          this.message = null
        }, 3000)
      }
    }
  }
}
</script>
