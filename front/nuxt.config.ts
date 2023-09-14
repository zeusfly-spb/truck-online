import vuetify from 'vite-plugin-vuetify'

// @ts-ignore
export default defineNuxtConfig({
  app: {baseURL: '/dev'},
  devtools: {enabled: true, componentInspector: false},
  runtimeConfig: {
    public: {
      apiBase: process.env.NUXT_PUBLIC_API_BASE || 'http://localhost/api'
    }
  },
  css: ["vuetify/styles", "@/assets/main.scss", "vuetify/lib/styles/main.sass",
    "@mdi/font/css/materialdesignicons.min.css"],
  buildModules: [
    ['@nuxtjs/vuetify', {iconfont: 'mdi'}],
    '@nuxtjs/dotenv'
  ],
  build: {transpile: ['vuetify']},
  vite: {ssr: {noExternal: ['vuetify']}},
  modules: [
    '@pinia/nuxt',
    'nuxt-delay-hydration',
    'nuxt-icon',
    async (options, nuxt) => {
      nuxt.hooks.hook('vite:extendConfig', (config) =>
        // @ts-ignore
        config.plugins?.push(
          vuetify({
            styles: {configFile: 'assets/variables.scss'},
          })
        )
      );
    },
  ],
  delayHydration: {
    mode: 'init',
    // enables nuxt-delay-hydration in dev mode for testing
    debug: process.env.NODE_ENV === 'development'
  },
  sourcemap: {
    server: false,
    client: false,
  },
  vuetify: {
    vuetifyOptions: {
      // @TODO: list all vuetify options
    },
    moduleOptions: {
      treeshaking: true,
      useIconCDN: true,
      styles: true,
      autoImport: true,
      useVuetifyLabs: true,
    }
  },
})
