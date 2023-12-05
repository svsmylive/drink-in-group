export const useCompanies = () => {
  const { formatCompanies } = useFormatCompanies();

  async function update() {
    const data = await useAsyncData('companies', async () => {
      const { data } = await $fetch(formatApi('/institutions/'));
      return formatCompanies(data) ?? [];
    })
  }

  update();

  return {
    companies: useNuxtData('companies').data,
  };
}
