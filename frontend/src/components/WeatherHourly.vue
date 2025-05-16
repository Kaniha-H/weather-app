<template>
  <div class="d-flex overflow-y-auto pl-2 ma-3">
    <v-col
      class="mb-3 mx-2 bg-background rounded"
      v-for="(hour, index) in upcomingHours"
      :key="index"
    >
      <v-sheet class="ma-2" color="transparent"
        ><p>{{ Math.round(hour.temperature) }}°C</p></v-sheet
      >
      <v-sheet class="ma-2" color="transparent"
        ><v-icon size="24">{{ getWeatherIcon(hour.code) }}</v-icon></v-sheet
      >
      <v-sheet class="ma-2" color="transparent"
        ><p>{{ formatHour(hour.time) }}</p></v-sheet
      >
    </v-col>
  </div>
</template>

<script setup>
import { computed } from "vue";
import getWeatherIcon from "../utils/weatherCode";

const props = defineProps({
  data: Object,
});

const formatHour = (isoString) => {
  const date = new Date(isoString);
  return `${date.getHours()}:00`;
};

// garder tous les heures après l'heure actuelle(inclus)
const upcomingHours = computed(() => {
  const now = new Date();

  return props.data.hourly.time
    .map((time, i) => ({
      time,
      temperature: props.data.hourly.temperature_2m[i],
      code: props.data.hourly.weather_code[i],
    }))
    .filter(({ time }) => {
      const date = new Date(time);
      return (
        date.toDateString() === now.toDateString() &&
        date.getHours() >= now.getHours()
      );
    });
});
</script>
