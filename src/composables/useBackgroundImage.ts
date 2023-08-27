const backgroundImage = ref('public/images/bgbanner.webp');

export function useBackgroundImage() {
  function getImage() {
    return backgroundImage.value;
  }

  function setImage(src: string) {
    backgroundImage.value = src;
  }

  return {
    src: backgroundImage,
    getImage,
    setImage,
  };
}
