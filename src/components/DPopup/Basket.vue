<script setup lang="ts">
  import { register } from 'swiper/element/bundle'
  import { ref, onMounted, watch } from 'vue'
  import MaskInput from '@/components/Mask/MaskInput.vue'
  import { VueDadata } from 'vue-dadata'
  import 'vue-dadata/dist/style.css'
  import {toast} from "vue3-toastify";
  register()

  interface Props {
    company: any;
    basket: any;
  }

  const props = defineProps<Props>()
  const data = ref([])
  const toastOpts = {
    "theme": "colored",
    "type": "warning",
    "hideProgressBar": true,
    "transition": "flip",
    "dangerouslyHTMLString": true
  }
  const toastOptsError = {
    "theme": "colored",
    "type": "error",
    "hideProgressBar": true,
    "transition": "flip",
    "dangerouslyHTMLString": true
  }
  const form = ref({
    firstName: '',
    secondName: '',
    email: '',
    phone: '',
    comment: '',
    deliveryType: 1,
  })
  const addressQuery = ref()
  const addressObj = ref({
    data: {
      house: '',
      flat: ''
    }
  })
  const dadataToken = 'af0547f979fb8b1ba874281a3b5712e7d78f0c74'
  const mode = ref('basket')
  const sectors = {
    1: [
      { lat: 45.048538, lon: 39.053724 },
      { lat: 45.048939, lon: 39.084559 },
      { lat: 45.047335, lon: 39.089840 },
      { lat: 45.027745, lon: 39.092857 },
      { lat: 45.018583, lon: 39.100307 },
      { lat: 45.016243, lon: 39.094178 },
      { lat: 45.012430, lon: 39.074847 },
      { lat: 45.012229, lon: 39.061362 },
      { lat: 45.011159, lon: 39.050424 },
      { lat: 45.014366, lon: 39.049549 },
      { lat: 45.015504, lon: 39.046947 },
      { lat: 45.021163, lon: 39.049809 },
      { lat: 45.021840, lon: 39.047988 },
      { lat: 45.032347, lon: 39.048025 },
      { lat: 45.032624, lon: 39.048502 },
      { lat: 45.036898, lon: 39.047721 },
      { lat: 45.037600, lon: 39.047204 },
    ],
    2: [
      { lat: 45.040211, lon: 38.964692 },
      { lat: 45.034970, lon: 38.998572 },
      { lat: 45.019298, lon: 38.994914 },
      { lat: 45.010578, lon: 38.967326 },
      { lat: 45.012395, lon: 38.955838 },
      { lat: 45.008294, lon: 38.951740 },
      { lat: 45.013900, lon: 38.950276 },
      { lat: 45.017377, lon: 38.952837 },
      { lat: 45.017066, lon: 38.956569 },
      { lat: 45.023722, lon: 38.956876 },
      { lat: 45.024473, lon: 38.957456 }
    ],
    3: [
      { lat: 45.040472, lon: 38.964791 },
      { lat: 45.034986, lon: 38.998639 },
      { lat: 45.039763, lon: 38.994373 },
      { lat: 45.043077, lon: 38.989134 },
      { lat: 45.053589, lon: 38.983654 },
      { lat: 45.058787, lon: 38.983251 },
      { lat: 45.058901, lon: 38.981720 },
      { lat: 45.056959, lon: 38.980592 },
      { lat: 45.053417, lon: 38.973500 },
      { lat: 45.047590, lon: 38.971163 }
    ],
    4: [
      { lat: 45.012132, lon: 38.955794 },
      { lat: 45.010649, lon: 38.967248 },
      { lat: 45.019225, lon: 38.995157 },
      { lat: 45.007167, lon: 38.993066 },
      { lat: 45.007554, lon: 38.990975 },
      { lat: 45.010649, lon: 38.985703 },
      { lat: 45.010907, lon: 38.978521 },
      { lat: 45.008328, lon: 38.972612 },
      { lat: 44.999944, lon: 38.969885 },
      { lat: 44.994397, lon: 38.970339 },
      { lat: 44.992719, lon: 38.968885 },
      { lat: 44.992074, lon: 38.965976 },
      { lat: 44.992397, lon: 38.963430 },
      { lat: 44.999041, lon: 38.953430 },
      { lat: 45.007941, lon: 38.951703 }
    ],
    5: [
      { lat: 45.063693, lon: 38.946195 },
      { lat: 45.059074, lon: 38.981421 },
      { lat: 45.056754, lon: 38.980299 },
      { lat: 45.053506, lon: 38.973285 },
      { lat: 45.047208, lon: 38.971040 },
      { lat: 45.040445, lon: 38.964494 },
      { lat: 45.029020, lon: 38.959282 },
      { lat: 45.035121, lon: 38.955447 },
      { lat: 45.036646, lon: 38.950117 },
      { lat: 45.037243, lon: 38.940391 }
    ],
    6: [
      { lat: 45.059114, lon: 38.983565 },
      { lat: 45.059753, lon: 39.017835 },
      { lat: 45.028096, lon: 39.005707 },
      { lat: 45.020832, lon: 39.008155 },
      { lat: 45.019416, lon: 38.995078 },
      { lat: 45.035130, lon: 38.998621 },
      { lat: 45.039835, lon: 38.994370 },
      { lat: 45.043123, lon: 38.989152 },
      { lat: 45.053725, lon: 38.983676 }
    ],
    7: [
      { lat: 45.059739, lon: 39.017962 },
      { lat: 45.059682, lon: 39.022292 },
      { lat: 45.056272, lon: 39.028386 },
      { lat: 45.056158, lon: 39.037928 },
      { lat: 45.057828, lon: 39.043052 },
      { lat: 45.054585, lon: 39.043016 },
      { lat: 45.052035, lon: 39.055299 },
      { lat: 45.037614, lon: 39.047181 },
      { lat: 45.035688, lon: 39.031704 },
      { lat: 45.033409, lon: 39.024377 },
      { lat: 45.033866, lon: 39.023341 },
      { lat: 45.036577, lon: 39.009115 }
    ],
    8: [
      { lat: 45.036475, lon: 39.009115 },
      { lat: 45.033292, lon: 39.024452 },
      { lat: 45.035643, lon: 39.031812 },
      { lat: 45.037600, lon: 39.047232 },
      { lat: 45.036901, lon: 39.047627 },
      { lat: 45.032567, lon: 39.048376 },
      { lat: 45.032399, lon: 39.047903 },
      { lat: 45.021827, lon: 39.047942 },
      { lat: 45.021101, lon: 39.049765 },
      { lat: 45.015646, lon: 39.046925 },
      { lat: 45.021609, lon: 39.019200 },
      { lat: 45.020742, lon: 39.008196 },
      { lat: 45.027987, lon: 39.005909 }
    ],
    12: [
      { lat: 45.019474, lon: 38.995473 },
      { lat: 45.021531, lon: 39.019253 },
      { lat: 45.015566, lon: 39.046947 },
      { lat: 45.014435, lon: 39.049557 },
      { lat: 45.011452, lon: 39.050427 },
      { lat: 45.006801, lon: 39.043374 },
      { lat: 45.000780, lon: 39.037965 },
      { lat: 44.994825, lon: 39.034608 },
      { lat: 44.987877, lon: 39.036473 },
      { lat: 44.971814, lon: 39.028522 },
      { lat: 44.968504, lon: 39.024792 },
      { lat: 44.968967, lon: 39.020689 },
      { lat: 44.971483, lon: 39.018690 },
      { lat: 44.982704, lon: 39.020929 },
      { lat: 44.987696, lon: 39.020257 },
      { lat: 45.000803, lon: 39.013274 },
      { lat: 45.003282, lon: 39.009692 },
      { lat: 45.003472, lon: 39.002482 },
      { lat: 45.007218, lon: 38.993303 }
    ],
    13: [
      { lat: 45.012150, lon: 39.061352 },
      { lat: 45.012451, lon: 39.075878 },
      { lat: 45.016247, lon: 39.094311 },
      { lat: 45.018259, lon: 39.100566 },
      { lat: 44.974379, lon: 39.064770 },
      { lat: 44.975938, lon: 39.057769 },
      { lat: 44.983900, lon: 39.048913 },
      { lat: 45.004974, lon: 39.060188 }
    ]
  }
  const sectorPrice = {
    1: 300,
    2: 320,
    3: 360,
    4: 330,
    5: 400,
    6: 310,
    7: 310,
    8: 250,
    12: 280,
    13: 350
  }
  const locationOptions = {
    locations: [{
      city: "Краснодар" }
    ],
    restrict_value: true
  }
  const addressSector = ref()

  const section = computed(() => {
    return props.company.sections.find((section: any) => section?.type == 'menu')
  })
  const basketTotal = computed(() => {
    let total = 0
    data.value.forEach((item) => {
      total += (parseInt(item.qty) * parseInt(item.price))
    })
    return total
  })
  const formDisabled = computed(() => {
    return !form.value.email || !form.value.firstName || !form.value.phone
  })
  const validEmail = computed(() => {
    return String(form.value.email)
        .toLowerCase()
        .match(
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        )
  })
  const deliveryPrice = computed(() => {
    return addressSector.value ? sectorPrice[addressSector.value] : 0
  })

  const incQty = (itemId) => {
    const itemIdx = data.value.findIndex((basketItem) => basketItem.id === itemId)
    if (itemIdx !== -1) {
      data.value[itemIdx].qty += 1
    }
  }
  const decQty = (itemId) => {
    const itemIdx = data.value.findIndex((basketItem) => basketItem.id === itemId)
    if (itemIdx !== -1) {
      if (data.value[itemIdx].qty > 1) {
        data.value[itemIdx].qty -= 1
      }
    }
  }
  const removeItem = (itemId) => {
    const itemIdx = data.value.findIndex((basketItem) => basketItem.id === itemId)
    data.value.splice(itemIdx, 1)
  }

  const isMobile = computed(() => useLayoutSize() == 'XS' || useLayoutSize() == 'S')

  const makeOrder = async  () => {
    const orderData = {
      order: props.basket.map((item) => { return { id: item.id, count: item.qty } }),
      amount: basketTotal.value,
      delivery: form.value.deliveryType === 1 ? deliveryPrice.value : 0,
      userInfo: {
        firstName: form.value.firstName,
        secondName: form.value.secondName,
        address: form.value.deliveryType === 1 ? `${addressObj.value.data.street_with_type} ${addressObj.value.data.house} ${addressObj.value.data.flat}` : '',
        phone: form.value.phone.replaceAll(' ',''),
        comment: form.value.comment,
        email: form.value.email
      },
      typeOfDelivery: form.value.deliveryType,
      institution_id : props.company.id
    }


    const { error, data } = await useFetch(formatApi('/order'), {
      method: 'POST',
      body: orderData
    })

    console.log(error, data)

    if (!data) {
      toast(error.value.data.error, toastOptsError)
    } else {
      const checkout = new window.YooMoneyCheckoutWidget({
        confirmation_token: data.value.confirmation_token,
        return_url: 'http://drink-in-group.ru',
        error_callback: function (error) {
          console.log(error)
        }
      })

      mode.value = 'payment'
      checkout.render('payment-form')
    }
  }
  const isPointInPolygon = (point, polygon) => {
    const [x, y] = [point.lon, point.lat]
    let inside = false

    for (let i = 0, j = polygon.length - 1; i < polygon.length; j = i++) {
      const [xi, yi] = [polygon[i].lon, polygon[i].lat]
      const [xj, yj] = [polygon[j].lon, polygon[j].lat]

      const intersect = ((yi > y) !== (yj > y)) &&
          (x < (xj - xi) * (y - yi) / (yj - yi) + xi)
      if (intersect) inside = !inside
    }

    return inside
  }
  const findSector = (coordinates) => {
    addressSector.value = ''
    for (const [sector, polygon] of Object.entries(sectors)) {
      if (isPointInPolygon(coordinates, polygon)) {
        addressSector.value = sector
        return
      }
    }
    if (!addressSector.value) {
      form.value.deliveryType = 1
      toast(`По вашему адресу доступен только самовывоз`, toastOpts)
    }
  }

  watch(() => addressObj.value, () => {
    if (addressObj.value.data.geo_lat && addressObj.value.data.geo_lon) {
      findSector({
        lat: addressObj.value.data.geo_lat,
        lon: addressObj.value.data.geo_lon
      })
      form.value.address = addressQuery.value
    }
  }, { deep: true })
  watch(() => form.value, () => {
    if (form.value.deliveryType === 2) {
      addressQuery.value = ''
      addressObj.value = {
        data: {
          house: '',
          flat: ''
        }
      }
      addressSector.value
      form.value.address = ''
    }
  }, { deep: true })

  onMounted(() => {
    data.value = props.basket
  })
</script>

<template>
  <DPopup :logo="company?.logo">
    <div class="d-popup-about">
      <DText theme="Title-M-Regular">{{ company?.type }} {{ company?.name }}</DText>
      <DText theme="Body-M" class="d-popup-about__text">{{ section?.headerText }}</DText>

      <div class="basket__content">
        <template v-if="mode === 'payment'">
          <h4 class="basket__heading">Оплата</h4>
        </template>
        <div id="payment-form" style="width: 100%"></div>
        <template v-if="mode === 'basket'">
          <h4 class="basket__heading">Корзина</h4>
          <div
              v-if="data.length"
              class="basket__items"
              :class="{'basket__items--mobile': isMobile}"
          >
            <div
                class="basket__item"
                :class="{'basket__item--mobile': isMobile}"
                v-for="(item, idx) in data"
            >
              <div
                  class="basket__item-num"
                  :class="{'basket__item-num--mobile': isMobile}"
              >{{ idx+1 }}</div>
              <div
                  class="basket__item-name"
                  :class="{'basket__item-name--mobile': isMobile}"
              >{{ item.name }}</div>
              <div
                  class="basket__item-qty"
                  :class="{'basket__item-qty--mobile': isMobile}"
              >
                <div @click="decQty(item.id)">-</div>
                <div>{{ item.qty }}</div>
                <div @click="incQty(item.id)">+</div>
              </div>
              <div
                  class="basket__item-price"
                  :class="{'basket__item-price--mobile': isMobile}"
              >{{ item.qty * item.price }} ₽</div>
              <div
                  class="basket__item-remove"
                  :class="{'basket__item-remove': isMobile}"
                  @click="removeItem(item.id)"
              >
                <img src="/public/trash.svg" />
              </div>
            </div>
          </div>
          <div v-else>
            Корзина пуста
          </div>
          <div v-if="data.length" style="width: 100%">
            <h4 class="basket__heading">Способ доставки</h4>
            <div class="order__form">
              <div class="order__form-item">
                <div
                    class="order__form-flex order__form-flex--fstart"
                    :class="{'order__form-flex--mobile': isMobile}"
                >
                  <div class="order__form-item">
                    <input
                        type="radio"
                        class="order__form-radio"
                        :class="{'order__form-radio--mobile': isMobile}"
                        v-model="form.deliveryType" :value="1"
                    />
                    <label
                        class="order__form-label order__form-label--radio"
                        :class="{'order__form-label--mobile': isMobile}"
                    >
                      Доставка
                      <div v-if="deliveryPrice">Стоимость доставки: {{ deliveryPrice }}  ₽</div>
                      <div v-else>Стоимость доставки будет подсчитана после указания адреса</div>
                    </label>
                  </div>
                  <div class="order__form-item">
                    <input
                        type="radio"
                        class="order__form-radio"
                        :class="{'order__form-radio--mobile': isMobile}"
                        v-model="form.deliveryType" :value="2"
                    />
                    <label
                        class="order__form-label order__form-label--radio"
                        :class="{'order__form-label--mobile': isMobile}"
                    >
                      Самовывоз
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <template v-if="form.deliveryType === 1">
              <h4 class="basket__heading">Адрес доставки</h4>
              <div class="order__form">
                <div class="order__form-item">
                  <div class="order__form-item order__form-item--groupped-left">
                    <label
                        class="order__form-label"
                        :class="{'order__form-label--mobile': isMobile}"
                    >
                      <div>Адрес</div>
                      <vue-dadata
                          class="order__form-input"
                          v-model="addressQuery"
                          v-model:suggestion="addressObj"
                          :location-options="locationOptions"
                          :token="dadataToken"
                      />
                    </label>
                  </div>
                </div>
                <div class="order__form-item">
                  <div class="order__form-flex">
                    <div class="order__form-item order__form-item--groupped-left">
                      <label
                          class="order__form-label"
                          :class="{'order__form-label--mobile': isMobile}"
                      >
                        <div>Дом</div>
                        <input
                            type="text"
                            class="order__form-input order__form-input--groupped-left"
                            :class="{'order__form-input--mobile': isMobile}"
                            v-model="addressObj.data.house"
                        />
                      </label>
                    </div>
                    <div class="order__form-item order__form-item--groupped-right">
                      <label
                          class="order__form-label"
                          :class="{'order__form-label--mobile': isMobile}"
                      >
                        <div>Квартира</div>
                        <input
                            type="text"
                            class="order__form-input order__form-input--groupped-right"
                            :class="{'order__form-input--mobile': isMobile}"
                            v-model="addressObj.data.flat"
                        />
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </template>
            <h4 class="basket__heading">Контакты</h4>
            <div class="order__form">
              <div class="order__form-item">
                <label
                    class="order__form-label"
                    :class="{'order__form-label--mobile': isMobile}"
                >
                  <div>Email</div>
                  <input
                      type="email"
                      v-model="form.email"
                      class="order__form-input"
                      :class="{
                        'order__form-input--error': form.email && !validEmail,
                        'order__form-input--mobile': isMobile
                      }"
                  />
                </label>
              </div>
              <div class="order__form-item">
                <div class="order__form-flex">
                  <div class="order__form-item order__form-item--groupped-left">
                    <label
                        class="order__form-label"
                        :class="{'order__form-label--mobile': isMobile}"
                    >
                      <div>Имя</div>
                      <input
                          type="text"
                          v-model="form.firstName"
                          class="order__form-input order__form-input--groupped-left"
                          :class="{'order__form-input--mobile': isMobile}"
                      />
                    </label>
                  </div>
                  <div class="order__form-item order__form-item--groupped-right">
                    <label
                        class="order__form-label"
                        :class="{'order__form-label--mobile': isMobile}"
                    >
                      <div>Фамилия</div>
                      <input
                          type="text"
                          v-model="form.secondName"
                          class="order__form-input order__form-input--groupped-right"
                          :class="{'order__form-input--mobile': isMobile}"
                      />
                    </label>
                  </div>
                </div>
              </div>
              <div class="order__form-item">
                <label
                    class="order__form-label"
                    :class="{'order__form-label': isMobile}"
                >
                  <div>Телефон</div>
                  <MaskInput
                      v-model="form.phone"
                      class="order__form-input"
                      :class="{'order__form-input--mobile': isMobile}"
                      mask="+7 (###) ###-##-##"
                      placeholder="+7 (123) 456-78-90"
                  />
                </label>
              </div>
            </div>
            <h4 class="basket__heading">Комментарий к заказу</h4>
            <div class="order__form">
              <div class="order__form-item">
                <label
                    class="order__form-label"
                    :class="{'order__form-label--mobile': isMobile}"
                >
                  <textarea
                      class="order__form-textarea"
                      :class="{'order__form-textarea--mobile': isMobile}"
                      v-model="form.comment"
                  ></textarea>
                </label>
              </div>
            </div>
            <div class="order__form">
              <div class="order__form-item">
                <div class="basket__delivery" v-if="deliveryPrice">
                  <div class="basket__delivery-title">Стоимость доставки</div>
                  <div class="basket__delivery-price">{{ deliveryPrice }} ₽</div>
                </div>
                <div class="basket__total">
                  <div class="basket__total-title">Итого к оплате</div>
                  <div class="basket__total-price">{{ basketTotal + deliveryPrice }} ₽</div>
                </div>
              </div>
              <div class="order__form-item">
                <button
                    class="order__form-button"
                    :disabled="formDisabled"
                    @click.once="makeOrder()"
                >Перейти к оплате</button>
              </div>
            </div>
          </div>
        </template>
      </div>

      <DText theme="Body-L-Regular" class="d-popup-about__text">{{ section?.footerText }}</DText>
    </div>
  </DPopup>
</template>

<style lang="scss">
.basket__content {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  width: 60%;
  font-family: "Golos Text", "Trebuchet MS";
  font-size: 14px;
}
.basket__heading {
  padding: 0;
  margin: 0;
  margin-bottom: 36px;
  text-align: left;
  font-size: 22px;
  font-weight: bold;
}
.basket__items {
  width: 100%;
  margin-bottom: 54px;
  display: flex;
  flex-direction: column;
  gap: 16px;
}
.basket__item {
  flex: 1;
  display: flex;
  font-size: 16px;
  padding-bottom: 16px;
  border-bottom: 1px solid rgba(0, 0, 0, .1);
  align-items: center;

  &--mobile {
    flex-wrap: wrap;
  }
}
.basket__item-num {
  margin-right: 24px;

  &--mobile {
    display: none;
  }
}
.basket__item-name {
  margin-right: auto;

  &--mobile {
    text-align: left;
    margin-bottom: 12px;
    width: 100%;
  }
}
.basket__item-qty {
  margin-left: auto;
  margin-right: 24px;
  display: flex;
  align-items: center;
  border-radius: 16px;
  border: 1px solid rgba(0,0,0,0.1);

  &--mobile {
    margin-left: 0;
    margin-right: auto;
  }
}
.basket__item-qty div {
  border-left: 1px solid rgba(0,0,0,0.1);
  padding: 4px 12px;
}
.basket__item-qty div:first-child {
  border: none;
  cursor: pointer;
  padding: 3px 8px 4px;
}
.basket__item-qty div:last-child {
  cursor: pointer;
  padding: 3px 8px 4px;
}
.basket__item-price {
  width: 72px;
  text-align: right;

  &--mobile {
    margin-right: 0;
    margin-left: auto;
  }
}
.basket__item-remove {
  opacity: 0.5;
  transition: opacity 0.2s;

  &:hover {
    opacity: 1;
  }
  img {
    width: 20px;
    margin-top: 4px;
    margin-left: 12px;
    cursor: pointer;
  }
}
.basket__delivery {
  display: flex;
  align-items: center;
  gap: 24px;
  font-size: 16px;
}
.basket__delivery-title {
  margin-left: auto;
}
.basket__delivery-price {
  width: 72px;
  text-align: right;
}
.basket__total {
  display: flex;
  align-items: center;
  gap: 24px;
  font-size: 16px;
  font-weight: bold;
}
.basket__total-title {
  margin-left: auto;
}
.basket__total-price {
  width: 72px;
  text-align: right;
}
.order__form {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 24px;
  align-items: flex-start;
  margin-bottom: 54px;
}
.order__form-item {
  flex: 1;
  width: 100%;
  position: relative;

  &--groupped-left {
    margin-right: -13px;
  }
  &--groupped-middle {
    margin-left: -12px;
    margin-right: -13px;
  }
  &--groupped-right {
    margin-left: -12px;
  }
}
.order__form-label {
  text-align: left;
  cursor: pointer;

  &--mobile {}

  > div {
    margin-bottom: 12px;
  }

  &--radio {
    display: block;
    border: 1px solid rgba(51, 51, 51, 0.1);
    font-weight: 400;
    font-size: 16px;
    line-height: 18px;
    color: #333333;
    padding: 16px 20px;
    border-radius: 10px;
    min-height: 70px;
    box-sizing: border-box;

    div {
      margin-top: 10px;
      font-size: 14px;
      color: rgba(0, 0, 0, .5)
    }
  }
}
.order__form-input {
  color: #333333;
  height: 51px;
  padding: 0 15px;
  max-width: 100%;
  width: 100%;
  border: 1px solid rgba(0,0,0,0.1);
  outline: none;
  border-radius: 10px;
  box-sizing: border-box;

  &--mobile {}

  &--error {
    border-color: rgb(196,22,28);
  }

  &::placeholder {
    color: rgba(0, 0, 0, .3);
  }

  &--groupped-left {
    border-radius: 10px 0 0 10px;
  }
  &--groupped-right {
    border-radius: 0 10px 10px 0;
  }
  &--groupped-middle {
    border-radius: 0;
  }
}
.order__form-textarea {
  color: #333333;
  height: 120px;
  padding: 15px;
  max-width: 100%;
  width: 100%;
  border: 1px solid rgba(0,0,0,0.1);
  outline: none;
  border-radius: 10px;
  resize: none;
  box-sizing: border-box;

  &--mobile {}
}
.order__form-radio {
  position: absolute;
  opacity: 0;
  width: 100%;
  height: 100%;
  left: 0;
  cursor: pointer;

  &:checked + label {
    border: 2px solid #C4161C;
  }
}
.order__form-button {
  display: flex;
  padding: 14px 28px;
  font-size: 14px;
  line-height: 20px;
  border-radius: 35px;
  color: #fff;
  box-shadow: none;
  border: none;
  outline: none;
  justify-content: center;
  background-color: rgb(196,22,28);
  width: 100%;
  text-transform: uppercase;
  cursor: pointer;

  &:disabled {
    background-color: #9B9CA2;
    cursor: default;
  }
}
.order__form-flex {
  width: 100%;
  display: flex;
  align-items: center;
  gap: 24px;

  &--mobile {
    flex-direction: column;
    align-items: flex-start;
  }

  &--fstart {
    align-items: flex-start;
  }
}

.vue-dadata__input {
  width: 100%;
  border: none;
  transition: .3s;
  box-sizing: border-box;
  outline: none;
}
</style>
