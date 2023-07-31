import {useAuthStore} from "~/store/auth";
import {storeToRefs} from "pinia";

export default defineNuxtRouteMiddleware((to, from) => {
  const { authenticated } = storeToRefs(useAuthStore());
  const token = useCookie('online_port_token');
  if (token.value) {
    authenticated.value = true;
  }
  if (token.value && to?.name === 'login') {
    return navigateTo('/profile');
  }
  if (!token.value && to?.name !== 'login') {
    abortNavigation();
    return navigateTo('/login');
  }
})
