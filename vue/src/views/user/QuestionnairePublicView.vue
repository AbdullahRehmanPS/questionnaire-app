<template>
  <div class="py-5 px-8">
    <form @submit.prevent="submitQuestionnaire" class="container mx-auto">
      <div class="grid grid-cols-6 items-center">
        <div class="col-span-5">
          <h1 class="text-3xl mb-3">{{ questionnaire.title }}</h1>
          <p class="text-gray-500 text-sm" v-html="questionnaire.description"></p>
        </div>
      </div>
    </form>
  </div>
</template>

<script setup></script>

<style></style>
