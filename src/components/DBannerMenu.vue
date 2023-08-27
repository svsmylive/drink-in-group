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
    <DText class="d-banner-menu-text" theme="Body-M">{{ company?.city }}</DText>
    <div class="d-banner-menu__delimiters">
      <hr class="d-banner-menu__pre-delimiter">
      <hr class="d-banner-menu__delimiter">
    </div>
    <DText class="d-banner-menu-text" theme="Body-XS">{{ company?.type }}</DText>
    <DText class="d-banner-menu-text" theme="Title-XS">{{ company?.name }}</DText>
    <DText class="d-banner-menu-text" theme="Body-XS">{{ company?.isActive ? company?.address : 'Скоро открытие' }}</DText>
  </div>
</template>

<style lang="scss">
.d-banner-menu {
  color: $color-white;
  opacity: 0.4;
  display: inline-flex;
  flex-direction: column;
  gap: 8px;
  padding-right: -1px;
  cursor: pointer;

  &.d-banner-menu--active {
    opacity: 1;

    .d-banner-menu__pre-delimiter {
      opacity: 0.4;
    }
  }
}

.d-banner-menu-text {
  padding-left: 60px;
  padding-right: 30px;
}

.d-banner-menu__delimiters {
  display: flex;
  align-items: flex-end;
}

.d-banner-menu__pre-delimiter {
  opacity: 1;
  width: 60px;
  border: 1px solid $color-white;
}

.d-banner-menu__delimiter {
  width: 100%;
  border: 1px solid $color-white;
}
</style>