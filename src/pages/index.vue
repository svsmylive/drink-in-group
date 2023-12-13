<script setup lang="ts">
const { companies } = useCompanies();

const isMobile = computed(() => useLayoutSize() == 'XS' || useLayoutSize() == 'S');

const currentBackground = ref();
const currentCompany = ref();


const slider = computed(() => isMobile.value ? currentCompany.value?.mobileSlider : currentCompany.value?.slider);

const backgroundImage = computed(() => {
  const image = currentBackground.value ?? isMobile.value ? companies.value?.[0]?.mobileSlider?.[0] : companies.value?.[0]?.slider?.[0];

  if (image != undefined) {
    return `linear-gradient(0deg, rgba(0, 0, 0, 0.50) 0%, rgba(0, 0, 0, 0.50) 100%), url(${image})`;
  }
});

async function setCurrentCompany(company?: any) {
  const image = isMobile.value ? company?.mobileSlider?.[0] : company?.slider?.[0];

  if (image != undefined) {
    const img = new Image();
    img.src = image;
    await img.decode();

    currentCompany.value = company;
  }
}

const { data } = await useFetch<{
  data: {
    title: string;
    description: string;
  }
}>(formatApi('/institutions/main/page/'));

const seoTitle = computed(() => data.value?.data?.title ?? 'Сеть ресторанов DRINK IN GROUP');
const seoDescription = computed(() => data.value?.data?.description ?? '');
</script>

<template>
<div
  class="index-page"
  :style="{
    backgroundImage: backgroundImage,
  }"
>
  <Head>
    <Title>{{ seoTitle }}</Title>
    <Meta name="description" :content="seoDescription" />
  </Head>
  <ClientOnly>
  <DSlider v-if="currentCompany != undefined" :images="slider" />
  <div class="index-page__content" :class="{ 'index-page__content_mobile': isMobile }">
    <div class="index-page__menu" :class="{ 'index-page__menu_mobile': isMobile }">
      <div
        v-for="company in companies"
        :key="company.id"
        class="index-page__menu-item"
        @mouseover="setCurrentCompany(company)"
      >
        <NuxtLink :to="company?.seoUrl">
          <DBannerMenu
            :company="company"
          />
        </NuxtLink>
      </div>
    </div>
    <div class="index-page__logo" :class="{ 'index-page__logo_mobile': isMobile }">
      <DIcon icon="drinkInGroupLogo" :filled="false" />
    </div>
  </div>
  </ClientOnly>
</div>
</template>

<style lang="scss">
.index-page {
  min-height: 100vh;
  display: flex;
  align-items: center;
  padding: 0 40px;
  justify-content: center;
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
}

.index-page__content {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  z-index: 100;
}

.index-page__content_mobile {
  flex-direction: column-reverse;
}

.index-page__menu {
  @include webkitScrollbar();

  flex: 0 1 700px;
  display: flex;
  flex-direction: column;
  max-height: 90vh;
  overflow-y: auto;
}

.index-page__menu_mobile {
  max-height: none;
  overflow: visible;
  flex: 0 1 600px;
}

.index-page__menu-item:not(:last-child) {
  border-bottom: 1px solid $color-white;
}

.index-page__logo {
  color: $color-white;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;

  & .nuxt-icon svg{
    height: 250px !important;
    font-size: 450px;
    margin: 0;
  }
}

.index-page__logo_mobile {
  color: $color-white;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;

  & .nuxt-icon svg{
    height: 150px !important;
    font-size: 300px;
    margin: 0;
  }
}
</style>