function getSections(data: any) {
  const sections = [];
  const { formatUrl } = useFormatUrl();

  if (data?.menu != undefined) {
    sections.push({
      type: 'menu',
      background: formatUrl(data?.background_images?.menu?.url),
      link: formatUrl(data?.menu?.url),
    });
  }

  if (data?.about != undefined) {
    const { about } = data;
    sections.push({
      type: 'about',
      background: formatUrl(data?.background_images?.about?.url),
      headerText: about.about_detail_text_header,
      bodyText: about.about_detail_text_body,
      footerText: about.about_detail_text_footer,
      images: about.images?.map((image: any) => formatUrl(image?.url)),
    });
  }

  if (data?.sauna_services_and_prices != undefined) {
    const sauna = data.sauna_services_and_prices;
    sections.push({
      type: 'sauna',
      background: formatUrl(data?.background_images?.services?.url),
      headerText: sauna.services_and_prices_text_header,
      footerText: sauna.services_and_prices_text_footer,
      capacity: sauna.services_and_prices_capacity,
      price: sauna.services_and_prices_price,
      includes: sauna.services_and_prices_include ?? [],
      includesExtra: sauna.services_and_prices_additionally_include ?? [],
      image: formatUrl(sauna.image?.url),
    });
  }

  if (data?.event != undefined && data?.event?.image?.length > 0) {
    const { event } = data;
    sections.push({
      type: 'events',
      background: formatUrl(data?.background_images?.events?.url),
      headerText: event.event_text_header,
      footerText: event.event_text_footer,
      events: event.image?.map((e: any) => ({
        title: e.name,
        content: e.text,
        date: e.date,
        time: e.time,
        image: formatUrl(e.image?.url),
      })),
    });
  }

  sections.push({
    type: 'reserve',
    background: formatUrl(data?.background_images?.reserve?.url),
  });

  return sections;
}

function getSlider(data: any) {
  const layoutSize = useLayoutSize();
  const { formatUrl } = useFormatUrl();

  if ((layoutSize == 'XS' || layoutSize == 'S') && data?.slider_images_mobile?.length > 0) {
    return data?.slider_images_mobile.map((image: any) => formatUrl(image?.url)) ?? [];
  }

  return data?.slider_images_desktop.map((image: any) => formatUrl(image?.url)) ?? [];
}

export function formatCompanies(data: any) {
  if (data == undefined || !Array.isArray(data) || data.length === 0) {
    return [];
  }

  const { formatUrl } = useFormatUrl();

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
    logo: item?.logo?.url != undefined ? formatUrl(item?.logo?.url) : '',
    seoUrl: item?.url ?? item?.name ?? '',
    seoTitle: item?.title ?? item?.name ?? 'Drink In Group',
    seoDescription: item?.description ?? item?.name ?? '',

    slider: getSlider(item),

    sections: getSections(item),
  }))
}
