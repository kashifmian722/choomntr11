Shopware.Component.override('sw-product-detail', {
  methods: {
    addMedia(mediaItem) {
      Shopware.State.commit('swProductDetail/setLoading', ['media', true]);

      // return error if media exists
      if (this.product.media.has(mediaItem.id)) {
          Shopware.State.commit('swProductDetail/setLoading', ['media', false]);
          // eslint-disable-next-line prefer-promise-reject-errors
          return Promise.reject('A media item with this id exists');
      }

      const newMedia = this.mediaRepository.create(Shopware.Context.api);
      newMedia.mediaId = mediaItem.id;

      if (mediaItem.customFields) {
        newMedia.customFields = mediaItem.customFields;
      }

      return new Promise((resolve) => {
        // if no other media exists
        let isVideo = false;
        let isEmbeddedVideo = false;

        if (mediaItem.mimeType.split('/')[0] === 'video') {
          isVideo = true;
        };

        if (mediaItem.customFields && mediaItem.customFields.pv_is_embedded_video) {
          isEmbeddedVideo = true;
        }

        if (this.product.media.length === 0 && !isVideo && !isEmbeddedVideo) {
            // set media item as cover
            newMedia.position = 0;
            this.product.coverId = newMedia.id;
        }
        this.product.media.add(newMedia);

        Shopware.State.commit('swProductDetail/setLoading', ['media', false]);

        resolve(newMedia.mediaId);
        return true;
      });
    }
  }
});