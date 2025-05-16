<template>
  <SearchBar @weather-fetched="handleWeather" />
  <WeatherCard :data="weather" />
</template>

<script setup>
import { ref } from "vue";
import WeatherCard from "../components/WeatherCard.vue";
import SearchBar from "../components/SearchBar.vue";

const weather = ref(null);

const handleWeather = (data) => {
  weather.value = data;
};
</script>
