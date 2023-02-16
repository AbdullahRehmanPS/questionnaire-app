<template>
  <PageComponent title="Admin">
    <div v-if="loading" class="flex justify-center">loading...</div>
    <!--  Cards Star  -->
    <div
      v-else
      class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 text-gray-700"
    >
      <!--   In Top Middle   -->
      <div
        class="bg-white shadow-md p-3 text-center flex flex-col animate-fade-in-down order-1 lg:order-2"
        style="animation-delay: 0.1s"
      >
        <h3 class="text-2xl font-semibold">Total Questionnaire</h3>
        <div
          v-if="!data.totalQuestionnaires"
          class="text-8xl font-semibold flex-1 flex items-center justify-center"
        >0
        </div>
        <div
          v-else
          class="text-8xl font-semibold flex-1 flex items-center justify-center"
        >
          {{ data.totalQuestionnaires }}
        </div>
      </div>
      <!--   In Down Middle   -->
      <div
        class="bg-white shadow-md p-3 text-center flex flex-col order-2 lg:order-4 animate-fade-in-down"
        style="animation-delay: 0.2s"
      >
        <h3 class="text-2xl font-semibold">Total Answers</h3>
        <div
          v-if="!data.totalAnswers"
          class="text-8xl font-semibold flex-1 flex items-center justify-center"
        >0
        </div>
        <div
          v-else
          class="text-8xl font-semibold flex-1 flex items-center justify-center"
        >
          {{ data.totalAnswers }}
        </div>
      </div>
      <!--  On Left    -->
      <div
        class="row-span-2 animate-fade-in-down order-3 lg:order-1 bg-white shadow-md p-4"
        style="animation-delay: 0.3s"
      >
        <h3 class="text-2xl font-semibold">Latest Questionnaire</h3>
        <h3 class="font-bold text-xl text-center mb-1">Title: {{ data.latestQuestionnaires.title }}</h3>
        <div class="my-2">
          <small class="mb-3 text-center">Description: {{ data.latestQuestionnaires.description }}</small>
        </div>
        <div class="flex justify-between text-sm mb-1">
          <div>Create Date:</div>
          <div>{{ data.latestQuestionnaires.created_at }}</div>
        </div>
        <div class="flex justify-between text-sm mb-1">
          <div>Questions:</div>
          <div>{{ data.latestQuestionnaires.questions }}</div>
        </div>
        <div class="flex justify-between text-sm mb-3">
          <div>Answers:</div>
          <div>{{ data.latestQuestionnaires.answers }}</div>
        </div>
        <div class="flex justify-between">
          <router-link
            :to="{ name: 'QuestionnaireView', params: { id: data } }"
            class="flex py-2 px-4 border border-transparent text-sm rounded-md
            text-blue-700 hover:bg-blue-700 hover:text-white transition-colors
            focus:ring-2 focus:ring-offset-2 focus:ring-blue-700"
          >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0
                    112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897
                    1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0
                    0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25
                    2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
            </svg>
            Edit Questionnaire
          </router-link>

          <button
            class="flex py-2 px-4 border border-transparent text-sm rounded-md
            text-blue-700 hover:bg-blue-700 hover:text-white transition-colors
            focus:ring-2 focus:ring-offset-2 focus:ring-blue-700"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5 mr-2"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
              <path
                fill-rule="evenodd"
                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                clip-rule="evenodd"
              />
            </svg>
            View Answers
          </button>
        </div>
      </div>
      <!--   On Right   -->
      <div
        class="bg-white shadow-md p-3 row-span-2 order-4 lg:order-3 animate-fade-in-down"
        style="animation-delay: 0.4s"
      >
        <div class="flex justify-between items-center mb-3 px-2">
          <h3 class="text-2xl font-semibold">Latest Answers</h3>
          <a
            href="javascript:void(0)"
            class="text-sm text-blue-500 hover:decoration-blue-500"
          >view all
          </a>
        </div>
        <a
          href="#"
          v-for="answer of data.latestAnswers"
          :key="answer.id"
          class="block p-2 hover:bg-gray-100/90"
        >
          <div class="font-semibold">{{ answer.questionnaire.title }}</div>
          <small>
            Answered at:
            <i class="font-semibold">{{ answer.end_date}}</i>
          </small>
        </a>
      </div>
      <!--  Cards End    -->
    </div>

  </PageComponent>

</template>

<script setup>
import PageComponent from "../../components/PageComponent.vue";
import {useStore} from "vuex";
import {computed} from "vue";

const store = useStore();
const loading = computed(() => store.state.dashboard.loading);
const data = computed(() => store.state.dashboard.data);

store.dispatch('getDashboardData')

</script>
