export default defineNuxtRouteMiddleware((to, from) => {
  if (token.value && to?.name === 'login') {
    return navigateTo('/profile');
  }
  if (!token.value && to?.name !== 'login') {
    abortNavigation();
    return navigateTo('/login');
  }
})
