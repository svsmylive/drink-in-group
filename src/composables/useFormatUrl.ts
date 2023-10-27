export function useFormatUrl() {
  function formatUrl(url: string) {
    const runtimeConfig = useRuntimeConfig();
    const urlBase = runtimeConfig.public.urlBase ?? '';
    return `${urlBase}${url}`;
  }

  return {
    formatUrl,
  };
}