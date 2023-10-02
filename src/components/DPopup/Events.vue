<script setup lang="ts">
import dayjs from 'dayjs';
import customParseFormat from 'dayjs/plugin/customParseFormat';
dayjs.extend(customParseFormat);

interface Props {
  company: any;
}

const props = defineProps<Props>();
const section = computed(() => props.company.sections.find((section: any) => section?.type == 'events'));

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

const containerDirection = computed(() => {
  if (useLayoutSize() == 'XS' || useLayoutSize() == 'S') {
    return 'column';
  }

  return 'row';
});

function isNew(date: string, time: string) {
  const parsedDate = dayjs(`${date} ${time}`, "DD-MM-YYYY HH:mm");
  return parsedDate.isValid() && parsedDate.isAfter(dayjs());
}
</script>

<template>
  <DPopup
    :logo="company?.logo"
  >
    <div class="d-popup-events">
      <DText theme="Title-M-Regular">СОБЫТИЯ</DText>
      <DText theme="Body-M" class="d-popup-events__text">{{ section?.headerText }}</DText>

      <div class="d-popup-events__events-list">
        <div
          v-for="event in section?.events"
          class="d-popup-events__event"
        >
          <div class="d-popup-events__event-poster" :style="{ backgroundImage: `url(${event?.image})` }"></div>
          <div class="d-popup-events__event-info">
            <div class="d-popup-events__event-time">
              <div class="d-border">{{ event?.date }}</div>
              <div class="d-border">{{ event?.time }}</div>
              <div v-if="isNew(event?.date, event?.time)" class="d-border d-border__new-label">NEW</div>
            </div><br>
            <DText theme="Title-XS">{{ event?.title }}</DText><br>
            <DText theme="Body-S">{{ event?.content }}</DText><br><br>
          </div>
        </div>
      </div>
      <DText theme="Body-L-Regular" class="d-popup-events__text">{{ section?.footerText }}</DText>
      <div class="d-popup-events__reserve">
        <DText theme="Body-S">ЗАБРОНИРОВАТЬ СТОЛ:</DText>
        <a :href="`tel:${company?.phone}`"><DText theme="Number">{{ company?.phone }}</DText></a>
      </div>
    </div>
  </DPopup>
</template>

<style lang="scss">
.d-popup-events {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 40px;
  padding-bottom: 40px;
}

.d-popup-events__events-list {
  text-align: left;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
}

.d-popup-events__event {
  text-align: left;
  margin: v-bind(contentPadding);
  display: flex;
  flex-direction: v-bind(containerDirection);
  gap: 20px;
  align-items: center;
}

.d-popup-events__event:not(:last-child) {
  padding-bottom: 20px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.30);
}

.d-popup-events__event-poster {
  border-radius: 10px;
  width: 283px;
  height: 279px;
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  flex-shrink: 0;
}

.d-popup-events__event-time {
  display: flex;
  gap: 20px;
}

.d-popup-events__text {
  padding: v-bind(contentPadding);
}

.d-popup-events__slider {
  height: 710px;
  width: 100%
}

.d-popup-events__slider2 {
  height: 460px;
  width: 100%
}

.d-popup-events__slide {
  border-radius: 10px;
  height: 100%;
  max-width: 650px;
  background-repeat: no-repeat !important;
  background-size: cover !important;
  background-position: center !important;
}

.d-popup-events__reserve {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
}

.d-border.d-border__new-label {
  color: $color-accent;
  border-color: $color-accent;
  margin-left: auto;
}
</style>