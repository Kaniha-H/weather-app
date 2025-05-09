<template>
  <v-card class="mx-auto" max-width="368">
    <v-card-item :title="data.location">
      <template v-slot:subtitle> </template>
    </v-card-item>

    <v-card-text class="py-0">
      <v-row align="center" no-gutters>
        <v-col class="text-h3" cols="6">
          {{ data.current.temperature_2m }} &deg;C
        </v-col>

        <v-col class="text-right" cols="6">
          <v-icon color="white" icon="mdi-weather-hurricane" size="88"></v-icon>
        </v-col>
      </v-row>
    </v-card-text>

    <div class="d-flex py-3 justify-space-between">
      <v-list-item density="compact" prepend-icon="mdi-weather-windy">
        <v-list-item-subtitle>
          {{ data.current.wind_speed_10m }} km/h
        </v-list-item-subtitle>
      </v-list-item>

      <v-list-item
        density="compact"
        :prepend-icon="getWeatherIcon(data.current.weather_code)"
      >
        <v-list-item-subtitle
          >{{ data.current.relative_humidity_2m }}%</v-list-item-subtitle
        >
      </v-list-item>
    </div>

    <v-divider></v-divider>

    <v-card-actions>
      <p class="ml-2">{{ getWeatherName(data.current.weather_code) }}</p>
    </v-card-actions>
  </v-card>
</template>

<script setup>
import weather_codes from "../utils/weatherCode";

const props = defineProps({
  data: Object,
});

const getWeatherIcon = (code) => {
  return weather_codes[code].icon;
};

const getWeatherName = (code) => {
  return weather_codes[code].name;
};
</script>
