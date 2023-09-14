// plugins/vuetify.js
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";

const portOnlineLightTheme = {
  dark: false,
  colors: {
    background: "#2e67b1",
    surface: "#285795",
    primary: "#2e67b1",
    "primary-darken-1": "#3700B3",
    secondary: "#03DAC6",
    "secondary-darken-1": "#018786",
    error: "#B00020",
    info: "#ffffff",
    success: "#4CAF50",
    warning: "#FB8C00",
  },
};

export default defineNuxtPlugin((nuxtApp) => {
  const vuetify = createVuetify({
    theme: {
      defaultTheme: "portOnlineLightTheme",
      themes: {
        portOnlineLightTheme,
      },
    },
    ssr: true,
    components,
    directives,
  });
  nuxtApp.vueApp.use(vuetify);
});
