import template from './sw-cms-el-config-lae-prism-html.html.twig';
import './sw-cms-el-config-lae-prism-html.scss';

// import Prism Editor
import { PrismEditor } from '@vue-prism-editor';
import '@vue-prism-editor/dist/prismeditor.min.css'; // import the styles somewhere

// import highlighting library (you can use any library you want just return html string)
import { highlight, languages } from '@prismjs/components/prism-core';
import '@prismjs/components/prism-clike';
import '@prismjs/components/prism-markup';
import '@prismjs/themes/prism-tomorrow.css'; // import syntax highlighting styles

const {Component, Mixin} = Shopware;

Component.register('sw-cms-el-config-lae-prism-html', {
    template,

    components: {
        PrismEditor,
    },

    inject: ['repositoryFactory'],

    mixins: [
        Mixin.getByName('cms-element')
    ],

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            this.initElementConfig('lae-prism-html');
        },

        highlighter(code) {
            return highlight(code, languages.html);
        },
    },
});
