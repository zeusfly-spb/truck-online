import {useAuthStore} from "~/store/auth";
import {storeToRefs} from "pinia";

export default defineNuxtRouteMiddleware((to, from) => {
  const {authenticated} = storeToRefs(useAuthStore());

  if (authenticated && to?.name === 'login') {
    return navigateTo('/profile');
  }
  if (!authenticated && to?.name !== 'login') {
    abortNavigation();
    return navigateTo('/login');
  }
})
