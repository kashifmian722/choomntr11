import template from './sw-cms-el-component-lae-prism-html.html.twig';
import './sw-cms-el-component-lae-prism-html.scss';

const {Component, Mixin} = Shopware;

Component.register('sw-cms-el-component-lae-prism-html', {
    template,

    mixins: [
        Mixin.getByName('cms-element')
    ],

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            this.initElementConfig('lae-prism-html');
            this.initElementData('lae-prism-html');
        },
    },
});
