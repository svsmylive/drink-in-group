export type LayoutSize = 'XS' | 'S' | 'M' | 'L';

const breakpoints = useBreakpoints({
  xs: 768,
  s: 1024,
  m: 1280,
});

const xs = breakpoints.smaller('xs');
const s = breakpoints.between('xs', 's');
const m = breakpoints.between('s', 'm');

export function useLayoutSize(): LayoutSize {
  if (xs.value) {
    return 'XS';
  }

  if (s.value) {
    return 'S';
  }

  if (m.value) {
    return 'M';
  }

  return 'L';
}
