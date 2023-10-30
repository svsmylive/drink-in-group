export const useCompanies = () => {
  const companiesData = ref();

  const { formatCompanies } = useFormatCompanies();
  const companies = computed(() => formatCompanies(companiesData.value?.value?.data) ?? []);

  async function update() {
    if (companies.value.length > 0) {
      return;
    }

    const { data } = await useFetch(formatApi('/institutions'));
    companiesData.value = data;
  }

  update();

  return {
    companies,
  };
}