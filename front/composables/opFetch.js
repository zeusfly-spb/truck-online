const authError = () => {
  const { $event } = useNuxtApp();
  $event('auth:error');
}
export const opFetch = (request, options) => {
  const config = useRuntimeConfig();
  const headers = new Headers();
  if (!(!!options.body && options.body instanceof FormData)) {
    headers.set("Content-Type", "application/json");
  }
  headers.set("Accept", "application/json");
  const cookie_token = useCookie("online_port_token");
  if (cookie_token.value) {
    headers.set("Authorization", `Bearer ${cookie_token.value}`);
  }
  return useFetch(request, {
    baseURL: config.public.apiBase,
    headers,
    ...options,
    async onResponseError({ response }) {
      response.status === 401 ? authError() : null;
    },
  });
};
