<template>
  <PageComponent title="Responses">
    <div v-if="loading" class="flex justify-center">loading...</div>
    <div v-else class="overflow-x-auto rounded-lg border border-gray-200">
      <table class="min-w-full divide-y-2 divide-gray-200 text-sm animate-fade-in-down">
        <thead>
        <tr>
          <th class="whitespace-nowrap pl-10 px-4 py-2 text-left font-medium text-gray-900">Name</th>
          <th class="whitespace-nowrap px-4 py-2 text-left font-medium text-gray-900">Email</th>
          <th class="whitespace-nowrap px-4 py-2 text-left font-medium text-gray-900">Marks</th>
        </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
        <tr v-for="response of data.responses" :key="response.id">
          <td class="whitespace-nowrap pl-10 px-2 py-2 text-gray-700">{{ response.name }}</td>
          <td class="whitespace-nowrap px-2 py-2 text-gray-700">{{ response.email }}</td>
          <td class="whitespace-nowrap px-6 py-2 text-gray-700">{{ response.total_obtained_marks }}/{{ data.questionnaire[0].total_marks }}</td>
          <td class="whitespace-nowrap py-2 text-gray-700">
            <router-link :to="{name: 'Response', params: { id: response.id } }" class="inline-block rounded bg-indigo-600 px-4  py-2 text-xs font-medium text-white hover:bg-indigo-700">
              View
            </router-link>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </PageComponent>
</template>
<script setup>
import PageComponent from "../components/PageComponent.vue";
import {useRoute} from "vue-router";
import store from "../store/index.js";
import {computed} from "vue";

const route = useRoute();

const data = computed(() => store.state.responses.data);
const loading = computed(() => store.state.responses.loading);

store.dispatch('getResponses', route.params.id);

</script>
