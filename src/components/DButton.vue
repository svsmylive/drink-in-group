<script setup lang="ts">
interface Props {
  theme?: 'light' | 'dark';
}

const props = withDefaults(defineProps<Props>(), {
  theme: 'light',
});

const icon = computed(() => props.theme == 'light' ? 'button' : 'buttonDark')

const buttonIconSize = computed(() => `d-button__icon-${useLayoutSize().toLowerCase()}`);
const buttonIconModifiers = computed(() => [
  buttonIconSize.value,
]);
</script>

<template>
  <button
    type="button"
    class="d-button"
  >
    <DIcon
      :icon="icon"
      class="d-button__icon"
      :class="buttonIconModifiers"
      filled
    />
    <DText theme="Button-Primary">
      <slot />
    </DText>
  </button>
</template>

<style lang="scss">
.d-button {
  display: inline-flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
  min-height: 80px;
  background-color: $color-transparent;
  border: 1px solid $color-transparent;

  &:hover {
    cursor: pointer;

    .d-button__icon {
      color: rgba(186, 186, 193, 0.50);
    }
  }
}

.d-button__icon {
  color: $color-transparent;

  &.d-button__icon-xs {
    font-size: 48px;
  }

  &.d-button__icon-s {
    font-size: 60px;
  }

  &.d-button__icon-m,
  &.d-button__icon-l {
    font-size: 78px;
  }
}
</style>