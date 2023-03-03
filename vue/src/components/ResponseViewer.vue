<template>
  <div class="flex items-center">
    <div>
      <legend class="text-base font-medium text-gray-900 mt-3">{{ index + 1}}. {{ questionAnswer.question }}</legend>
      <p class="text-gray-500 text-sm">{{ questionAnswer.description }}</p>
    </div>
    <div class="mx-20"><p>/{{ questionAnswer.marks }}</p></div>
  </div>
  <div class="mt-3">
    <!--      Radio -->
    <div v-if="questionAnswer.type === 'radio'">
      <div v-for="(option, ind) of questionAnswer.data.options" :key="option.uuid" class="flex items-center">
        <p v-if="questionAnswer.answer === questionAnswer.data.answer && questionAnswer.answer === option.uuid" class="ml-3 flex items-center block text-sm font-medium text-gray-700 text-green-500">
          {{ ind + 1 }}. {{ option.text }}
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mb-1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
          </svg>
        </p>
        <p v-else-if="questionAnswer.answer === option.uuid" class="ml-3 flex items-center block text-sm font-medium text-gray-700 text-red-600 inline">
          {{ ind + 1 }}. {{ option.text }}
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </p>
        <p v-else-if="questionAnswer.data.answer === option.uuid" class="ml-3 flex items-center block text-sm font-medium text-gray-700 text-green-500">
          {{ ind + 1 }}. {{ option.text }}
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mb-1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
          </svg>
        </p>
        <p v-else class="ml-3 block text-sm font-medium text-gray-700">
           {{ ind + 1 }}. {{ option.text }}
        </p>
      </div>
    </div>
    <!--      Checkbox  -->
    <div v-else-if="questionAnswer.type === 'checkbox'">
      <div v-for="(option, ind) of questionAnswer.data.options" :key="option.uuid" class="flex items-center">
        <input :id="option.uuid" v-model="model[option.text]" @change="onCheckboxChange"
               type="checkbox" class="focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300 rounded" />
        <label :for="option.uuid" class="ml-3 block text-sm font-medium text-gray-700">
          {{ option.text }}
        </label>
      </div>
    </div>
    <!--   Text -->
    <div v-else-if="questionAnswer.type === 'text'">
      <p>Answer: {{ questionAnswer.answer }}</p>
    </div>
    <!--   TextArea -->
    <div v-else-if="questionAnswer.type === 'textarea'">
      <p>Answer: {{ questionAnswer.answer }}</p>
    </div>
  </div>
</template>

<script setup>
const { questionAnswer, index } = defineProps({
  questionAnswer: Object,
  index: Number,
});
</script>

