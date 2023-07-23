
export const useShowSnack = () => useState(() => false);
export const useSnackType = () => useState<string | undefined>(() => 'success');
export const useSnackTitle = () => useState(() => 'Snack title');
export const useSnackMessage = () => useState<string | undefined>(() => '');
import { UseFetchOptions } from "nuxt/dist/app/composables";

/**
 * Method used to display snackbar
 * @param Snack data
 */
export const useSnack = ({show, type, title, message, }: {
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
      console.log("[fetch request]");

      const headers = new Headers(options.headers);
      headers.set("Authorization", "Bearer Token");

      options.headers = headers;
    },
    async onRequestError({ request, options, error }) {
      console.log("[fetch request error]");
    },
    async onResponse({ request, response, options }) {
      console.log("[fetch response]");
    },
    async onResponseError({ request, response, options }) {
      console.log("[fetch response error]");
    },
  });
};
