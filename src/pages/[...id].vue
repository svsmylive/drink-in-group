<script setup lang="ts">
import { useImage, useScrollLock } from '@vueuse/core';
import { register } from 'swiper/element/bundle';
register();

const { companies } = useCompanies();

const route = useRoute();
const id = Array.isArray(route.params.id) ? route.params.id.join('/') : route.params.id;
const currentCompany = computed(() => companies.value.find((c) => c.seoUrl === id || c.name === id));

const currentSection = ref<'none' | 'about' | 'events' | 'sauna' | 'reserve'>('none');

function getAboutLabel() {
  switch(currentCompany.value?.type) {
    case 'Ресторан': return 'О ресторане';
    case 'Сауна': return 'О сауне';
    case 'Караоке': return 'О караоке';
    default: return 'О заведении';
  }
}

function getSectionTitle(type?: string) {
  switch (type) {
    case 'menu': return 'Меню';
    case 'about': return getAboutLabel();
    case 'events': return 'События';
    case 'reserve': return 'Забронировать';
    case 'sauna': return 'Услуги и цены';
    default: return 'Информация';
  }
}

function action(section?: any) {
  switch (section?.type) {
    case 'menu':
      downloadFile(section?.link, `${currentCompany.value?.name}`);
      break;
    case 'about':
      currentSection.value = 'about';
      break;
    case 'events':
      currentSection.value = 'events';
      break;
    case 'reserve':
      currentSection.value = 'reserve';
      break;
    case 'sauna':
      currentSection.value = 'sauna';
      break;
  }
}

const el = ref<HTMLElement>();
const isLocked = useScrollLock(el);

onMounted(() => {
  el.value = document.body;
})

watch(currentSection, () => {
  isLocked.value = currentSection.value != 'none';
})

const currentImage = ref();
const backgroundImage = computed(() => {
  const image = currentImage.value ?? currentCompany.value?.slider?.[0];
  return `linear-gradient(0deg, rgba(0, 0, 0, 0.50) 0%, rgba(0, 0, 0, 0.50) 100%), url(${image})`;
});

onMounted(() => {
  currentCompany.value?.sections?.forEach((section) => {
    const { isLoading } = useImage({ src: section.background })
  });
});

function updateCurrentImage(image?: string) {
  if (image == undefined) {
    return;
  }

  document.createElement('img').setAttribute('src', image);
  currentImage.value = image;
}

const containerPadding =  computed(() => {
  switch(useLayoutSize()) {
    case 'XS':
      return '80px 40px 40px 40px';
    case 'S':
      return '120px 50px 50px 50px';
    case 'L':
    case 'M':
      return '140px 100px 100px 120px';
  }
});

const subcontentPadding =  computed(() => {
  switch(useLayoutSize()) {
    case 'XS':
      return '0';
    case 'S':
      return '40px';
    case 'L':
    case 'M':
      return '120px';
  }
});

const containerGap =  computed(() => {
  switch(useLayoutSize()) {
    case 'XS':
      return '40px';
    case 'S':
      return '40px';
    case 'L':
      return '60px';
    case 'M':
      return '60px';
  }
});

const containerDirection = computed(() => {
  if (useLayoutSize() == 'XS' || useLayoutSize() == 'S') {
    return 'column';
  }

  return 'row';
});

const containerGrid = computed(() => {
  if (containerDirection.value == 'column') {
    return '1fr';
  }

  return '1fr 1fr';
});

const borderTop = computed(() => {
  if (containerDirection.value == 'column') {
    return '2px solid white';
  }

  return 'none';
});

const borderLeft = computed(() => {
  if (containerDirection.value == 'column') {
    return 'none';
  }

  return '2px solid white';
});

const textAlign = computed(() => {
  if (containerDirection.value == 'column') {
    return 'center';
  }

  return 'left';
})
</script>

<template>
  <Head>
    <Title>{{ currentCompany?.seoTitle ?? '' }}</Title>
    <Meta name="description" :content="currentCompany?.seoDescription ?? ''" />
  </Head>

  <DPopupReserve
    v-if="currentSection == 'reserve'"
    :company="currentCompany"
    @close="currentSection = 'none'"
  />

  <DPopupAbout
    v-if="currentSection == 'about'"
    :company="currentCompany"
    @close="currentSection = 'none'"
  />

  <DPopupEvents
    v-if="currentSection == 'events'"
    :company="currentCompany"
    @close="currentSection = 'none'"
  />

  <DPopupSauna
    v-if="currentSection == 'sauna'"
    :company="currentCompany"
    @close="currentSection = 'none'"
  />

  <DBannerLogo :subtitle="currentCompany?.name" />

  <div
    class="d-company"
    :style="{
      backgroundImage: backgroundImage,
      overflow: currentSection == 'none' ? 'auto' : 'hidden',
    }"
  >
    <div class="d-company-wrapper">
      <div class="d-submenu">
        <DText
          v-for="section in currentCompany?.sections"
          theme="Title-M-Medium"
          clickable
          @mouseover="updateCurrentImage(section.background)"
          @click="action(section)"
        >
          {{ getSectionTitle(section.type) }}
        </DText>
      </div>
      <div class="d-subcontent">
        <DText theme="Body-S">наш адрес</DText>
        <DText theme="Body-L-Medium" style="padding-bottom: 40px">{{ currentCompany?.fullAddress }}</DText>
        <DText theme="Body-S">режим работы</DText>
        <DText theme="Body-L-Medium" style="padding-bottom: 40px">{{ currentCompany?.timeOfWork }}</DText>
        <DText theme="Body-S">телефон</DText>
        <a :href="`tel:${currentCompany?.phone}`"><DText theme="Body-L-Medium">{{ currentCompany?.phone }}</DText></a>
      </div>
    </div>
  </div>
</template>

<style>
.d-border {
  border-radius: 100px;
  border: 1px solid rgba(0, 0, 0, 0.50);
  padding: 8px 20px;
}

.d-company {
  display: flex;
  padding: v-bind(containerPadding);
  padding-bottom: 5px;
  text-align: v-bind(textAlign);
  min-height: 100vh;
  align-items: flex-start;
  align-items: center;
  justify-content: center;
  box-sizing: border-box;
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
}

.d-company-wrapper {
  display: grid;
  grid-template-columns: v-bind(containerGrid);
}

.d-submenu {
  display: flex;
  flex-direction: column;
  gap: v-bind(containerGap);
  justify-content: flex-start;
  padding: 70px 10px;
}

.d-subcontent {
  border-top: v-bind(borderTop);
  border-left: v-bind(borderLeft);
  display: flex;
  flex-direction: column;
  gap: 10px;
  justify-content: center;
  padding: 70px 10px;
  padding-left: v-bind(subcontentPadding);
}
</style>
