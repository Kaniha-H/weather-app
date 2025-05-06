<template>
  <v-container>
    <v-card>
      <v-card-title>Tableau de Gestion des Météos</v-card-title>
      <v-card-text v-if="weatherData">
        <v-data-table :items="weatherData" :headers="headers" item-key="id">
          <template v-slot:item.actions="{ item }">
            <v-btn @click="editWeather(item)" color="blue">Éditer</v-btn>
            <v-btn @click="deleteWeather(item.id)" color="red">Supprimer</v-btn>
          </template>
        </v-data-table>
      </v-card-text>
    </v-card>
  </v-container>

  <script setup>
    import { ref, onMounted } from "vue";
    import axios from "axios";

    const weatherData = ref([]);

    // Définir les en-têtes du tableau
    const headers = [
      { text: "Ville", align: "start", key: "city" },
      { text: "Température", value: "temperature" },
      { text: "Condition", value: "condition" },
      { text: "Actions", value: "actions", sortable: false },
    ];

    onMounted(async () => {
      // Récupérer les données météo depuis l'API
      const res = await axios.get("/api/weather/show");
      weatherData.value = res.data;
    });

    const editWeather = (item) => {
      // Ici, on pourrait ouvrir un modal pour éditer les données météo
      console.log("Éditer", item);
    };

    const deleteWeather = async (id) => {
      // Supprime la donnée météo de l'API backend
      await axios.delete(`/api/weather/${id}`);
      // Réactualiser la liste après la suppression
      const res = await axios.get("/api/weather");
      weatherData.value = res.data;
    };
  </script>
</template>
