import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import "@mdi/font/css/materialdesignicons.css";

export default createVuetify({
  components,
  directives,
  icons: {
    defaultSet: "mdi",
  },
  theme: {
    themes: {
      light: {
        colors: {
          background: "#FFF7F1",
          surface: "#BED1CF",
          primary: "#FFE4C9",
          secondary: "#E78895",
          error: "#B00020",
          info: "#2196F3",
          success: "#4CAF50",
          warning: "#FB8C00",
        },
      },
      dark: {
        colors: {
          background: "#27374D",
          surface: "#DDE6ED",
          primary: "#526D82",
          secondary: "#9DB2BF",
          error: "#B00020",
          info: "#2196F3",
          success: "#4CAF50",
          warning: "#FB8C00",
        },
      },
    },
  },
  locale: {
    locale: "fr",
  },
  date: {
    locale: {
      fr: "fr-FR",
    },
  },
});
