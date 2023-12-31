import template from './solid-product-image.html.twig';
import './solid-product-image.scss';

const { Context } = Shopware;

Shopware.Component.extend('solid-product-image', 'sw-product-image', {
  template,

  inject: ['repositoryFactory'],

  props: {
    isEmbeddedVideo: {
      type: Boolean,
      required: false
    }
  },

  data() {
    return {
      trueSource: null
    }
  },

  computed: {
    mediaRepository() {
      return this.repositoryFactory.create('media');
    },

    mimeType() {
      if (!this.trueSource) {
        return '';
      }

      if (this.trueSource instanceof File) {
        return this.trueSource.type;
      }

      if (this.trueSource instanceof URL) {
        return 'application/octet-stream';
      }

      return this.trueSource.mimeType;
    },

    mimeTypeGroup() {
      if (!this.mimeType) {
        return '';
      }

      return this.mimeType.split('/')[0];
    }
  },

  watch: {
    mediaId() {
      this.fetchSourceIfNecessary();
    }
  },

  created() {
    this.createdComponent();
  },

  methods: {
    createdComponent() {
      this.fetchSourceIfNecessary();
    },

    fetchSourceIfNecessary() {
      if (!this.mediaId) {
        return;
      }

      if (typeof this.mediaId === 'string' && this.mediaId.length === 32) {
        this.mediaRepository.get(this.mediaId, Context.api).then((media) => {
          this.trueSource = media;
        });
        return;
      }

      this.trueSource = this.mediaId;
    }
  }
});
