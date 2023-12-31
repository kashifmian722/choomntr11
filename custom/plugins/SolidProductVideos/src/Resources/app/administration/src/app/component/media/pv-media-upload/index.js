import enGB from './snippet/en-GB.json';
import deDE from './snippet/de-DE.json';
import template from './pv-media-upload.html.twig';
import './pv-media-upload.scss';

Shopware.Locale.extend('en-GB', enGB);
Shopware.Locale.extend('de-DE', deDE);

const { Context } = Shopware;

Shopware.Component.extend('pv-media-upload', 'sw-media-upload-v2', {
  template,

  data() {
    return {
      embeddedVideo: {
        url: '',
        source: 'youtube',
        thumbnailId :''
      },
      embeddedVideoAddDisabled: true
    }
  },

  watch: {
    'embeddedVideo.thumbnailId': {
      handler(value) {
        this.onChangeEmbeddedVideoThumbnailId(value);
      }
    }
  },

  methods: {
    onChangeEmbeddedVideoUrl(value) {
      if (value && this.embeddedVideo.thumbnailId) {
        this.embeddedVideoAddDisabled = false;
      } else {
        this.embeddedVideoAddDisabled = true;
      }
    },

    onChangeEmbeddedVideoThumbnailId(value) {
      if (value && this.embeddedVideo.url) {
        this.embeddedVideoAddDisabled = false;
      } else {
        this.embeddedVideoAddDisabled = true;
      }
    },

    onClickEmbeddedVideoAdd() {
      this.mediaRepository.get(this.embeddedVideo.thumbnailId, Context.api).then((entity) => {
        entity.customFields = {
          pv_is_embedded_video: true,
          pv_url: this.embeddedVideo.url,
          pv_source: this.embeddedVideo.source
        };

        this.embeddedVideo.url = '';
        this.embeddedVideo.thumbnailId = '';

        this.$emit('media-drop', entity);
      });
    }
  }
});
