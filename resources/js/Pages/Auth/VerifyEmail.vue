<template>
  <div class="w-screen h-screen bg-gray flex justify-center items-center">
    <div class="bg-white shadow-md rounded-lg w-1/2 h-1/3 p-8">
      <div class="w-full text-center">
        <h1 class="h2 text-dark-blue">Jortal</h1>
      </div>
      <p class="text-dark-blue mt-4">
        A verification link has been sent to your email address. Please verify
        your email to proceed with using the application.
      </p>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    status: {
      required: true
    }
  }
}
</script>
