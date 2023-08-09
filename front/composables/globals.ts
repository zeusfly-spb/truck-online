
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
      const headers = new Headers(options.headers);
      headers.set('Content-Type', 'application/json');
      const cookie_token = useCookie('online_port_token');
      if (cookie_token.value) {
        headers.set("Authorization", `Bearer ${ cookie_token.value }`);
      }
      options.headers = headers;
    },
    async onRequestError({ request, options, error }) {},
    async onResponse({ request, response, options }) {},
    async onResponseError({ request, response, options }) {},
  });
};
/**
 *
 * @param inn
 */
export const getSbis = async (inn: string) => {
  const { data, error } =
    await useFetch('https://api.sbis.ru/vok-demo/req?inn=' + inn);
  return { data, error };
}
