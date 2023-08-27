<script setup lang="ts">
</script>

<template>
  <div class="d-banner-logo">
    <NuxtLink to="/">
      <DIcon icon="drinkInGroupLogo" :filled="false" />
    </NuxtLink>
  </div>
</template>

<style lang="scss">
.d-banner-logo {
  position: absolute;
  top: 0;
  text-align: center;

  color: $color-white;
  width: 100%;
  z-index: 100;

  .nuxt-icon svg{
    height: 100px !important;
    font-size: 200px;
  }
}
</style>