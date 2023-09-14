export const opFetch = (request, options) => {
  const config = useRuntimeConfig();
  const headers = new Headers();
  headers.set("Content-Type", "application/json");
  headers.set("Accept", "application/json");
  const cookie_token = useCookie("online_port_token");
  if (cookie_token.value) {
    headers.set("Authorization", `Bearer ${cookie_token.value}`);
  }
  return useFetch(request, {
    baseURL: config.public.apiBase,
    headers,
    ...options,
  });
};
