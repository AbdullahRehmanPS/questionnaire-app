<template>
  <div class="min-h-full">
    <Disclosure as="nav" class="bg-orange-500" v-slot="{ open }">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
          <div class="flex items-center">

            <div class="flex-shrink-0 bg-gray-400 rounded-full">
              <img class="h-8 w-8"
                   src="/phpstudios.png" alt="Your Company" />
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

          <div class="-mr-2 flex md:hidden">
            <!-- Mobile menu button -->
            <DisclosureButton class="inline-flex items-center justify-center rounded-md bg-gray-800
            p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2
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
            : 'text-gray-300 hover:bg-gray-700 hover:text-white',
             'block px-3 py-2 rounded-md text-base font-medium'
             ]"
          >{{ item.name }}
          </router-link>
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
  { name: 'User Dashboard', to: {name: 'UserDashboard'} },
  { name: 'Dashboard', to: {name: 'QuestionnaireCreate'} },
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
