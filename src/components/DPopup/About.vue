<script setup lang="ts">
import { register } from 'swiper/element/bundle';
register();

interface Props {
  company: any;
}

const props = defineProps<Props>();

const showFullscreen = ref(false);
const section = computed(() => props.company.sections.find((section: any) => section?.type == 'about'));
const sliderHeight =  computed(() => {
  switch(useLayoutSize()) {
    case 'XS':
      return '260px';
    case 'S':
      return '420px';
    case 'L':
      return '540px';
    case 'M':
      return '710px';
  }
});

const swiperAboutRef = ref();
const swiperAboutThumbsRef = ref();

const activeIndex = ref(0);

function onSlideChange(index: any) {
  const realIndex = index.target?.swiper?.realIndex;
  activeIndex.value = Number.isNaN(realIndex) ? 0 : realIndex ?? 0;
}

function setSlide(index: number) {
  if (swiperAboutRef.value) {
    showFullscreen.value = true;
    swiperAboutRef.value.swiper?.slideTo?.(index);
  }
}
</script>

<template>
  <DPopup
    :logo="company?.logo"
  >
    <DPopup v-show="showFullscreen" style="background-color: #101111;">
      <DIcon
        class="d-popup-about__fullscreen_slider_close"
        :style="{ fontSize: useLayoutSize() == 'XS' ? '20px' : '40px', }"
        icon="closeLight"
        @click="showFullscreen = false"
        clickable
        :filled="true"
      />
      <swiper-container
        v-if="section?.images?.length > 0"
        class="d-popup-about__fullscreen_slider"
        :space-between="50"
        :slides-per-view="'auto'"
        ref="swiperAboutRef"
        :navigation="true"
        :pagination="{ dynamicBullets: true }"
        :mousewheel="{ enabled: true, sensitivity: 1 }"
      >
        <swiper-slide
          v-for="(image, index) in section.images"
          :key="image"
          class="d-popup-about__fullscreen_slide"
          :style="{ backgroundImage: `url(${image})` }"
          @click="setSlide(index)"
          ></swiper-slide>
        </swiper-container>
    </DPopup>
    <div class="d-popup-about">
      <DText theme="Title-M-Regular">{{ company?.type }} {{ company?.name }}</DText>
      <DText theme="Body-M" class="d-popup-about__text">{{ section?.headerText }}</DText>
      <swiper-container
        v-if="section?.images?.length > 0"
        ref="swiperAboutThumbsRef"
        class="d-popup-about__slider"
        :pagination="false"
        :space-between="5"
        :slides-per-view="'auto'"
        @slidechange.self="onSlideChange"
      >
          <swiper-slide
            v-for="(image, index) in section.images"
            :key="image"
            class="d-popup-about__slide"
            :style="{ backgroundImage: `url(${image})` }"
            @click="setSlide(index)"
            ></swiper-slide>
        </swiper-container>
      <DText theme="Body-M" class="d-popup-about__text">{{ section?.bodyText }}</DText>
      <DText theme="Body-L-Regular" class="d-popup-about__text">{{ section?.footerText }}</DText>
      <div class="d-popup-about__reserve">
        <DText theme="Body-S" class="d-popup-about__text">ЗАБРОНИРОВАТЬ СТОЛИК:</DText>
        <a :href="`tel:${company?.phone}`"><DText theme="Number">{{ company?.phone }}</DText></a>
      </div>
    </div>
  </DPopup>
</template>

<style lang="scss">
.d-popup-about {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 50px;
  padding-bottom: 40px;
}

.d-popup-about__text {
  width: 70%;
}

.d-popup-about__fullscreen_slider_close {
  z-index: 1500;
  position: absolute;
  right: 10px;
  top: 10px;
}

.d-popup-about__fullscreen_slider {
  --swiper-theme-color: white;
  --swiper-pagination-bullet-inactive-color: white;

  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  width: 100%;
  height: 100%;
  background-color: #101111;
}

.d-popup-about__fullscreen_slide {
  background-repeat: no-repeat !important;
  background-size: contain !important;
  background-position: center !important;
  max-height: 80vh;
  top: 50%;
  transform: translate(0, -50%);
}

.d-popup-about__slider {
  height: v-bind(sliderHeight);
  width: 100%
}

.d-popup-about__slide {
  border-radius: 10px;
  height: 100%;
  max-width: min(70%, 650px);
  background-repeat: no-repeat !important;
  background-size: cover !important;
  background-position: center !important;
}

d-popup-about__slide:hover {
  cursor: pointer;
}

.d-popup-about__reserve {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
}
</style>