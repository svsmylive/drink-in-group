<script setup lang="ts">
  import { register } from 'swiper/element/bundle'
  import { ref, onMounted } from 'vue'
  import { toast } from 'vue3-toastify'
  import 'vue3-toastify/dist/index.css'
  register()

  interface Props {
    company: any;
  }

  const props = defineProps<Props>()

  const catalog = ref([])
  const basket = ref([])
  const selectedCategoryId = ref('')

  const toastOpts = {
    "theme": "colored",
    "type": "success",
    "hideProgressBar": true,
    "transition": "flip",
    "dangerouslyHTMLString": true
  }

  const isMobile = computed(() => useLayoutSize() == 'XS' || useLayoutSize() == 'S')

  const section = computed(() => {
    return props.company.sections.find((section: any) => section?.type == 'menu')
  })

  const catalogItems = computed(() => {
    return selectedCategoryId.value ? catalog.value.find((category) => category.id === selectedCategoryId.value).dishes : catalog.value.reduce((accumulator, currentValue) => {
      return accumulator.concat(currentValue.dishes)
    }, [])
  })
  const basketQty = computed(() => {
    let qty = 0
    basket.value.forEach((item) => {
      qty += item.qty
    })
    return qty
  })

  const fetchCatalog = async () => {
    const companyId = props.company.id
    const { data } = await $fetch(formatApi(`/categories/index?institution_id=${companyId}`))
    catalog.value = data
  }

  const itemQty = (itemId) => {
    const basketItem = basket.value.find((item) => item.id === itemId)
    return basketItem ? basketItem.qty : 0
  }
  const addToBasket = (itemId) => {
    const catalogItem = catalogItems.value.find((item) => item.id === itemId)
    const basketItemIdx = basket.value.findIndex((basketItem) => basketItem.id === itemId)
    if (basketItemIdx === -1) {
      basket.value.push({...catalogItem, qty: 1})
      toast(`${catalogItem.name} добавлен(о) в корзину`, toastOpts)
    }
  }
  const itemInBasket = (itemId) => {
    const basketItem = basket.value.find((item) => item.id === itemId)
    return basketItem ? true : false
  }
  const decQty = (itemId) => {
    const basketItemIdx = basket.value.findIndex((basketItem) => basketItem.id === itemId)
    if (basketItemIdx !== -1) {
      if (basket.value[basketItemIdx].qty === 1) {
        basket.value.splice(basketItemIdx, 1)
      }
      basket.value[basketItemIdx].qty -= 1
    }
  }
  const incQty = (itemId) => {
    const basketItemIdx = basket.value.findIndex((basketItem) => basketItem.id === itemId)
    if (basketItemIdx !== -1) {
      basket.value[basketItemIdx].qty += 1
    }
  }

  const emit = defineEmits(['basket'])

  const setBasket = () => {
    emit('basket', basket.value)
  }

  onMounted(() => {
    fetchCatalog()
  })
</script>

<template>
  <DPopup
    :logo="company?.logo"
  >
    <div class="basket" @click="setBasket">
      <span>{{ basketQty }}</span>
    </div>
    <div class="d-popup-about">
      <DText theme="Title-M-Regular">{{ company?.type }} {{ company?.name }}</DText>
      <DText theme="Body-M" class="d-popup-about__text">{{ section?.headerText }}</DText>

      <div
          class="menu__categories"
          :class="{'menu__categories--mobile': isMobile}"
      >
        <div
            class="menu__category"
            :class="{'menu__category--mobile': isMobile}"
            @click="selectedCategoryId = ''"
        >
          <div
              class="menu__category-title"
              :class="{
                'menu__category-title--selected': selectedCategoryId === '',
                'menu__category-title--mobile': isMobile
              }"
          >Все категории</div>
        </div>
        <div
            class="menu__category"
            :class="{'menu__category--mobile': isMobile}"
            v-for="category in catalog"
            @click="selectedCategoryId = category.id"
        >
          <div
              class="menu__category-title"
              :class="{
                'menu__category-title--selected': selectedCategoryId === category.id,
                'menu__category-title--mobile': isMobile
              }"
          >{{ category.name }}</div>
        </div>
      </div>

      <div
          class="menu__items"
          :class="{'menu__items--mobile': isMobile}"
      >
        <div
            class="menu__item-wrapper"
            :class="{'menu__item-wrapper--mobile': isMobile}"
            v-for="item in catalogItems">
          <div
              class="menu__item"
              :class="{'menu__item--mobile': isMobile}"
          >
            <div
                class="menu__item-image"
                :class="{'menu__item-image--mobile': isMobile}"
            >
              <img src="/public/food.png" />
            </div>
            <div
                class="menu__item-title"
                :class="{'menu__item-title--mobile': isMobile}"
            >{{ item.name }}</div>
            <div
                class="menu__item-price"
                :class="{'menu__item-price--mobile': isMobile}"
            >{{ item.price }} ₽</div>
            <div
                class="menu__item-actions"
                :class="{'menu__item-actions--mobile': isMobile}"
            >
              <div
                  v-if="!itemInBasket(item.id)"
                  class="menu__item-to-basket"
                  :class="{'menu__item-to-basket--mobile': isMobile}"
                  @click="addToBasket(item.id)"
              >в корзину</div>
              <div v-else>
                <div
                    class="menu__item-qty"
                    :class="{'menu__item-qty--mobile': isMobile}"
                >
                  <div @click="decQty(item.id)">-</div>
                  <div>{{ itemQty(item.id) }}</div>
                  <div @click="incQty(item.id)">+</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <DText theme="Body-L-Regular" class="d-popup-about__text">{{ section?.footerText }}</DText>
    </div>
  </DPopup>
</template>

<style lang="scss">
.basket {
  font-family: "Golos Text", "Trebuchet MS";
  position: fixed;
  bottom: 24px;
  right: 24px;
  width: 60px;
  height: 60px;
  background-image: url(/public/basket.png);
  background-size: 80%;
  background-position: 50%;
  background-repeat: no-repeat;
  box-sizing: border-box;
  padding-left: 25px;
  padding-top: 20px;
  cursor: pointer;

  span {
    display: block;
    width: 20px;
    text-align: center;
    color: #E73324;
    font-family: "Golos Text", "Trebuchet MS";
    font-size: 14px;
  }
}
.d-popup-about {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 50px;
  padding-bottom: 40px;
}

.d-popup-about__text {
  width: 70%;
}

.menu__categories {
  display: flex;
  gap: 14px;
  width: 80%;
  margin-bottom: 32px;
  flex-wrap: wrap;
  justify-content: flex-start;
  font-family: "Golos Text", "Trebuchet MS";

  &--mobile {
    justify-content: center;
  }
}
.menu__category {
  display: flex;
  flex-direction: column;
  gap: 12px;
  align-items: center;
  cursor: pointer;

  &--mobile {}
}
.menu__category-title {
  text-align: left;
  font-family: "Golos Text", "Trebuchet MS";
  text-transform: uppercase;
  font-size: 14px;
  padding: 8px 16px;
  border-radius: 16px;
  border: 1px solid transparent;
  background-color: rgba(0, 0, 0, .05);
  white-space: nowrap;
  box-sizing: border-box;

  &--mobile {
    font-size: 13px;
    padding: 6px 14px;
    border-radius: 14px;
  }

  &--selected {
    border: 1px solid #666666;
  }
}
.menu__items {
  display: flex;
  flex-wrap: wrap;
  gap: 36px 0;
  width: 80%;
  justify-content: space-between;
  font-family: "Golos Text", "Trebuchet MS";

  &--mobile {
    gap: 24px 0;
  }
}
.menu__item-wrapper {
  flex: 0 0 25%;
  max-width: 25%;
  padding: 0 12px;
  box-sizing: border-box;

  &--mobile {
    flex: 0 0 50%;
    max-width: 50%;
    padding: 0 10px;
  }
}
.menu__item {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  height: 100%;
  border-radius: 10px;
  padding: 0 0 16px 0;
  box-sizing: border-box;
  box-shadow: 0 15px 45px rgb(0 0 0 / 4%);
  transition: all .2s;

  &--mobile {
    border-radius: 8px;
    padding: 0 0 12px 0;
  }
}
.menu__item:hover {
  box-shadow: 0 15px 45px rgb(0 0 0 / 9%);
}
.menu__item-image {
  border-radius: 8px;
  width: 100%;
  height: 250px;
  min-height: 250px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 16px;

  &--mobile {
    height: 160px;
    min-height: 160px;
    margin-bottom: 12px;
  }

  img {
    width: 100%;
  }
}
.menu__item-title {
  font-family: "Golos Text", "Trebuchet MS";
  font-size: 14px;
  font-weight: bold;
  margin-bottom: 24px;
  box-sizing: border-box;
  padding: 0 12px;

  &--mobile {
    font-size: 13px;
    margin-bottom: 18px;
    padding: 0 10px;
  }
}
.menu__item-price {
  font-family: "Golos Text", "Trebuchet MS";
  font-size: 18px;
  margin-bottom: 24px;

  &--mobile {
    font-size: 16px;
    margin-bottom: 18px;
  }
}
.menu__item-actions {
  margin: auto 0 0 0;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;

  &--mobile {}
}
.menu__item-qty {
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
.menu__item-qty div {
  border-left: 1px solid rgba(0,0,0,0.1);
  padding: 4px 12px;
}
.menu__item-qty div:first-child {
  border: none;
  cursor: pointer;
  padding: 3px 8px 4px;
}
.menu__item-qty div:last-child {
  cursor: pointer;
  padding: 3px 8px 4px;
}

.menu__item-to-basket {
  font-family: "Golos Text", "Trebuchet MS";
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  background-color: rgb(196,22,28);
  border-radius: 16px;
  padding: 4px 12px;
  font-size: 14px;

  &--mobile {
    border-radius: 12px;
    padding: 4px 10px;
    font-size: 13px;
  }

  &--disabled {
    background-color: #9B9CA2;
    cursor: default;
  }
}
</style>
