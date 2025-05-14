<template>
  <v-sheet color="primary" rounded="rounded" width="100%" class="mr-1 mb-1">
    <v-row class="px-2 py-5">
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
              <p class="text-body-2 mb-4">{{ data.country }}</p>
            </div>
          </v-col>
          <v-col
            cols="3"
            class="d-flex align-center justify-center text-center"
          >
            <div>
              <div class="text-h5 font-weight-medium mb-2">
                {{ data.current.temperature_2m }} &deg;C
              </div>
              <p class="text-body-2 mb-4">Température</p>
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
              <p class="text-body-2 mb-4">Humidité</p>
            </div>
          </v-col>
          <v-col
            cols="3"
            class="d-flex align-center justify-center text-center"
          >
            <div>
              <div class="text-h5 font-weight-medium mb-2">
                {{ data.current.wind_speed_10m }} km/h
              </div>
              <p class="text-body-2 mb-4">Vitesse du vent</p>
            </div>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </v-sheet>
</template>

<script setup>
const props = defineProps({
  data: Object,
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
</script>
