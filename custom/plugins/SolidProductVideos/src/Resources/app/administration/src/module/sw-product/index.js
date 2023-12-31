// extensions
import './component/solid-product-media-form';

// overrides
import './view/sw-product-detail-base';

// snippets
import enGB from './snippet/en-GB.json';
import deDE from './snippet/de-DE.json';

Shopware.Locale.extend('en-GB', enGB);
Shopware.Locale.extend('de-DE', deDE);