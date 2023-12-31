import template from './pv-product-media-form.html.twig';

Shopware.Component.extend('pv-product-media-form', 'sw-product-media-form', {
  template,

  computed: {
    mediaRepository() {
      return this.repositoryFactory.create('media');
    }
  },

  methods: {
    createMediaAssociation(targetId) {
      const productMedia = this.productMediaRepository.create(Shopware.Context.api);

      productMedia.productId = this.product.id;
      productMedia.mediaId = targetId;

      if (this.product.media.length <= 0) {
          productMedia.position = 0;

          this.mediaRepository.get(productMedia.mediaId, Shopware.Context.api).then((entity) => {
            if (entity.mimeType.split('/')[0] === 'image') {
              this.product.coverId = productMedia.id;
            }
          });
      } else {
          productMedia.position = this.product.media.length;
      }
      return productMedia;
    },

    isEmbeddedVideo(mediaItem) {
      if (mediaItem.customFields && mediaItem.customFields.pv_is_embedded_video) {
        return true;
      }

      return false;
    }
  }
});