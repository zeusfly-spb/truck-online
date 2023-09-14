import {useAuthStore} from "~/store/auth";
import {storeToRefs} from "pinia";

export default defineNuxtRouteMiddleware((to, from) => {
  const {authenticated} = storeToRefs(useAuthStore());
  const tokenCookie = useCookie('online_port_token');
  if (!authenticated.value && !tokenCookie.value) {
    return navigateTo('/');
  }
})
