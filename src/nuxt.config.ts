import axios from 'axios';
// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  ssr: true,
  runtimeConfig: {
    public: {
      urlBase: 'https://drink-in-group.ru',
      apiBase: 'https://drink-in-group.ru/api',
    }
  },
  hooks: {
    async 'nitro:config'(nitroConfig) {
      const response = await axios.get('https://drink-in-group.ru/api/institutions');
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
  // devtools: { enabled: true }
})
