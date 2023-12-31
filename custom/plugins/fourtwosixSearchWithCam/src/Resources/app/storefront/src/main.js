import SearchFormBarcodePlugin from './plugin/search-form-override.plugin';

const PluginManager = window.PluginManager;
PluginManager.override('SearchWidget', SearchFormBarcodePlugin, '[data-search-form]');

// Necessary for the webpack hot module reloading server
if (module.hot) {
    module.hot.accept();
}