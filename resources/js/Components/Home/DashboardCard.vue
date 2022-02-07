<template>
  <div
    class="flex justify-between items-center px-8 h-[120px] bg-white rounded-lg"
  >
    <div class="ml-2">
      <p class="text-[35px] text-white font-semibold">{{ count }}</p>
      <p class="text-white">{{ label }}</p>
    </div>
    <div class="mr-4"><i class="text-[50px]" :class="icon"></i></div>
  </div>
</template>

<script>
export default {
  props: {
    count: {
      type: Number,
      required: true
    },
    label: {
      type: String,
      required: true
    },
    icon: {
      type: String,
      required: true
    }
  }
}
</script>
