<template>
  <v-container>
    <v-form @submit.prevent="addWeather">
      <v-text-field
        v-model="newWeather.city"
        label="Ville"
        required
      ></v-text-field>
      <v-text-field
        v-model="newWeather.temperature"
        label="Température"
        required
      ></v-text-field>
      <v-text-field
        v-model="newWeather.condition"
        label="Condition"
        required
      ></v-text-field>
      <v-btn type="submit" color="primary">Ajouter</v-btn>
    </v-form>
  </v-container>
</template>

<script setup>
import { ref } from "vue";
import axios from "@/services/axios";

const newWeather = ref({
  city: "",
  temperature: "",
  condition: "",
});

const addWeather = async () => {
  // Envoie les données du formulaire à l'API backend Symfony pour ajouter les nouvelles données
  await axios.post("/api/weather/new", newWeather.value);
  // Réinitialise le formulaire après ajout
  newWeather.value = { city: "", temperature: "", condition: "" };
};
</script>
