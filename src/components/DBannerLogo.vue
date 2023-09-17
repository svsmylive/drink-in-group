<script setup lang="ts">
interface Props {
  subtitle?: string;
}

const props = defineProps<Props>();

const hasSubtitle = computed(() => props.subtitle != undefined && props.subtitle.length > 0);
</script>

<template>
  <div class="d-banner-logo" :class="{ 'd-banner-logo_small': hasSubtitle }">
    <NuxtLink to="/">
      <DIcon icon="drinkInGroupLogo" :filled="false" />
    </NuxtLink>
    <DText v-if="hasSubtitle" theme="Body-L-Medium">{{ subtitle }}</DText>
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

  display: flex;
  flex-direction: column;

  .nuxt-icon svg{
    height: 80px !important;
    font-size: 200px;
    margin: 0;
  }
}

.d-banner-logo_small {
  margin-bottom: 20px;

  .nuxt-icon svg{
    height: 80px !important;
    font-size: 150px;
    margin: 0;
  }
}
</style>