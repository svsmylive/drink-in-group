<script setup lang="ts">
import { register } from 'swiper/element/bundle';
register();

import { useScrollLock } from '@vueuse/core';

const { companies } = useCompanies();

const router = useRouter()
const route = useRoute();
const id = ref(Array.isArray(route.params.id) ? route.params.id.join('/') : route.params.id);

const currentCompanyIndex = computed(() => companies.value?.findIndex((company: any) => company.seoUrl === id.value || company.name === id.value))
const currentCompany = computed(() => companies.value?.[currentCompanyIndex.value]);

const isActive = computed(() => currentCompany.value?.isActive);
const isMobile = computed(() => useLayoutSize() == 'XS' || useLayoutSize() == 'S');

function goLeft() {
  const index = currentCompanyIndex.value == 0 ? companies.value.length - 1 : currentCompanyIndex.value - 1;
  const route = companies.value?.[index]?.seoUrl;
  router.push(`/${route}`);
}

function goRight() {
  const index = currentCompanyIndex.value >= companies.value.length - 1 ? 0 : currentCompanyIndex.value + 1;
  const route = companies.value?.[index]?.seoUrl;
  router.push(`/${route}`);
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
  const image = currentBackground.value;

  if (image != undefined) {
    return `linear-gradient(0deg, rgba(0, 0, 0, 0.50) 0%, rgba(0, 0, 0, 0.50) 100%), url(${image})`;
  }
});

async function updateBackground(image?: any) {
  if (image === undefined || currentBackground.value === image) {
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
    case 'Бильярдная': return 'О бильярдной';
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
    case 'catalog':
      currentSection.value = 'catalog';
      break;
    case 'menu':
      currentSection.value = 'menu';
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
  isLocked.value = currentSection.value !== 'none';
})

watch(currentCompany, () => {
  if (currentCompany.value != undefined) {
    updateBackground(isMobile.value ? currentCompany.value?.mobileSlider?.[0] : currentCompany.value?.slider?.[0]);
  }
}, { immediate: true });

const dSubcontentFlexDirection = computed(() => isMobile.value ? 'column' : 'row');

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

const idPageContentPadding =  computed(() => {
  switch(useLayoutSize()) {
    case 'XS':
    case 'S':
      return '30px 5px';
    case 'L':
    case 'M':
      return '40px';
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

const textAlign = computed(() => {
  if (containerDirection.value == 'column') {
    return 'center';
  }

  return 'left';
})

function activeIndexChange(e: any) {
  let index = e.target?.swiper?.realIndex ?? currentCompanyIndex.value;

  while (index >= companies.value?.length) {
    index -= companies.value?.length;
  }

  if (index == currentCompanyIndex.value) {
    return;
  }

  const route = companies.value?.[index]?.seoUrl;

  if (route != undefined) {
    id.value = route;
    window.history.pushState(null, companies.value?.[index]?.seoTitle, `/${route}`);
  }
}

const isBG = computed(() => currentCompany.value?.id == 1);

const basket = ref([])
const setBasket = (data) => {
  basket.value = data
  currentSection.value = 'basket'

  console.log(data, currentSection.value)
}
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
<DPopupMenu
    v-if="currentSection === 'catalog'"
    :company="currentCompany"
    @basket="setBasket"
    @close="currentSection = 'none'" />
<DPopupBasket
    v-if="currentSection === 'basket'"
    :company="currentCompany"
    :basket="basket"
    @close="currentSection = 'none'" />
<DPopupAbout
  v-if="currentSection === 'about'"
  :company="currentCompany"
  @close="currentSection = 'none'"/>
<DPopupEvents
  v-if="currentSection === 'events'"
  :company="currentCompany"
  @close="currentSection = 'none'"
/>
<DPopupSauna
  v-if="currentSection === 'sauna'"
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
        <div class="d-submenu">
          <template v-if="isMobile">
            <div v-if="isMobile" class="id-page__logo_mobile">
              <NuxtLink to="/">
                <DIcon icon="drinkInGroupLogo" :filled="false" />
              </NuxtLink>
            </div>
            <ClientOnly>
              <swiper-container
                :initialSlide="currentCompanyIndex + companies.length"
                :centeredSlides="true"
                slidesPerView="auto"
                :loop="true"
                :spaceBetween="30"
                style="max-width: 100vw"
                @activeindexchange="activeIndexChange"
              >
                <swiper-slide
                  v-for="(company, index) in [...companies, ...companies, ...companies]"
                  :key="`${company?.seoUrl}-${index}`"
                  class="text-slide"
                >
                  <DText
                    class="d-banner-menu-text"
                    theme="Title"
                    :style="{ opacity: currentCompany?.seoUrl == company?.seoUrl ? 1 : 0.4 }"
                  >{{ company?.name }}</DText>
                </swiper-slide>
              </swiper-container>
            </ClientOnly>
          </template>
          <DText v-else class="d-banner-menu-text" theme="Title">{{ currentCompany?.name }}</DText>
          <hr class="d-company-wrappe__hr" />
          <template v-if="isBG">
            <DText theme="Title-M-Medium" style="text-align: center;white-space: wrap;">Закрыто на реконструкцию</DText>
          </template>
          <template v-else-if="isActive">
            <DText
                v-if="[4, 9].includes(currentCompany.id)"
                theme="Title-M-Medium"
                clickable
                :style="{ marginBottom: containerGap }"
                @click="action({ type: 'catalog' })"
            >
              Доставка
            </DText>
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
          </template>
          <template v-else>
            <DText theme="Title-M-Medium" style="text-align: center;">Скоро открытие</DText>
          </template>
        </div>
        <div v-if="isMobile" class="d-slider-controls">
          <DIcon
            icon="arrowLeft"
            filled
            @click="goLeft"
          />
          <div class="d-dots">
            <div v-for="company in companies" class="d-dot" :class="company == currentCompany ? 'd-dot_active' : ''">
            </div>
          </div>
          <DIcon
            icon="arrowRight"
            filled
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
  width: 100%;
  overflow: hidden;
}

.id-page__content {
  width: 100%;
  display: flex;
  align-items: flex-start;
  justify-content: flex-start;
  gap: 30px;
  padding: v-bind(idPageContentPadding);
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
  max-width: 100vw;
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
  flex-direction: v-bind(dSubcontentFlexDirection);
  flex-wrap: wrap;
  gap: 32px;
  justify-content: space-evenly;
  padding: 70px 10px 10px 10px;
  margin-top: 30px;
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
  padding: 0 40px;
  box-sizing: border-box;
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

.d-banner-menu-text {
  text-wrap: nowrap !important;
}

.text-slide {
  width: auto !important;
}
</style>
