<template>
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
    <v-dialog v-model="showError" max-width="400">
      <v-card class="bg-background">
        <v-card-title class="text-h6">Erreur</v-card-title>
        <v-card-text>{{ errorMessage }}</v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn color="secondary" text @click="showError = false"
            >Fermer</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { useTheme } from "vuetify";
import { useDate } from "vuetify";

const emit = defineEmits(["weather-fetched"]);

const location = ref("");
const weather = ref(null);
const showError = ref(false);
const errorMessage = ref("");
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

const showModalError = (message) => {
  errorMessage.value = message;
  showError.value = true;
};

const getLocation = async () => {
  try {
    const res = await axios.get(
      `https://geocoding-api.open-meteo.com/v1/search?name=${location.value}&count=1`
    );
    const result = res.data.results?.[0];
    if (!result) {
      showModalError("Aucun résultat trouvé pour cette ville.");
      return null;
    }

    return {
      name: result.name,
      country: result.country,
      lat: result.latitude,
      lon: result.longitude,
    };
  } catch (error) {
    showModalError("Erreur lors de la géolocalisation. Veuillez réessayer.");
    return null;
  }
};

const getCurrentWeather = async () => {
  const loc = await getLocation();
  if (!loc) return;

  try {
    const res = await axios.get(
      `https://api.open-meteo.com/v1/forecast?latitude=${loc.lat}&longitude=${loc.lon}&current=temperature_2m,relative_humidity_2m,precipitation,weather_code,wind_speed_10m&timezone=auto&hourly=temperature_2m,weather_code&daily=weather_code,temperature_2m_max,temperature_2m_min`
    );

    weather.value = {
      city: loc.name,
      country: loc.country,
      ...res.data,
    };

    emit("weather-fetched", weather.value);
  } catch (error) {
    showModalError("Erreur lors de la récupération des données météo.");
  }
};
</script>
