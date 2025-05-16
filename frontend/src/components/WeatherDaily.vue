<template>
  <v-sheet
    color="primary"
    rounded="rounded"
    height="100%"
    width="100%"
    class="pa-5"
  >
    <v-row>
      <h3 class="ma-6">Prévisions de la semaine</h3>
    </v-row>
    <div style="max-height: 350px; overflow-y: auto">
      <v-row
        class="my-3 pa-2 mx-1 bg-background rounded"
        v-for="(day, index) in upcomingDays"
        :key="index"
      >
        <v-row class="d-flex align-center pl-2">
          <v-sheet class="pa-2" color="transparent"
            ><v-icon size="24">{{ getWeatherIcon(day.code) }}</v-icon></v-sheet
          >
          <v-sheet class="pa-2 d-flex align-baseline" color="transparent">
            <p style="font-size: 1.2em">
              {{ Math.round(day.temperature_max) }}°C /&nbsp;
            </p>
            <span>{{ Math.round(day.temperature_min) }}°C</span>
          </v-sheet>
        </v-row>
        <v-sheet class="pa-2" color="transparent"
          ><p>{{ formatDate(day.time) }}</p></v-sheet
        >
      </v-row>
    </div>
  </v-sheet>
</template>

<script setup>
import { computed } from "vue";
import getWeatherIcon from "../utils/weatherCode";

const props = defineProps({
  data: Object,
});

const formatDate = (isoString) => {
  const date = new Date(isoString);
  return date.toLocaleDateString("fr-FR", {
    weekday: "short",
    day: "numeric",
    month: "short",
  });
};

const upcomingDays = computed(() => {
  return props.data.daily.time.map((time, i) => ({
    time,
    temperature_max: props.data.daily.temperature_2m_max[i],
    temperature_min: props.data.daily.temperature_2m_min[i],
    code: props.data.daily.weather_code[i],
  }));
});
</script>
