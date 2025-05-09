<template>
  <v-container>
    <v-card>
      <v-card-title class="mt-5">Gestion des villes</v-card-title>
      <v-card-text v-if="weatherData">
        <v-data-table :items="weatherData" :headers="headers" item-key="id">
          <template v-slot:item.actions="{ item }">
            <v-btn @click="editWeather(item)" color="blue">Éditer</v-btn>
            <v-btn @click="deleteWeather(item.id)" color="red">Supprimer</v-btn>
          </template>
        </v-data-table>
        <v-btn color="green" @click="openAddDialog">Ajouter une ville</v-btn>
      </v-card-text>
    </v-card>
    <v-dialog v-model="showAddDialog" max-width="600">
      <v-card>
        <v-card-title>Ajouter une ville</v-card-title>
        <v-card-text>
          <WeatherCrud
            :weather="newWeather"
            button-label="Ajouter"
            button-color="green"
            @submit="addWeather"
          />
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-dialog v-model="showEditDialog" max-width="600">
      <v-card>
        <v-card-title>Éditer la météo</v-card-title>
        <v-card-text>
          <WeatherCrud
            :weather="editedWeather"
            button-label="Enregistrer"
            button-color="blue"
            @submit="updateWeather"
          />
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-container>
</template>
<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import WeatherCrud from "./WeatherForm.vue";

const weatherData = ref([]);
const editedWeather = ref({});
const showEditDialog = ref(false);
const newWeather = ref({
  city: "",
  country: "",
  lat: "",
  lon: "",
  temperature: "",
  humidity: "",
});

const showAddDialog = ref(false);

// TODO : ne fonctionne pas même avec headers.value
const headers = [
  { text: "Ville", value: "city" },
  { text: "Pays", value: "country" },
  { text: "Latitude", value: "lat" },
  { text: "Longitude", value: "lon" },
  { text: "Température", value: "temperature" },
  { text: "Humidité", value: "humidity" },
  { text: "Actions", value: "actions", sortable: false },
];

onMounted(async () => {
  const res = await axios.get("https://127.0.0.1:8000/api/weather/show");
  weatherData.value = res.data;
});
const openAddDialog = () => {
  newWeather.value = {
    city: "",
    country: "",
    lat: "",
    lon: "",
    temperature: "",
    humidity: "",
  };
  showAddDialog.value = true;
};

const addWeather = async () => {
  await axios.post("https://127.0.0.1:8000/api/weather/new", newWeather.value);

  showAddDialog.value = false;

  const res = await axios.get("https://127.0.0.1:8000/api/weather/show");
  weatherData.value = res.data;
};

const editWeather = (item) => {
  editedWeather.value = { ...item };
  showEditDialog.value = true;
};

const updateWeather = async () => {
  await axios.put(
    `https://127.0.0.1:8000/api/weather/update/${editedWeather.value.id}`,
    editedWeather.value
  );

  showEditDialog.value = false;

  const res = await axios.get("https://127.0.0.1:8000/api/weather/show");
  weatherData.value = res.data;
};

const deleteWeather = async (id) => {
  await axios.delete(`https://127.0.0.1:8000/api/weather/${id}`);

  const res = await axios.get("https://127.0.0.1:8000/api/weather/show");
  weatherData.value = res.data;
};
</script>
