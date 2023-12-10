<script setup>
</script>

<template>
  <div><img src="https://mc.yandex.ru/watch/95293684" style="position:absolute; left:-9999px;" alt="" /></div>
  <NuxtLayout>
    <NuxtPage />
  </NuxtLayout>
</template>

<style>
body {
  margin: 0;
  padding: 0;
}

* {
  margin: 0;
  padding: 0;
}

.nuxt-link-exact-active {
  color: white;
}

.nuxt-link-active {
  color: white;
}

a, a:visited {
  color: white;
  text-decoration: none;
}

.page-enter-active,
.page-leave-active {
  transition: all 0.4s;
}
.page-enter-from,
.page-leave-to {
  background-color: black;
  filter: blur(1rem);
}
</style>
