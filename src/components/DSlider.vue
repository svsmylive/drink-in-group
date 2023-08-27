<script setup lang="ts">
interface Props {
  images: Array<string>,
}

const props = defineProps<Props>();
</script>

<template>
<swiper-container
  v-if="images.length > 0"
  class="d-slider"
  :autoplay="{ delay: 5000 }"
  :loop="true"
  :no-swiping="true"
  effect="fade"
  :crossFade="true"
>
    <swiper-slide
      v-for="image in images"
      class="d-slider__slide"
      :style="`background: linear-gradient(0deg, rgba(0, 0, 0, 0.40) 0%, rgba(0, 0, 0, 0.40) 100%), url('${image}'), lightgray -122.014px -359.319px / 112.553% 133.344% no-repeat;`"
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