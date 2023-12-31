import deDE from './snippet/de-DE';
import enGB from './snippet/en-GB';
import './page/gpa-config';
import './extension/sw-plugin';

const { Module } = Shopware;

Module.register('gpa-config', {
    type: 'plugin',
    name: 'Google Pin Address Configuration',
    title: 'gpa.general.mainMenuItemGeneral',
    description: 'sw-property.general.descriptionTextModule',
    icon: 'default-documentation-pushpin',
    
    snippets: {
        'de-DE': deDE,
        'en-GB': enGB
    },

    routes: {
        index: {
            component: 'gpa-config',
            path: 'index',
            meta: {
                parentPath: 'sw.settings.index'
            }
        }
    },

    settingsItem: {
        name: 'wkgpa',
        to: 'gpa.config.index',
        label: 'gpa.general.mainMenuItemGeneral',
        group: 'plugins',
        icon: 'default-documentation-pushpin'
    }
});