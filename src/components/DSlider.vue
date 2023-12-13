<script setup lang="ts">
import { register } from 'swiper/element/bundle';
register();

interface Props {
  images: Array<string>,
}

defineProps<Props>();

const swiperRef = ref();
</script>

<template>
<swiper-container
  v-if="images.length > 0"
  ref="swiperRef"
  class="d-slider"
  :autoplay="{ delay: 2500 }"
  :observeSlideChildren="true"
  :no-swiping="true"
  effect="fade"
  :crossFade="true"
>
    <swiper-slide
      v-for="image in images"
      class="d-slider__slide"
      :style="`background: linear-gradient(0deg, rgba(0, 0, 0, 0.50) 0%, rgba(0, 0, 0, 0.50) 100%), url(${image})`"
    ></swiper-slide>
</swiper-container>
</template>

<style lang="scss">
.d-slider {
  height: 100%;
  width: 100%;
  overflow: hidden;
  position: absolute;
}

.d-slider__slide {
  height: 100%;
  width: 100%;
  background-repeat: no-repeat !important;
  background-size: cover !important;
  background-position: center !important;
}
</style>