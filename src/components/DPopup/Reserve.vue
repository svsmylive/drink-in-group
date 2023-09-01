<script setup lang="ts">
interface Props {
  company?: any;
}

const props = defineProps<Props>();

interface Emits {
  (eventName: 'close'): void;
};

const emits = defineEmits<Emits>();

const isSended = ref(false);

const name = ref('');
const phone = ref('');
const date = ref('');
const time = ref('');
const count_guests = ref('');
const comment = ref('');

const company = computed(() => props.company);

const headerText = computed(() => {
  let text = 'Забронировать';
  switch(company.value?.type) {
    case 'Ресторан':
      text += ' столик в ресторане '
      break;
    case 'Сауна':
      text += ' сауну '
      break;
    case 'Караоке':
      text += ' караоке '
      break;
  }
  return `${text} ${company.value?.name}`;
});

const containerDirection = computed(() => {
  if (useLayoutSize() == 'XS' || useLayoutSize() == 'S') {
    return 'column';
  }

  return 'row';
});

async function send() {
  const body = {
    institution_id: company.value?.id,
    name: name.value,
    phone: phone.value,
    date: date.value,
    time: time.value,
    count_guests: count_guests.value,
    comment: comment.value,
  };

  await $fetch(formatApi('/feedbacks'), {
      method: 'POST',
      body: body,
  });

  isSended.value = true;
}
</script>

<template>
  <DModal @close="emits('close')">
    <form v-if="!isSended" @submit.prevent="send" class="d-popup-reserve">
      <DText theme="Title-S">{{ headerText }}</DText>
      <DText theme="Body-M">Оставьте свои контактные данные и пожелания для бронирования</DText>
      <div class="d-popup-reserve__form">
        <input class="d-popup-reserve__input" v-model="name" placeholder="Ваше имя" required />
        <input class="d-popup-reserve__input" v-model="phone" placeholder="+7 (" required v-maska data-maska="+7 ### ###-##-##" />
        <div class="d-popup-reserve__input-block">
          <input class="d-popup-reserve__input" v-model="date" placeholder="Дата" type="date" max="9999-12-31" required />
          <input class="d-popup-reserve__input" v-model="time" placeholder="Время" required />
        </div>
        <div class="d-popup-reserve__input-block">
          <input class="d-popup-reserve__input" v-model="count_guests" placeholder="Количество гостей" />
          <input class="d-popup-reserve__input" v-model="comment" placeholder="Комментарий" />
        </div>
      </div>
      <DButton theme="dark" type="submit">Отправить</DButton>
    </form>
    <div v-else class="d-popup-reserve">
      <DText theme="Title-S">Ваши данные успешно отправлены</DText>
      <DText theme="Body-M">В ближайшее время с вами свяжется наш администратор для подтверждения бронирования</DText>
    </div>
  </DModal>
</template>

<style lang="scss">
.d-popup-reserve {
  display: flex;
  flex-direction: column;
  gap: 15px;
  align-items: center;
  z-index: 8000;
  position: relative;
}

.d-popup-reserve__form {
  width: 100%;
  max-width: 550px;
  display: flex;
  flex-direction: column;
  gap: 15px;
  align-items: center;
  margin: 0 auto;
  padding-bottom: 20px;
}

.d-popup-reserve__input-block {
  width: 100%;
  display: flex;
  align-items: center;
  gap: 30px;
}

.d-popup-reserve__input {
  width: 100%;
  padding: 10px 0;
  border: none;
  border-bottom: 1px solid #9B9CA2;
  background: transparent;
}

.d-popup-reserve__input:focus{
    outline: none;
}

.d-popup-reserve__input::placeholder {
  color: #9B9CA2;
}
</style>