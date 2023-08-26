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
    '@nuxtjs/vuetify',
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
        config.plugins.push(
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
  // auth: {
  //   globalAppMiddleware: true,
  //   baseURL: process.env.NUXT_PUBLIC_API_BASE,
  //   provider: {
  //     type: 'local',
  //     endpoints: {
  //       signIn: {path: '/auth/login', method: 'post'},
  //       signUp: {path: '/auth/register', method: 'post'},
  //       getSession: {path: '/details', method: 'get'}
  //     },
  //     pages: {
  //       login: '/login'
  //     },
  //     token: {
  //       signInResponseTokenPointer: '/accessToken'
  //     },
  //     sessionDataType: {}
  //   },
  //   enableSessionRefreshPeriodically: 5000,
  //   enableSessionRefreshOnWindowFocus: true,
  //   globalMiddlewareOptions: {
  //     allow404WithoutAuth: true, // Defines if the 404 page will be accessible while unauthenticated
  //     addDefaultCallbackUrl: '/' // Where authenticated user will be redirected to by default
  //   }
  // },
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
