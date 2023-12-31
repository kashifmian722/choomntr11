import './component';
import './config';
import './preview';

Shopware.Service('cmsService').registerCmsElement({
    name: 'lae-prism-html',
    label: 'sw-cms.elements.lae-prism-html.label',
    component: 'sw-cms-el-component-lae-prism-html',
    configComponent: 'sw-cms-el-config-lae-prism-html',
    previewComponent: 'sw-cms-el-preview-lae-prism-html',
    defaultConfig: {
        content: {
            source: 'static',
            value: ''
        }
    }
});
