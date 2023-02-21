<template>
  <PageComponent>
    <template v-slot:header>
      <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
          {{ model.id ? model.title : 'Create a Questionnaires' }}
        </h1>
        <button v-if="route.params.id" type="button"
                @click="deleteQuestionnaire()" class="py-2 px-3 text-white bg-red-500 rounded-md hover:bg-red-700">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 -mt-1 inline-block">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
          </svg>
          Delete Questionnaire
        </button>
      </div>
    </template>

    <form @submit.prevent="saveQuestionnaire">
      <div class="shadow sm:rounded-md sm:overflow-hidden">
        <!--    QuestionnaireFields -->
        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
          <!--     Image -->

          <!--     Title -->
          <div>
            <label for="title" class="block text-sm font-medium text-gray-700">
              Title
            </label>
            <input id="title" name="title" type="text" v-model="model.title" autocomplete="questionnaire_title"
              class="mt-1 focus:ring-orange-500 focus:border-orange-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
            />
          </div>
          <!--     /Title -->

          <!--  Description  -->
          <div>
            <label for="about" class="block text-sm font-medium text-gray-700">
              Description
            </label>
            <div class="mt-1">
              <textarea id="description" name="description" rows="3"
                v-model="model.description" autocomplete="questionnaire_description" placeholder="Describe your questionnaire"
                class="shadow-sm focus:ring-orange-500 focus:border-orange-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"
              />
            </div>
          </div>
          <!--  /Description -->

        </div>
        <!--  /QuestionnaireFields      -->

        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

          <h3 class="text-2xl font-semibold flex items-center justify-between">
            Questions
            <!--  Add new questions -->
            <button type="button" @click="addQuestion()" class="flex items-center text-sm py-1 px-4 rounded-sm text-white bg-gray-600 hover:bg-gray-700">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
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
          <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-white font-bold py-2 px-4 border-b-4 border-yellow-600 hover:border-yellow-500 rounded"
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
import {ref, watch} from 'vue';
import {useRouter, useRoute} from "vue-router";
import {uuid} from 'vue-uuid';
import store from "../store/index.js";

const route = useRoute();
const router = useRouter();

let model = ref({
  title: "",
  description: null,
  questions: [],
});

watch(
  () => store.state.currentQuestionnaires.data,
  (newVal, oldVal) => {
    model.value = {
      ...JSON.parse(JSON.stringify(newVal)),
    };
  }
);

if (route.params.id) {
  store.dispatch('getQuestionnaire', route.params.id);
}

function addQuestion(index) {

    const newQuestion = {
      id: uuid.v1(),
      type: 'text',
      marks: "",
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

function saveQuestionnaire() {
  store.dispatch('saveQuestionnaire', model.value)
    .then(({data}) => {
      store.commit('notify', {
        type: 'success',
        message: 'Questionnaire updated successfully'
      })
      router.push({
        name: 'QuestionnaireView',
        params: {id: data.data.id}
      })
    })
}

function deleteQuestionnaire() {
  if (confirm('are u confirm u want to delete?')) {
    store.dispatch('deleteQuestionnaire', model.value.id)
      .then(() => {
        router.push({
          name: 'Questionnaires'
        })
      })
  }
}

</script>


