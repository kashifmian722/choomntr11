import GallerySliderPlugin from 'src/plugin/slider/gallery-slider.plugin'
import SliderSettingsHelper from 'src/plugin/slider/helper/slider-settings.helper';
import ViewportDetection from 'src/helper/viewport-detection.helper';
import { tns } from 'tiny-slider/src/tiny-slider.module';

const PluginManager = window.PluginManager;
export default class PvGallerySliderPlugin extends GallerySliderPlugin {
  init() {
    // set video preload attributes before anything else
    this._setProductVideosPreloadBehaviour();

    this._slider = false;
    this._thumbnailSlider = false;

    if (!this.el.classList.contains(this.options.initializedCls)) {
        this.options.slider = SliderSettingsHelper.prepareBreakpointPxValues(this.options.slider);
        this.options.thumbnailSlider = SliderSettingsHelper.prepareBreakpointPxValues(this.options.thumbnailSlider);
        this._correctIndexSettings();

        this._getSettings(ViewportDetection.getCurrentViewport());

        this._initSlider();
        this._registerEvents();
    }
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
    this.el.classList.add(this.options.initializedCls);

    const container = this.el.querySelector(this.options.containerSelector);
    const navContainer = this.el.querySelector(this.options.thumbnailsSelector);
    const controlsContainer = this.el.querySelector(this.options.controlsSelector);

    const hasThumbnails = (!!navContainer);

    if (container) {
        const onInit = () => {
            PluginManager.initializePlugin('Magnifier', '[data-magnifier]');
            PluginManager.initializePlugin('ZoomModal', '[data-zoom-modal]');

            if (!hasThumbnails) {
                this.el.classList.remove(this.options.loadingCls);
            }

            this.$emitter.publish('initGallerySlider');
        };

        if (this._sliderSettings.enabled) {
            container.style.display = '';

            this._slider = tns({
                container,
                controlsContainer,
                navContainer,
                onInit,
                ...this._sliderSettings
            });

            this._initDots();
        } else {
            container.style.display = 'none';
        }
    }

    if (navContainer) {
        const thumbnailControls = this.el.querySelector(this.options.thumbnailControlsSelector);

        const onInitThumbnails = () => {
            if (hasThumbnails) {
                this.el.classList.remove(this.options.loadingCls);
            }
            this.$emitter.publish('initThumbnailSlider');
        };

        if (this._thumbnailSliderSettings.enabled) {
            navContainer.style.display = '';

            this._thumbnailSlider = tns({
                container: navContainer,
                controlsContainer: thumbnailControls,
                onInit: onInitThumbnails,
                ...this._thumbnailSliderSettings
            });
        } else {
            navContainer.style.display = 'none';
            // Bugfix 6.3: Slider height
            this.el.classList.remove(this.options.loadingCls);
        }
    }

    this.$emitter.publish('afterInitSlider');

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