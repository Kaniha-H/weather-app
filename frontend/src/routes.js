import Home from "./view/Home.vue";
import WeatherList from "./components/WeatherList.vue";

export const routes = [
  { path: "/", component: Home },
  { path: "/all", component: WeatherList },
];
