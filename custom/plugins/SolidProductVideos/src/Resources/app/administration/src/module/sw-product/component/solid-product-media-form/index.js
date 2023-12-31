import template from './solid-product-media-form.html.twig';
import './solid-product-media-form.scss';

const { Component, Context, Utils } = Shopware;
const { isEmpty } = Utils.types;
const { Criteria } = Shopware.Data;

Component.extend('solid-product-media-form', 'sw-product-media-form', {
  template,

  data() {
    return {
      embeddedVideoMediaDefaultFolderId: null,
      showEmbeddedVideoMediaModal: false,
      embeddedVideoMediaAddDisabled: true,
      embeddedVideo: {
        url: '',
        source: 'youtube',
        thumbnailId: ''
      },
    }
  },

  computed: {
    mediaRepository() {
      return this.repositoryFactory.create('media');
    },

    embeddedVideoMediaUploadTag() {
      return this.product.id + '-solid-product-video';
    },

    embeddedVideoMediaDefaultFolderRepository() {
      return this.repositoryFactory.create('media_default_folder');
    },

    embeddedVideoMediaDefaultFolderCriteria() {
      const criteria = new Criteria(1, 1);

      criteria.addAssociation('folder');
      criteria.addFilter(Criteria.equals('entity', 'product'));

      return criteria;
    },
  },

  watch: {
    'embeddedVideo.thumbnailId': {
      handler(value) {
        this.onChangeEmbeddedVideoThumbnailId(value);
      }
    }
  },

  created() {
    this.getEmbeddedVideoMediaDefaultFolderId().then((mediaDefaultFolderId) => {
      this.embeddedVideoMediaDefaultFolderId = mediaDefaultFolderId;
    });
  },

  methods: {
    getEmbeddedVideoMediaDefaultFolderId() {
      return this.embeddedVideoMediaDefaultFolderRepository
        .search(this.embeddedVideoMediaDefaultFolderCriteria, Context.api)
        .then((mediaDefaultFolder) => {
          const defaultFolder = mediaDefaultFolder.first();

          if (defaultFolder.folder?.id) {
            return defaultFolder.folder.id;
          }

          return null;
        });
    },

    onOpenEmbeddedVideoMedia() {
      this.showEmbeddedVideoMediaModal = true;
    },

    onRemoveEmbeddedVideoMedia() {
      this.embeddedVideo.thumbnailId = '';
    },

    onCloseEmbeddedVideoMediaModal() {
      this.showEmbeddedVideoMediaModal = false;
    },

    onUploadEmbeddedVideoMediaFinished({ targetId }) {
      this.embeddedVideo.thumbnailId = targetId;
    },

    createMediaAssociation(targetId) {
      const productMedia = this.productMediaRepository.create(Shopware.Context.api);

      productMedia.productId = this.product.id;
      productMedia.mediaId = targetId;

      if (this.product.media.length <= 0) {
        productMedia.position = 0;

        this.mediaRepository
          .get(productMedia.mediaId, Shopware.Context.api).then((entity) => {
          if (entity.mimeType.split('/')[0] === 'image' &&
            !this.isEmbeddedVideo(entity)) {
            this.product.coverId = productMedia.id;
          }
        });
      } else {
        productMedia.position = this.product.media.length;
      }

      return productMedia;
    },

    isEmbeddedVideo(mediaItem) {
      if (mediaItem.customFields &&
        mediaItem.customFields.pv_is_embedded_video) {
        return true;
      }

      return false;
    },

    onSelectEmbeddedVideoMedia(media) {
      if (isEmpty(media)) {
        return;
      }

      this.embeddedVideo.thumbnailId = media[0].id;
    },

    onChangeEmbeddedVideoUrl(value) {
      if (value && this.embeddedVideo.thumbnailId) {
        this.embeddedVideoMediaAddDisabled = false;
      } else {
        this.embeddedVideoMediaAddDisabled = true;
      }
    },

    onChangeEmbeddedVideoThumbnailId(value) {
      if (value && this.embeddedVideo.url) {
        this.embeddedVideoMediaAddDisabled = false;
      } else {
        this.embeddedVideoMediaAddDisabled = true;
      }
    },

    onAddEmbeddedVideoMedia() {
      this.mediaRepository
        .get(this.embeddedVideo.thumbnailId, Context.api).then((entity) => {

        entity.customFields = {
          pv_is_embedded_video: true,
          pv_url: this.embeddedVideo.url,
          pv_source: this.embeddedVideo.source
        };

        this.embeddedVideo = {
          url: '',
          source: 'youtube',
          thumbnailId: ''
        }

        this.$emit('add-embedded-video-media', entity);
      });
    },
  }
});