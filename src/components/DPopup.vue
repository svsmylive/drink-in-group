<script setup lang="ts">
interface Props {
  logo?: string;
}

defineProps<Props>();

interface Emits {
  (eventName: 'close'): void;
};

const emits = defineEmits<Emits>();
</script>

<template>
  <div class="d-popup">
    <div class="d-popup__header">
      <img v-if="logo" class="d-popup__logo" :src="logo" @click="emits('close')" />
      <DIcon
        style="margin-left: auto;"
        :style="{ fontSize: useLayoutSize() == 'XS' ? '20px' : '40px', }"
        icon="close"
        @click="emits('close')"
        clickable
      />
    </div>
    <slot />
  </div>
</template>

<style lang="scss">
.d-popup {
  position: fixed;
  top: 0;
  text-align: center;
  z-index: 1000;
  background-color: $color-white;
  width: 100%;
  height: 100%;
  overflow-y: auto;
}

.d-popup {
  & .d-text {
    color: #363A45 !important;
    text-wrap: wrap;
  }
}

.d-popup__logo {
  max-width: 200px;
  max-height: 100px;
  object-position: center;
  object-fit: contain;
  cursor: pointer;
}

.d-popup__header {
  display: flex;
  padding: 40px;
}
</style>