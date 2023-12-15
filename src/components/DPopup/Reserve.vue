<script setup lang="ts">
interface Props {
  company?: any;
}

const props = defineProps<Props>();

interface Emits {
  (eventName: 'close'): void;
};

const emits = defineEmits<Emits>();

const status = ref<'success' | 'error' | 'none'>('none');

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
      text += ' стол в ресторане '
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

  try {
    await $fetch(formatApi('/feedbacks/'), {
      method: 'POST',
      body: body,
    });

    status.value = 'success';
  } catch(error) {
    status.value = 'error';
  }
}
</script>

<template>
  <DModal @close="emits('close')">
    <form v-if="status == 'none'" @submit.prevent="send" class="d-popup-reserve">
      <DText theme="Title-S">{{ headerText }}</DText>
      <DText theme="Body-M">Оставьте свои контактные данные и пожелания для бронирования.</DText>
      <DText theme="Body-S">После отправки заявки с вами свяжутся в течение часа.</DText>
      <div class="d-popup-reserve__form">
        <input class="d-popup-reserve__input" v-model="name" placeholder="Ваше имя" required />
        <input class="d-popup-reserve__input" v-model="phone" placeholder="+7 (" required v-maska data-maska="+7 ### ###-##-##" />
        <div class="d-popup-reserve__input-block">
          <input class="d-popup-reserve__input" v-model="date" placeholder="Дата" required />
          <input class="d-popup-reserve__input" v-model="time" placeholder="Время" required />
        </div>
        <div class="d-popup-reserve__input-block">
          <input class="d-popup-reserve__input" v-model="count_guests" placeholder="Количество гостей" />
          <input class="d-popup-reserve__input" v-model="comment" placeholder="Комментарий" />
        </div>
      </div>
      <DButton theme="dark" type="submit">Отправить</DButton>
    </form>
    <div v-if="status == 'success'" class="d-popup-reserve d-popup-reserve_success">
      <DText theme="Title-S" class="d-popup-reserve__title">Ваши данные успешно отправлены</DText>
      <DText theme="Body-M">В ближайшее время с вами свяжется наш администратор для подтверждения бронирования</DText>
      <DText theme="Body-XS">Если вам не перезвонили, значит произошел технический сбой.</DText>
      <DText theme="Body-XS">Просьба связаться с нами по номеру: <a :href="`tel:${props.company?.phone}`">
        <DText theme="Body-XS">{{ props.company?.phone }}</DText></a>
      </DText>
    </div>
    <div v-if="status == 'error'" class="d-popup-reserve d-popup-reserve_error">
      <DText theme="Title-S" class="d-popup-reserve__title d-popup-reserve_error-title">Во время бронирования произошла ошибка</DText>
      <DText theme="Body-M">Попробуйте повторить позднее или свяжитесь с нами по телефону:</DText>
      <a :href="`tel:${props.company?.phone}`"><DText theme="Body-L-Medium">{{ props.company?.phone }}</DText></a>
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
  padding: 0 30px 30px 30px;
}

.d-popup-reserve__title {
  margin-top: 40px;
  margin-bottom: 40px;
}

.d-popup-reserve_error {
  gap: 30px;
}

.d-popup-reserve_success {
  gap: 10px;
}

.d-popup-reserve_error .d-popup-reserve_error-title {
  color: $color-accent !important;
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
  min-height: 40px;
  box-sizing: border-box;
  padding: 10px 0;
  border: none;
  border-bottom: 1px solid $color-grey-primary;
  background: transparent;
}

.d-popup-reserve__input:focus{
  outline: none;
}

.d-popup-reserve__input::placeholder {
  color: $color-grey-primary;
}
</style>