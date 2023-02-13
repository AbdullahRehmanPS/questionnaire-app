<template xmlns="http://www.w3.org/1999/html">
  <div class="py-5 px-8">
    <form @submit.prevent="submitQuestionnaire" class="container mx-auto">

      <div class="grid grid-cols-6 items-center">
        <div class="col-span-5">
          <h1 class="text-3xl mb-3">{{ questionnaire.title }}</h1>
          <p class="text-gray-500 text-sm" v-html="questionnaire.description"></p>
        </div>
      </div>

      <div v-if="questionnaireFinished" class="py-8 px-6 bg-emerald-400 text-white w-[600px] mx-auto">
        <div class="text-xl mb-3 font-semibold">
          Thank You for participating
        </div>
        <button
        @click="submitAnotherResponse"
        type="button"
        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
        >Submit Your Response
        </button>
      </div>

      <div v-else>
        <hr class="my-3"/>
        <div v-for="(question , index) in questionnaire.questions" :key="question.id">
          <QuestionViewer
            v-model="answers[question.id]"
            :question="question"
            :index="index"
          />
        </div>

        <button
          type="submit"
          class="bg-yellow-500 hover:bg-yellow-400 text-white font-bold py-2 px-4 border-b-4 border-yellow-600 hover:border-yellow-500 rounded"
        >Submit
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import QuestionViewer from '../../components/user/QuestionViewer.vue'
import { computed, ref } from "vue";
import { useRoute } from "vue-router";
import {useStore} from "vuex";

const route = useRoute();
const store = useStore();
const questionnaire = computed(() => store.state.currentQuestionnaires.data);
const questionnaireFinished = ref(false);

const answers = ref({});

//store.dispatch('getQuestionnaireBySlug', route.params.slug);
store
  .dispatch('getQuestionnaire', route.params.id)
  .then((response) => {
    //console.log(response)
  })

function submitQuestionnaire() {
  console.log(JSON.parse(JSON.stringify(answers.value, undefined, 2)));
  store
    .dispatch('saveQuestionnaireAnswer', {
      questionnaireId: questionnaire.value.id,
      answers: answers.value
    })
    .then((response) => {
      if(response.status === 201) {
        questionnaireFinished.value = true;
      }
    });
}

function submitAnotherResponse() {
  answers.value = {};
  questionnaireFinished.value = false;
}
</script>

<style></style>

