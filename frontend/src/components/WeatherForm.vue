<template>
  <v-form @submit.prevent="$emit('submit')" ref="formRef" v-model="formValid">
    <v-text-field
      v-model="weather.city"
      label="Ville"
      :rules="[rules.required]"
    />
    <v-text-field
      v-model="weather.country"
      label="Pays"
      :rules="[rules.required]"
    />
    <v-text-field
      v-model="weather.temperature"
      label="Température"
      :rules="[rules.required, rules.numeric]"
    />
    <v-text-field
      v-model="weather.condition"
      label="Condition"
      :rules="[rules.required, rules.numeric]"
    />
    <v-btn :color="buttonColor" @click="submitIfValid">
      {{ buttonLabel }}
    </v-btn>
  </v-form>
</template>

<script setup>
import { ref } from "vue";

const props = defineProps({
  weather: Object,
  buttonLabel: String,
  buttonColor: {
    type: String,
    default: "primary",
  },
});
const emit = defineEmits(["submit"]);

const formValid = ref(true);
const formRef = ref(null);

const rules = {
  required: (v) => !!v || "Ce champ est requis",
  numeric: (v) => !v || !isNaN(parseFloat(v)) || "Ce champ doit être un nombre",
};

const submitIfValid = () => {
  formRef.value.validate().then((valid) => {
    if (valid) {
      emit("submit");
    }
  });
};
</script>
