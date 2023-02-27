<template>
  <PageComponent>
    <template v-slot:header>
      <div class="flex justify-between items-center">
        <h1 class="mx-3 text-3xl font-bold tracking-tight text-gray-900">Questionnaires</h1>

        <router-link :to="{name: 'QuestionnaireCreate'}" class="py-2 px-3 text-white bg-emerald-500 rounded-md hover:bg-emerald-600">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 -mt-1 inline-block">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
          </svg>
          Create Questionnaire
        </router-link>

      </div>
    </template>

    <div>
      <div v-if="loading" class="flex justify-center">loading...</div>
      <!--      Individual Questionnaire card -->
      <div v-else class="grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-3 animate-fade-in-down">
        <div v-if="!questionnaires.length" class="text-gray-600 mx-4">
          You don't have questionnaire created.
        </div>
        <QuestionnaireListItem
          v-for="questionnaire in questionnaires"
          :key="questionnaire.id"
          :questionnaire="questionnaire"
          @delete="deleteQuestionnaire(questionnaire)"
        />
      </div>
    </div>

  </PageComponent>
</template>

<script setup>
import PageComponent from "../components/PageComponent.vue";
import store from "../store/index.js";
import {computed} from "vue";
import {useRouter} from "vue-router";
import QuestionnaireListItem from "../components/QuestionnaireListItem.vue";

const router = useRouter();
const questionnaires = computed(() => store.state.questionnaires.data);
const loading = computed(() => store.state.questionnaires.loading);

store.dispatch('getQuestionnaires')

function deleteQuestionnaire(questionnaire) {
  if (confirm('are u confirm u want to delete?')) {
    store.dispatch('deleteQuestionnaire', questionnaire.id)
      .then(() => {
        store.dispatch('getQuestionnaires');
      })
  }
}
</script>

<style scoped>

</style>
