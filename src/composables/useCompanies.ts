const companiesData = ref();
const companies = computed(() => formatCompanies(companiesData.value?.value?.data) ?? []);

export function useCompanies() {
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