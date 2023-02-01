<template>
  <PageComponent>
    <template v-slot:header>
      <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
          {{ model.id ? model.title : 'Create a Questionnaires' }}
        </h1>
      </div>
    </template>

    <form @submit.prevent="saveSurvey">
      <div class="shadow sm:rounded-md sm:overflow-hidden">
        <!--    SurveyFields -->
        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
          <!--     Image -->

          <!--     Title -->
          <div>
            <label for="title" class="block text-sm font-medium text-gray-700">
              Title
            </label>
            <input
              id="title"
              name="title"
              type="text"
              v-model="model.title"
              autocomplete="survey_title"
              class="mt-1 focus:ring-orange-500
                     focus:border-orange-500
                     block w-full shadow-sm
                     sm:text-sm border-gray-300
                     rounded-md"
            />
          </div>
          <!--     /Title -->

          <!--  Description  -->
          <div>
            <label for="about" class="block text-sm font-medium text-gray-700">
              Description
            </label>
            <div class="mt-1">
              <textarea
                id="description"
                name="description"
                rows="3"
                v-model="model.description"
                autocomplete="survey_description"
                placeholder="Describe your questionnaire"
                class="shadow-sm focus:ring-orange-500
                       focus:border-orange-500 mt-1
                       block w-full sm:text-sm border
                       border-gray-300 rounded-md"
              />
            </div>
          </div>
          <!--  /Description -->

        </div>
        <!--  /SurveyFields      -->


        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
          <h3 class="text-2xl font-semibold flex items-center justify-between">
            Questions
            <!--  Add new questions -->
            <button
              type="button"
              @click="addQuestion()"
              class="flex items-center text-sm py-1 px-4
                     rounded-sm text-white bg-gray-600
                     hover:bg-gray-700"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                  clip-rule="evenodd"
                />
              </svg>
              Add Question
            </button>
            <!--   /Add new questions -->
          </h3>

          <div v-if="!model.questions.length" class="text-center text-gray-600">
            You don't have questions created
          </div>

          <div v-for="(question,index) in model.questions" :key="question.id">
            <QuestionEditor
              :question="question"
              :index="index"
              @change="questionChange"
              @addQuestion="addQuestion"
              @deleteQuestion="deleteQuestion"
            />
          </div>

        </div>

        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
          <button
            type="submit"
            class="w-5 h-5 mr-2 bg"
          >Save
          </button>
        </div>
      </div>
    </form>

  </PageComponent>
</template>

<script setup>
import PageComponent from "../components/PageComponent.vue";
import QuestionEditor from "../components/admin/QuestionEditor.vue"
import {ref} from 'vue';
import { uuid } from 'vue-uuid';
import store from "../store/index.js";
import {useRouter, useRoute} from "vue-router";

const route = useRoute();
const router = useRouter();

let model = ref({
  title: "",
  status: false,
  description: null,
  expire_date: null,
  questions: [],
});

if (route.params.id) {
  model.value = store.state.questionnaires.find((s) => s.id === parseInt(route.params.id));
  // console.log(parseInt(route.params.id))
  //store.dispatch('getSurvey', route.params.id);
}

function addQuestion(index) {
  const newQuestion = {
    id: uuid.v1(),
    type: 'text',
    question: "",
    description: null,
    data: {},
  };
  model.value.questions.splice(index, 0, newQuestion);
}

function deleteQuestion(question) {
  model.value.questions = model.value.questions.filter((q) => q !== question);
}

function questionChange(data) {
  model.value.questions = model.value.questions.map(
    (q) => {
      if (q.id === data.id) {
        return JSON.parse(JSON.stringify(data));
      }
      return q;
    }
  );
}

function saveSurvey() {
  store.dispatch('saveQuestionnaire', model.value)
    .then( ({data}) => {
      router.push({
        name: 'Questionnaires'
      })
    })
}
</script>


