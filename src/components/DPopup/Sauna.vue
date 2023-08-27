<script setup lang="ts">
interface Props {
  company: any;
}

const props = defineProps<Props>();
const section = computed(() => props.company.sections.find((section: any) => section?.type == 'sauna'));

const contentPadding =  computed(() => {
  switch(useLayoutSize()) {
    case 'XS':
      return '0 15px';
    case 'S':
      return '0 50px';
    case 'L':
      return '0 150px';
    case 'M':
      return '0 250px';
  }
});
</script>

<template>
  <DPopup
    :logo="company?.logo"
  >
    <div class="d-popup-sauna">
      <DText theme="Title-M-Regular">Наши услуги и цены</DText>
      <DText theme="Body-M" class="d-popup-sauna__text">{{ section?.headerText }}</DText>

      <div class="d-popup-sauna__poster" :style="{ backgroundImage: `url(${section?.image})` }">
        <div class="d-popup-sauna__capacity">
          <DText theme="Body-S" class="d-popup-sauna__capacity-title">Вместимость</DText>
          <DText theme="Body-S" class="d-popup-sauna__capacity-value">{{ section?.capacity }}</DText>
        </div>
      </div>

      <div class="d-popup-sauna__price">
        <DText theme="Body-S" class="d-popup-sauna__text">{{ section?.price }}</DText>
      </div>

      <div v-if="section?.includes?.length > 0">
        <DText theme="Body-S" class="d-popup-sauna__text">Аренда сауны включает в себя:</DText>
        <div class="d-popup-sauna__includes">
          <div v-for="service in section?.includes">
            <div class="d-border">{{ service }}</div>
          </div>
        </div>
      </div>

      <div v-if="section?.includesExtra?.length > 0">
        <DText theme="Body-S" class="d-popup-sauna__text">Дополнительные услуги:</DText>
        <div class="d-popup-sauna__includes">
          <div v-for="service in section?.includesExtra">
            <div class="d-border">{{ service }}</div>
          </div>
        </div>
      </div>

      <DText theme="Body-M" class="d-popup-sauna__text">{{ section?.bodyText }}</DText>
      <DText theme="Body-L-Regular" class="d-popup-sauna__text">{{ section?.footerText }}</DText>
      <div class="d-popup-sauna__reserve">
        <DText theme="Body-S" class="d-popup-sauna__text">ЗАБРОНИРОВАТЬ:</DText>
        <a :href="`tel:${company?.phone}`"><DText theme="Number">{{ company?.phone }}</DText></a>
      </div>
    </div>
  </DPopup>
</template>

<style lang="scss">
.d-popup-sauna {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 50px;
  padding: v-bind(contentPadding);
  padding-bottom: 40px;
}

.d-popup-sauna__poster {
  border-radius: 10px;
  width: 100%;
  height: 460px;
  margin: v-bind(contentPadding);
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  position: relative;
  margin-bottom: 30px;
}

.d-popup-sauna__price > .d-popup-sauna__text {
  color: $color-accent !important;
  padding: 20px 0;
  border-top: 1px solid rgba(0, 0, 0, 0.20);
  border-bottom: 1px solid rgba(0, 0, 0, 0.20);
}

.d-popup-sauna__includes {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-wrap: wrap;
  gap: 20px;
  margin-top: 35px;
}

.d-popup-sauna__capacity > .d-popup-sauna__capacity-title {
  color: #666 !important;
}

.d-popup-sauna__capacity > .d-popup-sauna__capacity-value {
  font-weight: 500 !important;
}

.d-popup-sauna__capacity {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 16px 65px;
  border-radius: 100px;
  background: $color-white;
  position: absolute;
  left: 50%;
  bottom: 0;
  transform: translate(-50%, 50%);
}

.d-popup-sauna__text {
  margin: v-bind(contentPadding);
}

.d-popup-sauna__reserve {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
}
</style>