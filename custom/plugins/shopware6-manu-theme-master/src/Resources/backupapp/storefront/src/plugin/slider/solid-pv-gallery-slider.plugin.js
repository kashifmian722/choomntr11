import GallerySliderPlugin from 'src/plugin/slider/gallery-slider.plugin';
import ViewportDetection from 'src/helper/viewport-detection.helper';

export default class SolidPvGallerySliderPlugin extends GallerySliderPlugin {
  init() {
    // set video preload attributes before anything else
    this._setProductVideosPreloadBehaviour();
    super.init();
  }

  _setProductVideosPreloadBehaviour() {
    const userAgent = navigator.userAgent.toLowerCase();
    let isSafari = false;

    if (userAgent.indexOf('safari') !== -1 && userAgent.indexOf('chrome') === -1) {
      isSafari = true;
    }

    if (!isSafari) {
      const videos = this.el.querySelectorAll('video');

      videos.forEach((video) => {
        video.setAttribute('preload', 'auto');
      });
    }
  }

  _initSlider() {
    super._initSlider()

    // add transition listener
    if (this._slider) {
      this._slider.events.on('transitionStart', () => {
        this._stopProductVideos();
      });
    }
  }

  _registerEvents() {
    if (this._slider) {
      document.addEventListener('Viewport/hasChanged', (event) => {
        // rebuild only if there was a valid viewport before
        if (event.detail.previousViewport !== 'NONE') {
          this.rebuild(ViewportDetection.getCurrentViewport())
        }
      });

      const zoomModalClose = this.el.querySelector('.zoom-modal-wrapper .close');

      if (zoomModalClose) {
        zoomModalClose.addEventListener('click', this._stopProductVideos.bind(this));
      }
    }
  }

  _stopProductVideos() {
    const videos = this.el.querySelectorAll('video');
    const youtubeEmbeddedVideos = this.el.querySelectorAll('.youtube');
    const vimeoEmbeddedVideos = this.el.querySelectorAll('.vimeo');

    videos.forEach((video) => {
      video.pause();
      video.currentTime = 0;
    });

    youtubeEmbeddedVideos.forEach((youtubeEmbeddedVideo) => {
      const content = youtubeEmbeddedVideo.contentWindow;
      content.postMessage('{ "event": "command", "func": "stopVideo", "args": "" }', '*');
    });

    vimeoEmbeddedVideos.forEach((vimeoEmbeddedVideo) => {
      const src = vimeoEmbeddedVideo.getAttribute('src');
      vimeoEmbeddedVideo.src = '';
      vimeoEmbeddedVideo.src = src;
    });
  }
}