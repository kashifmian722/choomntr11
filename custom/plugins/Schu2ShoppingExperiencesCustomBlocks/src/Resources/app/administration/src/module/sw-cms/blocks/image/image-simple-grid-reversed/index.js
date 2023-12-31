import './component';
import './preview';
import deDE from '../../../snippet/de-DE';
import enGB from '../../../snippet/en-GB';


Shopware.Service('cmsService').registerCmsBlock({
    name: 'image-simple-grid-reversed',
    label: 'custom.sw-cms.blocks.image.imageSimpleGrid.label',
    category: 'image',
    component: 'sw-cms-block-image-simple-grid-reversed',
    previewComponent: 'sw-cms-preview-image-simple-grid-reversed',
    defaultConfig: {
        marginBottom: '20px',
        marginTop: '20px',
        marginLeft: '20px',
        marginRight: '20px',
        sizingMode: 'boxed'
    },
    snippets: {
        'de-DE': deDE,
        'en-GB': enGB
    },
    slots: {
        'right-top': {
            type: 'image',
            default: {
                config: {
                    displayMode: { source: 'static', value: 'cover' }
                },
                data: {
                    media: {
                        url: '/administration/static/img/cms/preview_camera_large.jpg'
                    }
                }
            }
        },
        'right-bottom': {
            type: 'image',
            default: {
                config: {
                    displayMode: { source: 'static', value: 'cover' }
                },
                data: {
                    media: {
                        url: '/administration/static/img/cms/preview_glasses_large.jpg'
                    }
                }
            }
        },
        left: {
            type: 'image',
            default: {
                config: {
                    displayMode: { source: 'static', value: 'cover' }
                },
                data: {
                    media: {
                        url: '/administration/static/img/cms/preview_plant_large.jpg'
                    }
                }
            }
        }
    }
});

