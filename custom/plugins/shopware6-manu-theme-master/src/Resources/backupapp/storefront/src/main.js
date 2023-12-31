import InputSpinner from './js/input-spinner/input-spinner.plugin';
import NewsletterPrivacy from './js/newsletter-privacy/newsletter-privacy.plugin';
import TogglePassword from './js/toggle-password/toggle-password.plugin';
import RegisterExpand from './js/register-expand/register-expand.plugin';
import PvGallerySliderPlugin from './plugin/slider/pv-gallery-slider.plugin';
import gasp from './js/gasp/minified/gasp.minified.js';


const PluginManager = window.PluginManager;

PluginManager.register('NewsletterPrivacy', NewsletterPrivacy, '.footer-newsletter-email');
PluginManager.register('InputSpinner', InputSpinner, '[data-input-spinner]');
PluginManager.register('TogglePassword', TogglePassword, '[data-toggle-password]');
PluginManager.register('RegisterExpand', RegisterExpand, '[data-register-expand]');
PluginManager.override('GallerySlider', PvGallerySliderPlugin, '[data-gallery-slider]');
PluginManager.override('gasp', gaspplugin, '[data-gasp]');



