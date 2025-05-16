import { createApp } from "vue";
import App from "./App.vue";
import { createRouter, createWebHistory } from "vue-router";
import { routes } from "./routes.js";
import "vuetify/styles";
import vuetify from "./plugins/vuetify.js";

const router = createRouter({
  history: createWebHistory(),
  routes,
});

const app = createApp(App);
app.use(router);
app.use(vuetify);
app.mount("#app");
