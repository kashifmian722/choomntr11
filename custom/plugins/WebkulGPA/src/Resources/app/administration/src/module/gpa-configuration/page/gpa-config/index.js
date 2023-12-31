import template from './gpa-config.html.twig';
import './gpa-config.scss';

const { Component, Mixin } = Shopware;
const { Criteria } = Shopware.Data;

Component.register('gpa-config', {
    template,

    inject: [
        'repositoryFactory',
        'GpaApiService'
    ],

    mixins: [
        Mixin.getByName('notification')
    ],

    metaInfo() {
        return {
            title: this.$createTitle()
        };
    },

    data() {
        return {
            config: {
                googleApiKey: null
            },
            isLoading: false,
            processSuccess: false
        }
    },

    created() {
        this.getConfig();
    },

    computed: {
        systemConfigRepository() {
            return this.repositoryFactory.create('system_config');
        }
    },

    methods: {
        getConfig() {
            const criteria = new Criteria();
            criteria.setTerm('WebkulGpa.config.');
            this.systemConfigRepository.search(criteria, Shopware.Context.api).then((result) => {
                for (var i in result) {
                    if (result[i]['configurationKey'] == 'WebkulGpa.config.googleApiKey') {
                        this.config.googleApiKey = result[i]['configurationValue'];
                    }
                }
            });
        },

        onSaveConfig() {
            this.isLoading = true;
            this.processSuccess = true;
            
            if (this.config.googleApiKey == '') {
                this.isLoading = false;
                this.processSuccess = false;
                this.createNotificationError({
                    title: this.$t('gpa.config.errorTitle'),
                    message: this.$t('gpa.config.errorGoogleApiKey')
                });
                return;
            } else {
                this.GpaApiService.saveConfig(this.config).then(response => {
                    this.createNotificationSuccess({
                        title: this.$t('gpa.config.successTitle'),
                        message: this.$t('gpa.config.successMessage')
                    });
                    this.isLoading = false;
                    this.processSuccess = false;
                });
            }
        }
    }
});