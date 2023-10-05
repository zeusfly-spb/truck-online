export const useShowSnack = () => useState(() => false);
export const useSnackType = () => useState<string | undefined>(() => "success");
export const useSnackTitle = () => useState(() => "Snack title");
export const useSnackMessage = () => useState<string | undefined>(() => "");
import { UseFetchOptions } from "nuxt/dist/app/composables";
/**
 * Method used to display snackbar
 * @param Snack data
 */
export const useSnack = ({
  show,
  type,
  title,
  message,
}: {
  show: boolean;
  type?: string;
  title: string;
  message?: string;
}) => {
  const s = useShowSnack();
  const t = useSnackTitle();
  const m = useSnackMessage();
  const ty = useSnackType();
  s.value = show;
  t.value = title;
  m.value = message;
  ty.value = type;
};

/**
 *
 * @param url
 * @param options
 */
export const useFetchApi = (url: string, options?: UseFetchOptions<object>) => {
  return useFetch(url, {
    ...options,
    async onRequest({ request, options }) {
      const headers = new Headers(options.headers);
      headers.set("Content-Type", "application/json");
      const cookie_token = useCookie("online_port_token");
      if (cookie_token.value) {
        headers.set("Authorization", `Bearer ${cookie_token.value}`);
      }
      options.headers = headers;
    },
    async onRequestError({ request, options, error }) {},
    async onResponse({ request, response, options }) {},
    async onResponseError({ request, response, options }) {},
  });
};

export const postDadata = async ({ query }) => {
  const headers = new Headers();
  headers.set("Content-Type", "application/json");
  headers.set("Accept", "application/json");
  headers.set(
    "Authorization",
    "Token 1f871a72833bf0acbdde9976e17aeb519149480d",
  );

  return await useFetch(
    "https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/party",
    { method: "post", headers, body: { query } },
  );
};
