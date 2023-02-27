<template>
  <div v-if="loading" class="flex justify-center">loading...</div>
  <div v-else class="overflow-hidden bg-white shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
      <div>
        <h3 class="text-base font-semibold leading-6 text-gray-900">{{data.questionnaire[0].title}}</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">{{data.questionnaire[0].description}}</p>
      </div>
      <div>
        <button class="py-2 px-2 text-white bg-emerald-500 rounded-md hover:bg-emerald-600">
          mark/marks
        </button>
      </div>
    </div>

    <div class="border-t border-gray-200">
      <dl>
        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-medium text-gray-500">Full name</dt>
          <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{data.response[0].name}}</dd>
        </div>
        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-medium text-gray-500">Email address</dt>
          <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{data.response[0].email}}</dd>
        </div>
      </dl>
    </div>
    <div class="border-t border-gray-200">

    </div>
  </div>
</template>

<script setup>
import { useRoute } from "vue-router";
import store from "../store/index.js";
import {computed} from "vue";

const route = useRoute();
const data = computed(() => store.state.response.data);
const loading = computed(() => store.state.response.loading);

store
  .dispatch('getResponse', route.params.id)
  // .then((response) => {
  //   //console.log(response)
  // })
</script>
