<script setup lang="ts">
interface Props {
  active?: boolean;
  company?: any;
}

const props = withDefaults(defineProps<Props>(), {
  active: false,
});

const bannerMenuModifiers = computed(() => ({
  'd-banner-menu--active': props.active,
}));
</script>

<template>
  <div
    class="d-banner-menu"
    :class="bannerMenuModifiers"
  >
    <DText class="d-banner-menu-text" theme="Body-XS">{{ company?.type?.toLowerCase() }}</DText>
    <DText class="d-banner-menu-text d-banner-menu__name" theme="Title-XS">{{ company?.name }}</DText>
    <DText class="d-banner-menu-text" theme="Body-S">{{ `${company?.city}${company?.isActive ? '' : ', cкоро открытие'}`.trim() }}</DText>
  </div>
</template>

<style lang="scss">
.d-banner-menu {
  color: $color-white;
  opacity: 0.4;
  display: inline-flex;
  flex-direction: column;
  gap: 8px;
  padding: 16px 0;
  cursor: pointer;
  width: 100%;
  max-width: 550px;

  &:hover {
    opacity: 1;
  }
}

.d-banner-menu__name {
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>