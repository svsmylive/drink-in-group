export function formatApi(url: string) {
  const runtimeConfig = useRuntimeConfig();
  const apiBase = runtimeConfig.public.apiBase ?? '';
  return `${apiBase}${url}`;
}
