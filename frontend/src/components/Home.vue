<template>
  <v-form @submit.prevent="getCurrentWeather">
    <v-sheet class="mx-auto mt-5 text-center" width="600">
      <v-card title="Quel temps fait-il aujourd'hui ?" flat>
        <template v-slot:text>
          <v-text-field
            v-model="location"
            label="Rechercher une ville"
            class="mx-auto"
            width="500"
            required
          ></v-text-field>
          <v-btn type="submit" color="grey-lighten-5">Rechercher</v-btn>
        </template>
      </v-card>
    </v-sheet>
  </v-form>
  <div v-if="weather" class="mt-5">
    <WeatherCard :data="weather" />
    <!-- TODO faire un bouton ajout (utiliser un gestionnaire d'état Pinia???)-->
  </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import WeatherCard from "./WeatherCard.vue";

const location = ref("");
const weather = ref(null);

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
      `https://api.open-meteo.com/v1/forecast?latitude=${loc.lat}&longitude=${loc.lon}&current=temperature_2m,relative_humidity_2m,precipitation,weather_code,wind_speed_10m`
    );

    weather.value = {
      location: `${loc.name}, ${loc.country}`,
      ...res.data,
    };

    return weather.value;
  } catch (error) {
    // TODO : gérer les erreurs
    console.error("Erreur lors de la requête météo :", error);
  }
};
</script>
