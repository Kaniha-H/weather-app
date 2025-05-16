<template>
  <v-sheet
    color="primary"
    height="auto"
    width="100%"
    rounded="rounded"
    class="mr-1 pa-2 text-center"
  >
    <v-sparkline
      :auto-line-width="autoLineWidth"
      :fill="fill"
      :gradient="gradient"
      :gradient-direction="gradientDirection"
      :line-width="width"
      :model-value="value"
      :padding="padding"
      :smooth="radius || false"
      :stroke-linecap="lineCap"
      :type="type"
      auto-draw
      ><template v-slot:label="item">{{ Math.round(item.value) }}°</template>
    </v-sparkline>
  </v-sheet>
</template>

<script>
const gradients = [
  ["#222"],
  ["#42b3f4"],
  ["red", "orange", "yellow"],
  ["purple", "violet"],
  ["#00c6ff", "#F0F", "#FF0"],
  ["#f72047", "#ffd200", "#1feaea"],
];

export default {
  name: "Sparkline",
  props: {
    weatherData: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      width: 2,
      radius: 10,
      padding: 8,
      lineCap: "round",
      gradient: gradients[5],
      gradientDirection: "top",
      gradients,
      fill: false,
      type: "trend",
      autoLineWidth: false,
      value: [],
    };
  },
  watch: {
    weatherData: {
      handler(newData) {
        this.updateTemperatures(newData);
      },
      immediate: true,
      deep: true,
    },
  },
  methods: {
    updateTemperatures(data) {
      const now = new Date(data.current.time);

      const temps = data.hourly.time
        .map((time, i) => {
          const hourDate = new Date(time);
          return {
            time: hourDate,
            temperature: data.hourly.temperature_2m[i],
          };
        })
        .filter(({ time }) => {
          return (
            time.toDateString() === now.toDateString() &&
            time.getHours() >= now.getHours()
          );
        })
        .map(({ temperature }) => Math.round(temperature));

      this.value = temps;
    },
  },
};
</script>
