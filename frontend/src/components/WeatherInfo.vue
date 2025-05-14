<template>
  <v-sheet color="primary" rounded="rounded" width="100%" class="mr-1 mb-1">
    <v-row class="ma-2 px-2 py-5">
      <v-col cols="2" class="d-flex align-center justify-center text-center">
        <v-icon size="40">{{
          getWeatherIcon(data.current.weather_code)
        }}</v-icon>
      </v-col>
      <v-col cols="10">
        <v-row>
          <v-col
            cols="3"
            class="d-flex align-center justify-center text-center"
          >
            <div>
              <div class="text-h5 font-weight-medium mb-2">
                {{ data.city }}
              </div>
              <p class="text-body-2">{{ data.country }}</p>
            </div>
          </v-col>
          <v-col
            cols="3"
            class="d-flex align-center justify-center text-center"
          >
            <div>
              <div class="text-h5 font-weight-medium mb-2">
                {{ Math.round(data.current.temperature_2m) }} &deg;C
              </div>
              <p class="text-body-2">Température</p>
            </div>
          </v-col>
          <v-col
            cols="3"
            class="d-flex align-center justify-center text-center"
          >
            <div>
              <div class="text-h5 font-weight-medium mb-2">
                {{ data.current.relative_humidity_2m }}%
              </div>
              <p class="text-body-2">Humidité</p>
            </div>
          </v-col>
          <v-col
            cols="3"
            class="d-flex align-center justify-center text-center"
          >
            <div>
              <div class="text-h5 font-weight-medium mb-2">
                {{ Math.round(data.current.wind_speed_10m) }} km/h
              </div>
              <p class="text-body-2">Vitesse du vent</p>
            </div>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </v-sheet>
</template>

<script setup>
import getWeatherIcon from "../utils/weatherCode";

const props = defineProps({
  data: Object,
});
</script>
