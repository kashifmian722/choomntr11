import './component';
import './preview';

Shopware.Service('cmsService').registerCmsBlock({
    name: 'lae-prism-html',
    label: 'sw-cms.blocks.text.lae-prism-html.label',
    category: 'text',
    component: 'sw-cms-block-lae-prism-html',
    previewComponent: 'sw-cms-preview-lae-prism-html',
    defaultConfig: {
        marginBottom: '20px',
        marginTop: '20px',
        marginLeft: '20px',
        marginRight: '20px',
        sizingMode: 'boxed'
    },
    slots: {
        content: 'lae-prism-html'
    }
});
