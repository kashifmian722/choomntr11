import PvGallerySliderPlugin from './plugin/slider/pv-gallery-slider.plugin';

const PluginManager = window.PluginManager;
PluginManager.override('GallerySlider', PvGallerySliderPlugin, '[data-gallery-slider]');