<template>
  <PageComponent title="Admin">
    <div v-if="loading" class="flex justify-center">loading...</div>
    <div
      v-else
      class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 text-gray-700"
    ></div>
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
