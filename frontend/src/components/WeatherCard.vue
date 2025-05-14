<template>
  <v-container>
    <v-row class="flex-child text-subtitle-2">
      <v-col class="d-flex" cols="12">
        <v-row>
          <v-col cols="9">
            <v-row>
              <WeatherInfo v-if="data" :data="data" />
              <v-sheet
                v-else
                color="primary"
                height="150"
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
                :weather="props.data"
              />
              <v-sheet
                v-else
                color="primary"
                height="200"
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
              <WeatherHourly
                v-if="data && Object.keys(data).length"
                :data="props.data"
              />
              <v-sheet
                v-else
                color="primary"
                height="100%"
                width="100%"
                rounded="rounded"
                class="mr-1 pt-12 text-center"
              >
                <p>Aucunes données</p>
              </v-sheet>
            </v-row>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
    <v-row>
      <WeatherList />
      <!--<v-sheet
        color="primary"
        rounded="rounded"
        class="mt-1"
        height="250"
        width="100%"
      >
        <p></p>
      </v-sheet>-->
    </v-row>
  </v-container>
</template>

<script setup>
import WeatherInfo from "./WeatherInfo.vue";
import WeatherGraph from "./WeatherGraph.vue";
import WeatherHourly from "./WeatherHourly.vue";
import WeatherList from "./WeatherList.vue";

const props = defineProps({
  data: Object,
});
</script>
