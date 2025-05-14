<template>
  <v-container height="100vh">
    <v-container>
      <v-form @submit.prevent="getCurrentWeather">
        <v-row class="d-flex align-center">
          <v-col cols="9">
            <p>{{ formatted }}</p>
          </v-col>
          <v-col cols="3">
            <v-row class="d-flex align-center ga-2">
              <v-text-field
                v-model="location"
                rounded="rounded"
                variant="solo"
                single-line
                prepend-inner-icon="mdi-magnify"
                label="chercher une ville"
                density="compact"
                hide-details
                max-width="275"
              ></v-text-field>
              <v-btn @click="toggleTheme" rounded="rounded"
                ><i :class="mdi()"></i
              ></v-btn>
            </v-row>
          </v-col>
        </v-row>
      </v-form>
    </v-container>
    <WeatherCard :data="weather" />
  </v-container>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { useTheme } from "vuetify";
import { useDate } from "vuetify";
import WeatherCard from "../components/WeatherCard.vue";

const location = ref("");
const weather = ref(null);
const theme = useTheme();
const date = useDate();

const formatted = date.format(new Date(), "fullDateWithWeekday");
const mdi = () => {
  return theme.global.current.value.dark
    ? "mdi mdi-moon-waning-crescent"
    : "mdi mdi-white-balance-sunny";
};

const toggleTheme = () => {
  theme.global.name.value = theme.global.current.value.dark ? "light" : "dark";
};

const getLocation = async () => {
  try {
    const res = await axios.get(
      `https://geocoding-api.open-meteo.com/v1/search?name=${location.value}&count=1`
    );
    const result = res.data.results?.[0];
    if (!result) {
      console.warn("Aucun résultat trouvé.");
      return null;
    }

    return {
      name: result.name,
      country: result.country,
      lat: result.latitude,
      lon: result.longitude,
    };
  } catch (error) {
    // TODO : gérer les erreurs
    console.error("Erreur lors de la géolocalisation :", error);
    return null;
  }
};

const getCurrentWeather = async () => {
  const loc = await getLocation();
  if (!loc) return;

  try {
    const res = await axios.get(
      `https://api.open-meteo.com/v1/forecast?latitude=${loc.lat}&longitude=${loc.lon}&current=temperature_2m,relative_humidity_2m,precipitation,weather_code,wind_speed_10m&hourly=temperature_2m,weather_code`
    );

    weather.value = {
      city: loc.name,
      country: loc.country,
      ...res.data,
    };

    return weather.value;
  } catch (error) {
    // TODO : gérer les erreurs
    console.error("Erreur lors de la requête météo :", error);
  }
};
</script>
