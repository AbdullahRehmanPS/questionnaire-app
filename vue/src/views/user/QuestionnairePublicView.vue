<template xmlns="http://www.w3.org/1999/html">
  <div class="py-5 px-8">
    <form @submit.prevent="submitQuestionnaire" class="container mx-auto">
      <div class="grid grid-cols-6 items-center">
        <div class="col-span-5">
          <h1 class="text-3xl mb-3">{{ questionnaire.title }}</h1>
          <p class="text-gray-500 text-sm" v-html="questionnaire.description"></p>
        </div>
      </div>
      <div v-if="questionnaireFinished" class="py-8 px-6 bg-orange-400 text-white w-[600px] mx-auto">
        <div class="text-xl mb-3 font-semibold border-r-white">Thank You for participating</div>
      </div>
      <div v-else>
        <div class="py-4 bg-white space-y-2 sm:py-4">
          <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
          <input id="name" name="name" type="text" v-model="model.name" required="" class="mt-1 focus:ring-orange-500 focus:border-orange-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input id="email" name="email" type="email"  v-model="model.email" required="" class="mt-1 focus:ring-orange-500 focus:border-orange-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
        </div>
        <hr class="my-3"/>
        <div v-for="(question , index) in questionnaire.questions" :key="question.id">
          <QuestionViewer
            v-model="answers[question.id]"
            :question="question"
            :index="index"
          />
        </div>
        <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-white font-bold py-2 px-4 border-b-4 border-yellow-600 hover:border-yellow-500 rounded">Submit</button>
      </div>
    </form>
  </div>
</template>

<script setup>
import QuestionViewer from '../../components/user/QuestionViewer.vue'
import {computed, ref} from "vue";
import {useRoute} from "vue-router";
import {useStore} from "vuex";

const route = useRoute();
const store = useStore();
const questionnaireFinished = ref(false);
const questionnaire = computed(() => store.state.currentQuestionnaires.data);

const answers = ref({});

let model = ref({
  name: "",
  email: "",
});

store
  .dispatch('getQuestionnaire', route.params.id)
  .then((response) => {
    console.log(response)
  })

function submitQuestionnaire() {
  store
    .dispatch('saveQuestionnaireAnswer', {
      questionnaireId: questionnaire.value.id,
      answers: answers.value,
      data: model.value
    })
    .then((response) => {
      if (response.status === 201) {
        questionnaireFinished.value = true;
      }
    });
}
</script>

<style></style>

