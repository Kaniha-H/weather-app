import Home from "./components/Home.vue";
import WeatherCard from "./components/WeatherCard.vue";

export const routes = [
  { path: "/", component: Home },
  { path: "/current-weather", component: WeatherCard },
];
