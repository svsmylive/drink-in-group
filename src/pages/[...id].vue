<script setup lang="ts">
import { useScrollLock } from '@vueuse/core';
import { usePointerSwipe } from '@vueuse/core';

const target = ref<HTMLElement | null>(null)
const container = ref<HTMLElement | null>(null)

const containerWidth = computed(() => container.value?.offsetWidth)

const { distanceX } = usePointerSwipe(target, {
  onSwipeEnd() {
    if (!containerWidth.value) {
      return;
    }

    if (Math.abs(distanceX.value) > containerWidth.value / 10) {
      if (distanceX.value > 0) goRight();
      else goLeft();
    }
  },
})

const { companies } = useCompanies();

const router = useRouter()
const route = useRoute();
const id = Array.isArray(route.params.id) ? route.params.id.join('/') : route.params.id;

const currentCompanyIndex = computed(() => companies.value?.findIndex((company: any) => company.seoUrl === id || company.name === id))
const currentCompany = computed(() => companies.value?.[currentCompanyIndex.value]);

const isActive = computed(() => currentCompany.value?.isActive);
const isMobile = computed(() => useLayoutSize() == 'XS' || useLayoutSize() == 'S');
const allowLeft = computed(() => currentCompanyIndex.value > 0);
const allowRight = computed(() => currentCompanyIndex.value < companies.value?.length - 1);

function goLeft() {
  if (allowLeft.value) {
    const route = companies.value?.[currentCompanyIndex.value - 1]?.seoUrl;
    router.push(`/${route}`);
  }
}

function goRight() {
  if (allowRight.value) {
    const route = companies.value?.[currentCompanyIndex.value + 1]?.seoUrl;
    router.push(`/${route}`);
  }
}

const timeOfWork = computed(() => {
  const [header, ...info] = currentCompany.value?.timeOfWork?.split(',');
  if (info.length == 0) {
    return [header];
  }

  return [
    `${header},`, info?.join(','),
  ]

});
const menuCompanies = computed(() => {
  return companies.value?.filter((company: any) => company.seoUrl != currentCompany.value.seoUrl) ?? [];
});

const currentBackground = ref();

const backgroundImage = computed(() => {
  const image = currentBackground.value ?? currentCompany.value.slider?.[0];

  if (image != undefined) {
    return `linear-gradient(0deg, rgba(0, 0, 0, 0.50) 0%, rgba(0, 0, 0, 0.50) 100%), url(${image})`;
  }
});

async function updateBackground(image?: any) {
  if (image == undefined || currentBackground.value == image) {
    return;
  }

  const img = new Image();
  img.src = image;
  await img.decode();

  currentBackground.value = image;
}

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

const containerPadding =  computed(() => {
  switch(useLayoutSize()) {
    case 'XS':
      return '90px 20px 10px';
    case 'S':
      return '110px 30px 10px';
    case 'L':
    case 'M':
      return '160px 40px 10px';
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
    case 'S':
      return '20px';
    case 'L':
    case 'M':
      return '30px';
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

const textAlign = computed(() => {
  if (containerDirection.value == 'column') {
    return 'center';
  }

  return 'left';
})
</script>

<template>
<div
  class="id-page"
  :style="{
    backgroundImage: backgroundImage,
  }"
  ref="container"
>
<Head>
  <Title>{{ currentCompany?.seoTitle ?? 'Сеть ресторанов DRINK IN GROUP' }}</Title>
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
<ClientOnly>
  <div class="id-page__content" ref="target">
    <div v-if="!isMobile" class="id-page__menu">
      <div class="id-page__logo">
        <NuxtLink to="/">
          <DIcon icon="drinkInGroupLogo" :filled="false" />
        </NuxtLink>
      </div>
      <div
        v-for="company in menuCompanies"
        :key="company.id"
        class="index-page__menu-item"
      >
        <NuxtLink :to="`/${company?.seoUrl}`">
          <DBannerMenu
            :company="company"
          />
        </NuxtLink>
      </div>
    </div>
    <div class="id-page__company-card">
      <div class="d-company-wrapper">
        <div v-if="isActive" class="d-submenu">
          <div v-if="isMobile" class="id-page__logo_mobile">
            <NuxtLink to="/">
              <DIcon icon="drinkInGroupLogo" :filled="false" />
            </NuxtLink>
          </div>
          <DText class="d-banner-menu-text" theme="Title-XS">{{ currentCompany?.name }}</DText>
          <hr class="d-company-wrappe__hr" />
          <DText
            v-for="(section, index) in currentCompany?.sections"
            :key="index"
            theme="Title-M-Medium"
            clickable
            :style="{ marginBottom: containerGap }"
            @mouseover="updateBackground(section.background)"
            @click="action(section)"
          >
            {{ getSectionTitle(section.type) }}
          </DText>
        </div>
        <div v-else class="d-submenu">
          <div v-if="isMobile" class="id-page__logo_mobile">
            <NuxtLink to="/">
              <DIcon icon="drinkInGroupLogo" :filled="false" />
            </NuxtLink>
          </div>
          <DText class="d-banner-menu-text" theme="Title-XS">{{ currentCompany?.name }}</DText>
          <hr class="d-company-wrappe__hr" />
          <DText theme="Title-M-Medium" style="text-align: center;">Скоро открытие</DText>
        </div>
        <div v-if="isMobile" class="d-slider-controls">
          <DIcon
            icon="arrowLeft"
            filled
            :clickable="allowLeft"
            @click="goLeft"
          />
          <div class="d-dots">
            <div v-for="company in companies" class="d-dot" :class="company == currentCompany ? 'd-dot_active' : ''">
            </div>
          </div>
          <DIcon
            icon="arrowRight"
            filled
            :clickable="allowRight"
            @click="goRight"
          />
        </div>
        <div class="d-subcontent">
          <div class="d-subcontent-item" :style="{ textAlign: isMobile ? 'center' : 'left'}">
            <DText theme="Body-S">наш адрес</DText>
            <DText v-if="isMobile" theme="Body-L-Medium">{{ currentCompany?.fullAddress }}</DText>
            <template v-else>
              <DText theme="Body-L-Medium">{{ currentCompany?.city }}</DText>
              <DText theme="Body-L-Medium">{{ currentCompany?.address }}</DText>
            </template>
          </div>
          <div class="d-subcontent-item" :style="{ textAlign: isMobile ? 'center' : 'left'}">
            <DText theme="Body-S">режим работы</DText>
            <template v-if="isMobile">
              <DText theme="Body-L-Medium">{{ currentCompany?.timeOfWork }}</DText>
            </template>
            <template v-else>
              <DText v-for="(time, index) in timeOfWork" :key="index" theme="Body-L-Medium">{{ time }}</DText>
            </template>
          </div>
          <div class="d-subcontent-item" :style="{ textAlign: isMobile ? 'center' : 'left'}">
            <DText theme="Body-S">телефон</DText>
            <a :href="`tel:${currentCompany?.phone}`"><DText theme="Body-L-Medium">{{ currentCompany?.phone }}</DText></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</ClientOnly>
</div>
</template>

<style lang="scss">
.id-page {
  min-height: 100vh;
  display: flex;
  align-items: flex-start;
  justify-content: center;
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
}

.id-page__content {
  width: 100%;
  display: flex;
  align-items: flex-start;
  justify-content: flex-start;
  gap: 60px;
  padding: 40px;
}

.id-page__menu {
  flex: 0 1 700px;
  display: flex;
  flex-direction: column;
  max-height: 100%;
  overflow-y: auto;
}

.id-page__menu-item:not(:last-child) {
  border-bottom: 1px solid $color-white;
}

.id-page__logo {
  color: $color-white;
  margin-bottom: 40px;

  & .nuxt-icon svg{
    height: 100px !important;
    font-size: 250px;
    margin: 0;
  }
}

.id-page__logo_mobile {
  color: $color-white;
  margin-bottom: 10px;

  & .nuxt-icon svg{
    height: 50px !important;
    font-size: 150px;
    margin: 0;
  }
}

.id-page__company-card {
  width: 100%;
  max-width: 100wh;
  overflow: hidden;
}

.d-border {
  border-radius: 100px;
  border: 1px solid rgba(0, 0, 0, 0.50);
  padding: 8px 20px;
}

.d-company {
  display: flex;
  padding: v-bind(containerPadding);
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
  display: flex;
  flex-direction: column;
  flex: 1 1 700px;
}

.d-submenu {
  display: flex;
  flex-direction: column;
  gap: v-bind(containerGap);
  justify-content: flex-start;
  align-items: center;
  padding: 0 10px 0 10px;
}

.d-company-wrappe__hr {
  border: none;
  border-left: 2px solid rgba(186, 186, 193, 0.4);
  height: 60px;
  width: 2px;
}

.d-subcontent {
  border-top: 2px solid rgba(255, 255, 255, 0.4);
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  gap: 32px;
  justify-content: space-evenly;
  padding: 70px 10px 10px 10px;
  margin-top: 30px;
  padding-left: v-bind(subcontentPadding);
}

.d-subcontent-item {
  display: flex;
  flex-direction: column;
  padding-bottom: 32px;
}

.d-slider-controls {
  width: 100%;
  display: flex;
  justify-content: space-between;
  margin-top: 30px;
  align-items: center;
}

.d-dots {
  display: flex;
  justify-content: space-between;
  gap: 7px;
  align-items: center;
}

.d-dot {
  width: 4px;
  height: 4px;
  border-radius: 100px;
  background-color: white;
  opacity: 0.6;
}

.d-dot_active {
  width: 30px;
}
</style>
