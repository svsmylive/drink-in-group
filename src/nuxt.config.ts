import axios from 'axios';

const urlBase = 'https://drink-in-group.ru';
const apiBase = `${urlBase}/api`;

export default defineNuxtConfig({
  ssr: true,
  runtimeConfig: {
    public: {
      urlBase,
      apiBase,
    }
  },
  app: {
    head: {
      charset: 'utf-8',
      viewport: 'width=device-width, initial-scale=1',
      htmlAttrs: {
        lang: 'ru'
      }
    }
  },
  hooks: {
    async 'nitro:config'(nitroConfig) {
      const response = await axios.get(`${apiBase}/institutions`);
      const slugs = response?.data?.data.filter((item) => item?.url != undefined).map((item) => `/${item?.url}`);
      nitroConfig.prerender?.routes?.push(...slugs);
    },
  },
  modules: [
    '@vueuse/nuxt',
    'nuxt-icons',
    'nuxt-swiper',
    [
      '@nuxtjs/google-fonts', {
        families: {
          'Golos+Text': [400, 500],
        },
        display: 'block',
        prefetch: true,
        preconnect: true,
        preload: true,
        download: true,
      }
    ],
  ],
  vue: {
    compilerOptions: {
      isCustomElement: (tag) => tag.startsWith('swiper-')
    },
  },
  vite: {
    css: {
      preprocessorOptions: {
        scss: {
          additionalData: '@use "@/assets/styles/main.scss" as *;',
        }
      }
    }
  },
  devtools: { enabled: true }
})
