// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  runtimeConfig: {
    public: {
      urlBase: 'https://drink-in-group.ru',
      apiBase: 'https://drink-in-group.ru/api',
    }
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
