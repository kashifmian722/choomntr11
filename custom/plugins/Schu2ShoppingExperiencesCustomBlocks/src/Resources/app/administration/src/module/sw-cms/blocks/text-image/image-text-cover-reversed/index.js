import './component';
import './preview';
import deDE from "../../../snippet/de-DE.json";
import enGB from "../../../snippet/en-GB.json";

Shopware.Service('cmsService').registerCmsBlock({
    name: 'image-text-cover-reversed',
    label: 'custom.sw-cms.blocks.textImage.imageTextCoverReversed.label',
    category: 'text-image',
    component: 'sw-cms-block-image-text-cover-reversed',
    previewComponent: 'sw-cms-preview-image-text-cover-reversed',
    defaultConfig: {
        marginBottom: null,
        marginTop: null,
        marginLeft: null,
        marginRight: null,
        sizingMode: 'full_width'
    },
    snippets: {
        'de-DE': deDE,
        'en-GB': enGB
    },
    slots: {
        right: {
            type: 'image',
            default: {
                config: {
                    displayMode: { source: 'static', value: 'cover' }
                },
                data: {
                    media: {
                        url: '/administration/static/img/cms/preview_mountain_large.jpg'
                    }
                }
            }
        },
        left: 'text'
    }
});
