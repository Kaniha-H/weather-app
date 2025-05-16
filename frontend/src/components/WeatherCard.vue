<template>
  <v-container>
    <v-row class="text-subtitle-2">
      <v-col>
        <v-row>
          <v-col cols="9">
            <v-row>
              <WeatherInfo v-if="data" :data="data" />
              <v-sheet
                v-else
                color="primary"
                height="240"
                width="100%"
                rounded="rounded"
                class="mr-1 mb-1 pt-12 text-center"
              >
                <p>Veuillez chercher une ville</p>
              </v-sheet>
            </v-row>
            <v-row>
              <WeatherGraph
                v-if="data && Object.keys(data).length"
                :weatherData="data"
              />
              <v-sheet
                v-else
                color="primary"
                height="247"
                width="100%"
                rounded="rounded"
                class="mr-1 pt-12 text-center"
              >
                <p>Aucunes données</p>
              </v-sheet>
            </v-row>
          </v-col>
          <v-col class="d-flex" cols="3">
            <v-row>
              <WeatherDaily
                v-if="data && Object.keys(data).length"
                :data="data"
              />
              <v-sheet
                v-else
                color="primary"
                height="100%"
                width="100%"
                rounded="rounded"
                class="pt-12 text-center"
              >
                <p>Aucunes données</p>
              </v-sheet>
            </v-row>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
    <v-row>
      <WeatherList :weather="data" />
    </v-row>
  </v-container>
</template>

<script setup>
import WeatherInfo from "./WeatherInfo.vue";
import WeatherGraph from "./WeatherGraph.vue";
import WeatherList from "./WeatherList.vue";
import WeatherDaily from "./WeatherDaily.vue";

const props = defineProps({
  data: Object,
});
</script>
