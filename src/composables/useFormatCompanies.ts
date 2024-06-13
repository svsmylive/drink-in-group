export const useFormatCompanies = () => {
  const runtimeConfig = useRuntimeConfig();

  function formatCompanyUrl(url: string) {
    const urlBase = runtimeConfig.public.urlBase ?? '';
    return `${urlBase}${url}`;
  }

  function getSections(data: any) {
    const sections = [];

    if (data?.menu) {
      sections.push({
        type: 'menu',
        background: formatCompanyUrl(data?.background_images?.menu?.url),
        link: formatCompanyUrl(data?.menu?.url),
      });
    }
    if (data?.about) {
      const { about } = data;
      sections.push({
        type: 'about',
        background: formatCompanyUrl(data?.background_images?.about?.url),
        headerText: about.about_detail_text_header,
        bodyText: about.about_detail_text_body,
        footerText: about.about_detail_text_footer,
        images: about.images?.map((image: any) => formatCompanyUrl(image?.url)),
      });
    }
    if (data?.sauna_services_and_prices) {
      const sauna = data.sauna_services_and_prices;
      sections.push({
        type: 'sauna',
        background: formatCompanyUrl(data?.background_images?.services?.url),
        headerText: sauna.services_and_prices_text_header,
        footerText: sauna.services_and_prices_text_footer,
        capacity: sauna.services_and_prices_capacity,
        price: sauna.services_and_prices_price,
        includes: sauna.services_and_prices_include ?? [],
        includesExtra: sauna.services_and_prices_additionally_include ?? [],
        image: formatCompanyUrl(sauna.image?.url),
      });
    }
    if (data?.event && data?.event?.image?.length > 0) {
      const { event } = data;
      sections.push({
        type: 'events',
        background: formatCompanyUrl(data?.background_images?.events?.url),
        headerText: event.event_text_header,
        footerText: event.event_text_footer,
        events: event.image?.map((e: any) => ({
          title: e.name,
          content: e.text,
          date: e.date,
          time: e.time,
          image: formatCompanyUrl(e.image?.url),
        })),
      });
    }
    if (data?.name?.toLowerCase() !== 'вино и море') {
      sections.push({
        type: 'reserve',
        background: formatCompanyUrl(data?.background_images?.reserve?.url),
      });
    }

    return sections;
  }

  function getSlider(data: any) {
    return data?.slider_images_desktop?.map((image: any) => formatCompanyUrl(image?.url)) ?? [];
  }

  function getMobileSlider(data: any) {
    const slider = data?.slider_images_mobile?.length > 0 ? data.slider_images_mobile : data?.slider_images_desktop;
    return slider?.map((image: any) => formatCompanyUrl(image?.url)) ?? [];
  }

  function formatCompanies(data: any) {
    if (data == undefined || !Array.isArray(data) || data.length === 0) {
      return [];
    }
    return data.map((item) => ({
      id: item?.id ?? 0,
      isActive: item?.active ?? false,
      name: item?.name ? `«${item.name}»` : '',
      city: item?.city ?? 'Не указан',
      type: item?.type ?? 'Не указан',
      address: item?.address ?? 'Не указан',
      fullAddress: item?.full_address ?? 'Не указан',
      timeOfWork: item?.time_of_work ?? 'Не указан',
      phone: item?.phone ?? 'Не указан',
      logo: item?.logo?.url != undefined ? formatCompanyUrl(item?.logo?.url) : '',
      seoUrl: item?.url ?? item?.name ?? '',
      seoTitle: item?.title ?? item?.name ?? 'Drink In Group',
      seoDescription: item?.description ?? item?.name ?? '',

      slider: getSlider(item),
      mobileSlider: getMobileSlider(item),

      sections: getSections(item),
    }))
  }

  return {
    formatCompanies,
  };
}
