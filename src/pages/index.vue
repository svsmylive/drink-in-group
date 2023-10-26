<script setup lang="ts">
import { register } from 'swiper/element/bundle';
register();

const route = useRoute();
const hashId = computed(() => route.hash.slice(1));

const activeIndex = ref(0);
const initialSlide = ref(0);

const slideRefs = useTemplateRefsList<HTMLElement>();

const lastSlide = computed(() => slideRefs.value?.[slideRefs.value?.length - 1]);
const firstSlide = computed(() => slideRefs.value?.[0]);

const isUseFirstSlideVisible = useElementVisibility(firstSlide);
const isUseLastSlideVisible = useElementVisibility(lastSlide);

const isFirstSlideVisible = computed(() => lastSlide.value == undefined ? true : isUseFirstSlideVisible.value);
const isLastSlideVisible = computed(() => firstSlide.value == undefined ? true : isUseLastSlideVisible.value);

function onSlideChange(index: any) {
  const realIndex = index.target?.swiper?.realIndex;
  activeIndex.value = Number.isNaN(realIndex) ? initialSlide.value : realIndex ?? initialSlide.value;
}

function getBottomPadding() {
  switch (useLayoutSize()) {
    case 'XS':
      return '10px';
    case 'S':
      return '20px';
    case 'M':
      return '30px';
    case 'L':
      return '40px';
  }
}

const swiperThumbsRef = ref();

function slideLeft() {
  swiperThumbsRef.value?.swiper?.slidePrev();
}

function slideRight() {
  swiperThumbsRef.value?.swiper?.slideNext();
}

const { companies } = useCompanies();

const isCompaniesExist = computed(() => companies.value.length > 0);

const { data } = await useFetch(formatApi('/institutions/main/page'));

watch(companies, () => {
  const index = companies.value.findIndex((item) => {
    const url = item.seoUrl.endsWith('/') ? item.seoUrl.slice(0, -1) : item.seoUrl;
    return url === hashId.value;
  });

  if (index != -1) {
    initialSlide.value = index;
    activeIndex.value = index;
  }
})

const seoTitle = computed(() => data.value?.data?.title ?? '');
const seoDescription = computed(() => data.value?.data?.description ?? '');
</script>

<template>
  <Head>
    <Title>{{ seoTitle }}</Title>
    <Meta name="description" :content="seoDescription" />
  </Head>

  <ClientOnly>
    <swiper-container
      v-if="isCompaniesExist"
      id="d-index-page__slider"
      class="d-index-page__slider"
      thumbs-swiper="#d-swiper-thumbs"
      :resistance="true"
      :resistanceRatio="0"
      :initialSlide="initialSlide"
      @slidechange.self="onSlideChange"
      slides-per-view="1"
    >
      <swiper-slide v-for="company in companies" :key="company.id" >
        <DBannerTitle :company="company" />
        <DSlider :images="company.slider" />
      </swiper-slide>
    </swiper-container>

    <DIcon
      v-if="!isFirstSlideVisible"
      icon="arrow"
      filled
      clickable
      class="d-index-page__slider-arrow d-index-page__slider-arrow_left"
      @click="slideLeft"
    />
    <swiper-container
      v-if="isCompaniesExist"
      ref="swiperThumbsRef"
      id="d-swiper-thumbs"
      slides-per-view="auto"
      :free-mode="true"
      :initialSlide="initialSlide"
      :mousewheel="{ enabled: true, sensitivity: 1 }"
      :style="{ paddingBottom: getBottomPadding() }"
      class="d-index-page__slider-thumbs"
    >
      <swiper-slide
        v-for="(company, index) in companies"
        :key="company.id"
        ref="slideRefs"
        class="d-swiper-slide"
      >
        <DBannerMenu
          :active="index === activeIndex"
          :company="company"
        />
      </swiper-slide>
    </swiper-container>
    <DIcon
      v-if="!isLastSlideVisible"
      icon="arrow"
      filled
      clickable
      class="d-index-page__slider-arrow d-index-page__slider-arrow_right"
      @click="slideRight"
    />
  </ClientOnly>
  <DBannerLogo />
</template>

<style scoped lang="scss">
.d-index-page {
  flex-grow: 1;
}
.d-index-page__slider {
  overflow: hidden;
  height: 100%;
  width: 100%;
  position: absolute;
}

.d-index-page__slider-thumbs {
  position: absolute;
  bottom: 0;
  display: flex;
  flex-wrap: nowrap;
  max-width: 100%;
  overflow: hidden;
  background: linear-gradient(0deg, #0A0A0A 0%, rgba(10, 10, 10, 0.00) 100%);
}
.d-swiper-slide {
  width: fit-content;
}

.d-index-page__slider-arrow {
  position: absolute;
  bottom: 20px;
  z-index: 1000;
  line-height: 50px;
  font-size: 50px;
  opacity: 0.6;
  padding: 10px;
}
.d-index-page__slider-arrow_right {
  right: 5px;
}
.d-index-page__slider-arrow_left {
  left: 5px;
  transform: rotate(180deg);
}
</style>