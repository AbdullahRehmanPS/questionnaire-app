<template>
  <div class="min-h-full">
    <Disclosure as="nav" class="bg-orange-500" v-slot="{ open }">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
          <div class="flex items-center">

            <div class="flex-shrink-0 bg-gray-400 rounded-full">
              <img class="h-8 w-8"
                   src="/public/phpstudios.png" alt="Your Company" />
            </div>

            <div class="hidden md:block">
              <div class="ml-10 flex items-baseline space-x-4">
                <router-link
                  v-for="item in navigation"
                  :key="item.name"
                  :to="item.to"
                  active-class="bg-gray-700 text-white"
                  :class="[
                    this.$route.name === item.to.name
                    ? ''
                    : 'text-white hover:bg-gray-700 hover:text-white',
                    'px-3 py-2 rounded-md text-sm font-medium'
                    ]"
                >{{ item.name }}
                </router-link>
              </div>
            </div>

          </div>

          <div class="hidden md:block">
            <div class="ml-4 flex items-center md:ml-6">
              <!-- profile view (Desktop view) -->
              <Menu as="div" class="relative ml-3">
                <div>
                  <MenuButton class="flex max-w-xs items-center
                              rounded-full bg-gray-400 text-sm
                              focus:outline-none focus:ring-2
                              focus:ring-white focus:ring-offset-2
                              focus:ring-offset-gray-800">
                    <span class="sr-only">Open user menu</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                  </MenuButton>

                </div>
                <transition enter-active-class="transition ease-out duration-100"
                            enter-from-class="transform opacity-0 scale-95"
                            enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                  <MenuItems class="absolute right-0 z-10 mt-2 w-48 origin-top-right
                  rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5
                  focus:outline-none">
                    <!-- Profile dropdown -->
                    <MenuItem v-slot="{ active }">
                      <a @click="logout" :class="['block px-4 py-2 text-sm text-gray-700 cursor-pointer']">
                        Signout
                      </a>
                    </MenuItem>
                  </MenuItems>
                </transition>
              </Menu>

            </div>
          </div>

          <div class="-mr-2 flex md:hidden">
            <!-- Mobile menu button -->
            <DisclosureButton class="inline-flex items-center justify-center rounded-md bg-gray-800
            p-2 text-white hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2
            focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
              <span class="sr-only">Open main menu</span>
              <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
              <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
            </DisclosureButton>
          </div>

        </div>
      </div>

      <DisclosurePanel class="md:hidden">
        <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
          <router-link
            v-for="item in navigation"
            :key="item.name"
            :to="item.to"
            active-class="bg-gray-700 text-white"
            :class="[
            this.$route.name === item.to.name
            ? ''
            : 'text-white hover:bg-gray-700 hover:text-white',
             'block px-3 py-2 rounded-md text-base font-medium'
             ]"
          >{{ item.name }}
          </router-link>
        </div>

        <div class="border-t border-gray-700 pt-4 pb-3">

          <div class="flex items-center px-5">
            <div class="flex-shrink-0 bg-gray-400 rounded-full">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
            </div>
            <div class="ml-3">
              <div class="text-base font-medium leading-none text-white">{{ user.name }}</div>
              <div class="text-sm font-medium leading-none text-white">{{ user.email }}</div>
            </div>
          </div>

          <div class="mt-3 space-y-1 px-2">
            <DisclosureButton
              as="a"
              @click="logout"
              class="block
              rounded-md
              px-3 py-2
              text-base
              font-medium
              text-white
              hover:bg-gray-700
              hover:text-white cursor-pointer">
              Sign out
            </DisclosureButton>
          </div>

        </div>
      </DisclosurePanel>
    </Disclosure>
    <router-view></router-view>
  </div>
</template>

<script>
import {useStore} from 'vuex';
import {useRouter} from 'vue-router';
import {computed} from "vue";
import { Disclosure,
  DisclosureButton,
  DisclosurePanel,
  Menu, MenuButton,
  MenuItem, MenuItems } from '@headlessui/vue';
import { BellIcon,
  Bars3Icon,
  XMarkIcon } from '@heroicons/vue/24/outline';

const navigation = [
  { name: 'Dashboard', to: {name: 'AdminDashboard'} },
  { name: 'Questionnaire', to: {name: 'Questionnaires'} },
];

export default {
  components: {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    BellIcon,
    XMarkIcon,
    Bars3Icon
  },
  setup() {
    const store = useStore();
    const router = useRouter();

    function logout() {
      store
        .dispatch('logout')
        .then(() => {
          router.push({
            name: 'Login'
          });
        });
    }
    return {
      user: computed(() => store.state.user.data),
      navigation,
      logout
    };


  },
};
</script>
