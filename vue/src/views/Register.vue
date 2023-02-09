<template>
  <div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
      <div>
        <img class="mx-auto h-12 w-auto" src="/phpstudios.png"
             alt="Your Company" />
        <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">
          Create New Admin
        </h2>
      </div>
      <form class="mt-8 space-y-6" @submit="register">
        <input type="hidden" name="remember" value="true"/>
        <div class="-space-y-px rounded-md shadow-sm">
          <div>
            <label for="full-name" class="sr-only">Full name</label>
            <input id="full-name" name="name" type="text" autocomplete="name" required="" v-model="user.name"
                   class="relative block w-full
                   appearance-none rounded-none
                   rounded-t-md border border-gray-300
                   px-3 py-2 text-gray-900 placeholder-gray-500
                   focus:z-10 focus:border-orange-500
                   focus:outline-none focus:ring-orange-500
                   sm:text-sm"
                   placeholder="Full name">
          </div>
          <div>
            <label for="email-address" class="sr-only">Email address</label>
            <input id="email-address" name="email" type="email" autocomplete="email" required="" v-model="user.email"
                   class="relative block
                   w-full appearance-none
                   rounded-none border border-gray-300
                   px-3 py-2 text-gray-900
                   placeholder-gray-500
                   focus:z-10 focus:border-orange-500
                   focus:outline-none
                   focus:ring-orange-500 sm:text-sm"
                   placeholder="Email address"/>
          </div>
          <div>
            <label for="password" class="sr-only">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required=""
                   v-model="user.password"
                   class="relative block w-full
                   appearance-none rounded-none
                   border border-gray-300
                   px-3 py-2 text-gray-900 placeholder-gray-500
                   focus:z-10 focus:border-orange-500
                   focus:outline-none focus:ring-orange-500
                   sm:text-sm"
                   placeholder="Password"/>
          </div>
          <div>
            <label for="password_confirmation" class="sr-only">Confirm Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password"
                   autocomplete="current-password_confirmation" required="" v-model="user.password_confirmation"
                   class="relative block w-full
                   appearance-none rounded-none
                   rounded-b-md border border-gray-300
                   px-3 py-2 text-gray-900 placeholder-gray-500
                   focus:z-10 focus:border-orange-500
                   focus:outline-none focus:ring-orange-500
                   sm:text-sm"
                   placeholder="Confirm Password"/>
          </div>
        </div>

        <div>
          <button type="submit"
                  class="group relative flex w-full
                  justify-center rounded-md border
                  border-transparent bg-orange-500
                  py-2 px-4 text-sm font-medium
                  text-white hover:bg-orange-600
                  focus:outline-none focus:ring-2
                  focus:ring-orange-500 focus:ring-offset-2">

            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
              <LockClosedIcon class="h-5 w-5 text-orange-300 group-hover:text-orange-400" aria-hidden="true"/>
            </span>
            Sign Up
          </button>
        </div>
      </form>
    </div>
  </div>

</template>

<script setup>
import {LockClosedIcon} from '@heroicons/vue/20/solid'
import {useRouter} from "vue-router";
import store from "../store/index.js";

const router = useRouter();
const user = {
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
};

function register(ev) {
  ev.preventDefault();
  store
    .dispatch("register", user)
    .then(() => {
      router.push({
        name: "AdminDashboard",
      });
    })
}

</script>
