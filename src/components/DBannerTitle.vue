<script setup lang="ts">
interface Props {
  company: any;
}

defineProps<Props>();
</script>

<template>
  <div class="d-banner-title">
    <DText theme="Body-L-Regular">{{ company?.type }}</DText>
    <DText theme="Title-L-Regular" class="d-banner-title__name">{{ company?.name }}</DText>
    <NuxtLink v-if="company?.isActive" :to="company?.seoUrl">
      <DButton>Перейти</DButton>
    </NuxtLink>
    <DText v-else theme="Body-L-Regular">Скоро открытие</DText>
  </div>
</template>

<style lang="scss">
.d-banner-title {
  position: absolute;
  left: 50%;
  top: 40%;
  transform: translate(-50%, -50%);
  text-align: center;
  width: 100%;
  z-index: 111;
  color: $color-white;
}

.d-banner-title__name {
  margin: 24px 0 30px;
}
</style>