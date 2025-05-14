<template>
  <v-sheet
    color="primary"
    rounded="rounded"
    height="100%"
    width="100%"
    class="pa-5"
  >
    <v-row>
      <h3 class="ma-4">Prévisions par heure</h3>
    </v-row>
    <v-row
      class="d-flex flex-row justify-space-between mb-4 bg-background rounded"
      v-for="(hour, index) in upcomingHours"
      :key="index"
    >
      <v-row class="d-flex align-center pl-2">
        <v-sheet class="ma-2" color="transparent"
          ><v-icon size="24">{{ getWeatherIcon(hour.code) }}</v-icon></v-sheet
        >
        <v-sheet class="ma-2" color="transparent"
          ><p>{{ hour.temperature }}°C</p></v-sheet
        >
      </v-row>
      <v-sheet class="ma-2" color="transparent"
        ><p>{{ formatHour(hour.time) }}</p></v-sheet
      >
    </v-row>
  </v-sheet>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  data: {
    type: Object,
    required: true,
  },
});

const getWeatherIcon = (code) => {
  if (code === 0) return "mdi mdi-weather-sunny";
  if (code === 1) return "mdi mdi-weather-partly-cloudy";
  if (code === 2) return "mdi mdi-weather-cloudy";
  if (code === 3) return "mdi mdi-weather-lightning";
  if ([45, 48].includes(code)) return "mdi mdi-weather-fog";
  if ([51, 53, 55, 56, 57].includes(code)) return "mdi mdi-weather-rainy";
  if ([61, 63, 65].includes(code)) return "mdi mdi-weather-pouring";
  if ([71, 73, 75, 77].includes(code)) return "mdi mdi-weather-snowy";
  if ([95, 96, 99].includes(code)) return "mdi mdi-weather-lightning-rainy";
  return "mdi mdi-weather-cloudy";
};

const formatHour = (isoString) => {
  const date = new Date(isoString);
  return `${date.getHours()}:00`;
};

// prend les 5 heures qui suivent l'heure actuelle
const upcomingHours = computed(() => {
  const now = new Date();
  return props.data.hourly.time
    .map((time, index) => ({
      time,
      temperature: props.data.hourly.temperature_2m[index],
      code: props.data.hourly.weather_code[index],
    }))
    .filter((entry) => new Date(entry.time) >= now)
    .slice(0, 5);
});
</script>
