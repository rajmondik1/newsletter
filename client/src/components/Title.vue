<template>
  <div class="container">
    <h1 class="title">
      {{ title }}
    </h1>
    <h2 class="subtitle">
      {{ subtitle }}
    </h2>
  </div>
</template>

<script>
export default {
  name: "Title",
  props: {
    title: String,
    subtitle: String
  }
}
</script>

<style scoped>

</style>