<template>
      <div>
        <img class="mx-auto h-12 w-auto" src="/phpstudios.png" alt="Your Company" />
        <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Log in to your account</h2>
      </div>

      <form class="mt-8 space-y-6" @submit="login">
        <div v-if="errMsg" class="py-3 px-5 bg-red-500 text-white rounded">
          {{errMsg}}
        </div>
        <input type="hidden" name="remember" value="true" />
        <div class="-space-y-px rounded-md shadow-sm">
          <div>
            <label for="email-address" class="sr-only">Email address</label>
            <input id="email-address" name="email" type="email" autocomplete="email" v-model="user.email" class="relative block w-full appearance-none rounded-none rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-orange-500 focus:outline-none focus:ring-orange-500 sm:text-sm" placeholder="Email address" />
          </div>
          <div>
            <label for="password" class="sr-only">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required="" v-model="user.password"
                   class="relative block w-full appearance-none
                    rounded-none rounded-b-md border border-gray-300
                    px-3 py-2 text-gray-900 placeholder-gray-500
                    focus:z-10 focus:border-orange-500 focus:outline-none
                    focus:ring-orange-500 sm:text-sm" placeholder="Password" />
          </div>
        </div>

        <div>
          <button type="submit" class="group relative flex w-full justify-center rounded-md borde border-transparent bg-orange-500 py-2 px-4 text-sm font-medium text-white hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
              <LockClosedIcon class="h-5 w-5 text-orange-300 group-hover:text-orange-400" aria-hidden="true" />
            </span>
            Login
          </button>
        </div>
      </form>

</template>

<script setup>
import { LockClosedIcon } from '@heroicons/vue/20/solid'
import { useRoute, useRouter } from "vue-router";
import {ref} from "vue";
import store from "../store/index.js";

const router = useRouter();
const user = {
  email: '',
  password: '',
  // remember: false
};

let errMsg = ref('');

function login(ev) {
  ev.preventDefault()
  store
    .dispatch('login', user)
    .then(() => {
      router.push({
        name: 'AdminDashboard'
      });
    })
    .catch((err) => {
      console.log(err)
      // errorMsg.value = err.response.error;
    })
}

</script>
