<script setup lang="ts">
interface Props {
  theme: 'Title-L-Regular' | 'Title-M-Medium' | 'Title-M-Regular' | 'Title-S' | 'Title-XS'
    | 'Body-L-Medium' | 'Body-L-Regular' | 'Body-M' | 'Body-S' | 'Body-XS' | 'Body-XXS'
    | 'Button-Primary' | 'Button-Secondary' | 'Number';
  clickable?: boolean;
}

const props = defineProps<Props>();

const component = computed(() => {
  if (props.theme.startsWith('Title-')) {
    return 'h1';
  }

  return 'span';
});

const typographyStyle = computed(() => `d-text_${props.theme.toLowerCase()}`);

const typographySize = computed(() => `d-text_size-${useLayoutSize().toLowerCase()}`);

const clickableStyle = computed(() => ({ 'd-text_clickable': props.clickable }));

const typographyModifiers = computed(() => [
  typographyStyle.value,
  typographySize.value,
  clickableStyle.value,
]);
</script>

<template>
  <component
    :is="component"
    class="d-text"
    :class="typographyModifiers"
  >
    <slot />
  </component>
</template>

<style lang="scss">
.d-text {
  font-family: 'Golos Text', 'Trebuchet MS';
  color: $color-white;

  &.d-text_title-l-regular {
    font-weight: 500;
    text-transform: uppercase;
    white-space: nowrap;

    &.d-text_size-xs {
      font-size: 40px;
      line-height: 50px;
      white-space: normal;
    }

    &.d-text_size-s {
      font-size: 68px;
      line-height: 80px;
      white-space: normal;
    }

    &.d-text_size-m {
      font-size: 72px;
      line-height: 80px;
    }

    &.d-text_size-l {
      font-size: 100px;
      line-height: 100px;
    }
  }

  &.d-text_title-m-medium {
    font-weight: 500;
    text-transform: uppercase;
    white-space: nowrap;

    &.d-text_size-xs {
      font-size: 32px;
      line-height: 36px;
      white-space: normal;
    }

    &.d-text_size-s {
      font-size: 48px;
      line-height: 48px;
      white-space: normal;
    }

    &.d-text_size-m {
      font-size: 48px;
      line-height: 48px;
    }

    &.d-text_size-l {
      font-size: 72px;
      line-height: 80px;
    }
  }

  &.d-text_title-m-regular {
    font-weight: 400;
    text-transform: uppercase;
    white-space: nowrap;

    &.d-text_size-xs {
      font-size: 28px;
      line-height: 36px;
      white-space: normal;
    }

    &.d-text_size-s {
      font-size: 36px;
      line-height: 48px;
      white-space: normal;
    }

    &.d-text_size-m {
      font-size: 48px;
      line-height: 48px;
    }

    &.d-text_size-l {
      font-size: 80px;
      line-height: 80px;
    }
  }

  &.d-text_title-s {
    font-weight: 400;
    white-space: nowrap;

    &.d-text_size-xs {
      font-size: 28px;
      line-height: 36px;
      white-space: normal;
    }

    &.d-text_size-s {
      font-size: 36px;
      line-height: 44px;
      white-space: normal;
    }

    &.d-text_size-m {
      font-size: 44px;
      line-height: 48px;
    }

    &.d-text_size-l {
      font-size: 64px;
      line-height: 72px;
    }
  }

  &.d-text_title-xs {
    font-weight: 500;
    text-transform: uppercase;
    white-space: nowrap;

    &.d-text_size-xs {
      font-size: 20px;
      line-height: 36px;
      white-space: normal;
    }

    &.d-text_size-s {
      font-size: 28px;
      line-height: 36px;
      white-space: normal;
    }

    &.d-text_size-m {
      font-size: 28px;
      line-height: 36px;
    }

    &.d-text_size-l {
      font-size: 36px;
      line-height: 44px;
    }
  }

  &.d-text_body-l-medium {
    font-weight: 500;

    &.d-text_size-xs {
      font-size: 28px;
      line-height: 36px;
    }

    &.d-text_size-s {
      font-size: 36px;
      line-height: 44px;
    }

    &.d-text_size-m {
      font-size: 36px;
      line-height: 44px;
    }

    &.d-text_size-l {
      font-size: 36px;
      line-height: 44px;
    }
  }

  &.d-text_body-l-regular {
    font-weight: 400;
    text-transform: uppercase;

    &.d-text_size-xs {
      font-size: 18px;
      line-height: 24px;
    }

    &.d-text_size-s {
      font-size: 20px;
      line-height: 32px;
    }

    &.d-text_size-m {
      font-size: 24px;
      line-height: 32px;
    }

    &.d-text_size-l {
      font-size: 36px;
      line-height: 44px;
    }
  }

  &.d-text_body-m {
    font-weight: 400;

    &.d-text_size-xs {
      font-size: 16px;
      line-height: 24px;
    }

    &.d-text_size-s {
      font-size: 18px;
      line-height: 24px;
    }

    &.d-text_size-m {
      font-size: 20px;
      line-height: 28px;
    }

    &.d-text_size-l {
      font-size: 24px;
      line-height: 32px;
    }
  }

  &.d-text_body-s {
    font-weight: 400;

    &.d-text_size-xs {
      font-size: 14px;
      line-height: 20px;
    }

    &.d-text_size-s {
      font-size: 16px;
      line-height: 20px;
    }

    &.d-text_size-m {
      font-size: 18px;
      line-height: 22px;
    }

    &.d-text_size-l {
      font-size: 20px;
      line-height: 24px;
    }
  }

  &.d-text_body-xs {
    font-weight: 400;

    &.d-text_size-xs {
      font-size: 14px;
      line-height: 18px;
    }

    &.d-text_size-s {
      font-size: 16px;
      line-height: 20px;
    }

    &.d-text_size-m {
      font-size: 16px;
      line-height: 20px;
    }

    &.d-text_size-l {
      font-size: 16px;
      line-height: 20px;
    }
  }

  &.d-text_body-xxs {
    font-weight: 400;

    &.d-text_size-xs {
      font-size: 14px;
      line-height: 18px;
    }

    &.d-text_size-s {
      font-size: 14px;
      line-height: 18px;
    }

    &.d-text_size-m {
      font-size: 14px;
      line-height: 18px;
    }

    &.d-text_size-l {
      font-size: 14px;
      line-height: 18px;
    }
  }

  &.d-text_button-primary {
    font-weight: 400;
    letter-spacing: 0.48px;
    text-transform: uppercase;

    &.d-text_size-xs {
      font-size: 16px;
      line-height: 20px;
    }

    &.d-text_size-s {
      font-size: 20px;
      line-height: 24px;
    }

    &.d-text_size-m,
    &.d-text_size-l {
      font-size: 24px;
      line-height: 32px;
    }
  }

  &.d-text_button-secondary {
    font-weight: 500;
    letter-spacing: 0.48px;

    &.d-text_size-xs,
    &.d-text_size-s,
    &.d-text_size-m,
    &.d-text_size-l {
      font-size: 16px;
      line-height: 20px;
    }
  }

  &.d-text_number {
    font-weight: 500;
    letter-spacing: 1.28px;

    &.d-text_size-xs {
      font-size: 32px;
      line-height: 40px;
    }

    &.d-text_size-s {
      font-size: 32px;
      line-height: 40px;
    }

    &.d-text_size-m {
      font-size: 48px;
      line-height: 56px;
    }

    &.d-text_size-l {
      font-size: 64px;
      line-height: 72px;
    }
  }

  // TODO: del this
  &.d-text_button-primary--old {
    font-weight: 400;
    letter-spacing: 0.48px;
    text-transform: uppercase;

    &.d-text_size-xs {
      font-size: 28px;
      line-height: 36px;
    }

    &.d-text_size-s {
      font-size: 36px;
      line-height: 44px;
    }

    &.d-text_size-m {
      font-size: 44px;
      line-height: 48px;
    }

    &.d-text_size-l {
      font-size: 34px;
      line-height: 32px;
    }
  }

  // TODO: del this
  &.d-text_button-secondary--old {
    font-weight: 500;
    letter-spacing: 0.48px;

    &.d-text_size-xs {
      font-size: 28px;
      line-height: 36px;
    }

    &.d-text_size-s {
      font-size: 36px;
      line-height: 44px;
    }

    &.d-text_size-m {
      font-size: 44px;
      line-height: 48px;
    }

    &.d-text_size-l {
      font-size: 34px;
      line-height: 32px;
    }
  }
}

.d-text_clickable {
  cursor: pointer;

  &:hover {
    opacity: 50%;
  }
}
</style>