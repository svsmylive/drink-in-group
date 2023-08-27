export function downloadFile(url?: string, title?: string) {
  if (url == undefined) {
    return;
  }

  const link = document.createElement("a");
  link.setAttribute('download', title ?? 'download');
  link.href = url;
  document.body.appendChild(link);

  link.click();
  link.remove();
}
