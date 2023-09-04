import {useAuthStore} from "~/store/auth";
import {storeToRefs} from "pinia";
export default defineNuxtRouteMiddleware((to, from) => {
  const {authenticated} = storeToRefs(useAuthStore());
  if (!authenticated.value) {
    return navigateTo('/');
  }
})
