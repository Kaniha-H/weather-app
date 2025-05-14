<template>
  <v-sheet
    color="primary"
    rounded="rounded"
    class="mt-1"
    height="250"
    width="100%"
  >
    <v-row class="ma-2">
      <div class="d-flex">
        <v-col>
          <v-btn
            @click="openAddDialog"
            border="dashed md"
            color="background"
            rounded="rounded xl"
            class="mt-1"
            height="200"
            width="200"
            >+ Ajouter une ville</v-btn
          >
        </v-col>
        <v-col v-if="weatherData" v-for="weather in weatherData">
          <v-sheet
            border="solid md"
            color="background"
            rounded="rounded xl"
            class="position-relative mt-1"
            height="200"
            width="200"
          >
            <div class="text-center ma-2">
              <v-icon size="40">{{ getWeatherIcon(weather.condition) }}</v-icon>
              <v-row
                class="d-flex flex-column justify-space-around align-center ma-2"
              >
                <div class="my-3">
                  <h3>{{ weather.city }}</h3>
                  <span style="font-size: 12px">{{ weather.country }}</span>
                </div>
                <div class="d-flex align-baseline">
                  <h2>{{ weather.temperature }}</h2>
                  <p>°C</p>
                </div>
              </v-row>
            </div>
            <v-btn
              @click="editWeather(weather)"
              class="position-absolute bottom-0 right-0"
              rounded="rounded pill"
              border="none"
              variant="outlined"
            >
              <v-icon size="20">mdi mdi-pencil-outline</v-icon>
            </v-btn>
            <v-btn
              @click="deleteWeather(weather.id)"
              class="position-absolute bottom-0 left-0"
              rounded="rounded pill"
              border="none"
              variant="outlined"
            >
              <v-icon size="20">mdi mdi-delete-outline</v-icon>
            </v-btn>
          </v-sheet>
        </v-col>
      </div>
    </v-row>
  </v-sheet>
  <v-dialog v-model="showAddDialog" max-width="600">
    <v-card>
      <v-card-title>Ajouter une ville</v-card-title>
      <v-card-text>
        <WeatherForm
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
        <WeatherForm
          :weather="editedWeather"
          button-label="Enregistrer"
          button-color="blue"
          @submit="updateWeather"
        />
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import WeatherForm from "./WeatherForm.vue";
import getWeatherIcon from "../utils/weatherCode";

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

onMounted(async () => {
  const res = await axios.get("https://127.0.0.1:8000/api/weather/show");
  weatherData.value = res.data;
});
const openAddDialog = () => {
  newWeather.value = {
    city: "",
    country: "",
    temperature: "",
    condition: "",
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
