<script setup lang="ts">
interface Props {
  icon: 'arrow' | 'arrowRight' | 'arrowLeft' | 'button' | 'buttonDark' | 'close' | 'closeLight' | 'upload' | 'drinkInGroupLogo';
  filled?: boolean;
  clickable?: boolean;
}

withDefaults(defineProps<Props>(), {
  filled: false,
});
</script>

<template>
  <nuxt-icon :class="{ 'd-icon_clickable': clickable }" :name="icon" :filled="filled" />
</template>

<style lang="scss">
.d-icon_clickable {
  cursor: pointer;

  &:hover {
    opacity: 50%;
  }
}
</style>