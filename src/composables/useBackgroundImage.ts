const backgroundImage = ref('public/images/bgbanner.webp');

export const useBackgroundImage = () => {
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
