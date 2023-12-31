(this.webpackJsonp=this.webpackJsonp||[]).push([["recently-viewed-product"],{"05Ai":function(e,n,t){"use strict";t.r(n);var i=t("kXLx"),l=t.n(i);const{Component:c}=Shopware;c.register("sw-cms-block-recently-viewed-product-slider",{template:l.a});var s=t("jyw9"),o=t.n(s);t("uGW7");const{Component:r}=Shopware;r.register("sw-cms-preview-recently-viewed-product-slider",{template:o.a}),Shopware.Service("cmsService").registerCmsBlock({name:"recently-viewed-product-slider",label:"sw-cms.blocks.commerce.recentlyViewedProductSlider.label",category:"commerce",component:"sw-cms-block-recently-viewed-product-slider",previewComponent:"sw-cms-preview-recently-viewed-product-slider",defaultConfig:{marginBottom:"10px",marginTop:"10px",marginLeft:"10px",marginRight:"10px",sizingMode:"boxed"},slots:{recentlyViewedProductSlider:"recently-viewed-product-slider"}});var d=t("noL5"),a=t.n(d);const{Component:m,Mixin:u}=Shopware;m.register("sw-cms-el-recently-viewed-product-slider",{template:a.a,mixins:[u.getByName("cms-element")],data:()=>({sliderBoxLimit:3}),computed:{demoProductElement(){return{config:{displayMode:{source:"static",value:this.element.config.displayMode.value},boxLayout:{source:"static",value:"image"}},data:{product:{name:"Recent seen product show here",description:"Lorem ipsum dolor sit amet, consetetur sadipscing elitr,\n                    sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,\n                    sed diam voluptua.".trim(),price:[{gross:19.9}],cover:{media:{url:"/administration/static/img/cms/preview_glasses_large.jpg",alt:"Lorem Ipsum dolor"}}}}}},hasNavigation(){return!!this.element.config.navigation.value},classes(){return{"has--navigation":this.hasNavigation,"has--border":!!this.element.config.border.value}},sliderBoxMinWidth(){return this.element.config.elMinWidth.value&&this.element.config.elMinWidth.value.indexOf("px")>-1?`repeat(auto-fit, minmax(${this.element.config.elMinWidth.value}, 1fr))`:null},currentDeviceView(){return this.cmsPageState.currentCmsDeviceView},verticalAlignStyle(){return this.element.config.verticalAlign.value?`align-self: ${this.element.config.verticalAlign.value};`:null}},watch:{"element.config.elMinWidth.value":{handler(){this.setSliderRowLimit()}},currentDeviceView(){setTimeout(()=>{this.setSliderRowLimit()},400)}},created(){this.createdComponent()},mounted(){this.mountedComponent()},methods:{createdComponent(){this.initElementConfig("recently-viewed-product-slider"),this.initElementData("recently-viewed-product-slider")},mountedComponent(){this.setSliderRowLimit()},setSliderRowLimit(){if("mobile"===this.currentDeviceView||this.$refs.productHolder.offsetWidth<500)return void(this.sliderBoxLimit=1);if(!this.element.config.elMinWidth.value||"px"===this.element.config.elMinWidth.value||-1===this.element.config.elMinWidth.value.indexOf("px"))return void(this.sliderBoxLimit=3);if(parseInt(this.element.config.elMinWidth.value.replace("px",""),0)<=0)return;const e=this.$refs.productHolder.offsetWidth;let n=parseInt(this.element.config.elMinWidth.value.replace("px",""),0);n>=300&&(n-=100),this.sliderBoxLimit=Math.floor(e/(n+32))}}});var w=t("sq1q"),_=t.n(w);const{Component:p,Mixin:v}=Shopware;p.register("sw-cms-el-config-recently-viewed-product-slider",{template:_.a,inject:["repositoryFactory","systemConfigApiService"],mixins:[v.getByName("cms-element")],data:()=>({isLoading:!1}),created(){this.createdComponent()},methods:{async createdComponent(){if(this.element.isNew()){this.isLoading=!0;try{const e="RecentlyViewedProduct.config",n=await this.systemConfigApiService.getValues(e);Object.keys(this.element.config).forEach(t=>{let i=e+"."+t;(n[i]||!1===n[i])&&(this.element.config[t].value=n[i])})}catch{}finally{this.isLoading=!1}}this.initElementConfig("recently-viewed-product-slider")}}});var g=t("EptC"),f=t.n(g);const{Component:b}=Shopware;b.register("sw-cms-el-preview-recently-viewed-product-slider",{template:f.a}),(new(0,Shopware.Data.Criteria)).addAssociation("cover"),Shopware.Service("cmsService").registerCmsElement({name:"recently-viewed-product-slider",label:"sw-cms.elements.recentlyViewedProductSlider.label",component:"sw-cms-el-recently-viewed-product-slider",configComponent:"sw-cms-el-config-recently-viewed-product-slider",previewComponent:"sw-cms-el-preview-recently-viewed-product-slider",removable:!1,defaultConfig:{title:{source:"static",value:"Recently viewed products",required:!0},displayMode:{source:"static",value:"cover"},navigation:{source:"static",value:!0},rotate:{source:"static",value:!1},border:{source:"static",value:!1},elMinWidth:{source:"static",value:"250px"},verticalAlign:{source:"static",value:null},includeAction:{source:"static",value:!1},includePrice:{source:"static",value:!0},includeRating:{source:"static",value:!1}}})},AIUv:function(e,n,t){},EptC:function(e,n){e.exports='{% block sw_cms_el_preview_recently_viewed_product_slider %}\n    <div class="sw-cms-el-preview-product-slider">\n        <sw-icon name="default-arrow-head-left" size="10"></sw-icon>\n        <sw-cms-product-box-preview :hasText="false"></sw-cms-product-box-preview>\n        <sw-icon name="default-arrow-head-right" size="10"></sw-icon>\n    </div>\n{% endblock %}\n'},jyw9:function(e,n){e.exports='{% block sw_cms_preview_recently_viewed_product_slider %}\n    <div class="sw-cms-preview-recently-viewed-product-slider">\n        <sw-icon name="default-arrow-head-left" size="20"></sw-icon>\n        <div class="sw-cms-preview-recently-viewed-product-slider__product-box">\n            <sw-cms-product-box-preview></sw-cms-product-box-preview>\n            <sw-cms-product-box-preview></sw-cms-product-box-preview>\n        </div>\n        <sw-icon name="default-arrow-head-right" size="20"></sw-icon>\n    </div>\n{% endblock %}\n'},kXLx:function(e,n){e.exports='{% block sw_cms_block_recently_viewed_product_slider %}\n    <div class="sw-cms-block-recently-viewed-product-slider">\n        <slot name="recentlyViewedProductSlider"></slot>\n    </div>\n{% endblock %}\n'},noL5:function(e,n){e.exports='{% block sw_cms_element_recently_viewed_product_slider %}\n    <div class="sw-cms-el-product-slider" :class="classes" :style="verticalAlignStyle">\n        {% block sw_cms_element_recently_viewed_product_slider_title %}\n            <div class="sw-cms-el-product-slider__title" v-if="element.config.title.value">\n                {{ element.config.title.value }}\n            </div>\n        {% endblock %}\n\n        {% block sw_cms_element_recently_viewed_product_slider_content %}\n            <div class="sw-cms-el-product-slider__content">\n                {% block sw_cms_element_recently_viewed_product_slider_arrow_left %}\n                    <div v-if="hasNavigation" class="sw-cms-el-product-slider__navigation">\n                        <sw-icon class="sw-cms-el-product-slider__navigation-button"\n                                 name="default-arrow-head-left"\n                                 size="24">\n                        </sw-icon>\n                    </div>\n                {% endblock %}\n\n                {% block sw_cms_element_recently_viewed_product_slider_product_holder %}\n                    <div class="sw-cms-el-product-slider__product-holder" :style="sliderBoxMinWidth" ref="productHolder">\n                        <template>\n                            {% block sw_cms_element_recently_viewed_product_slider_demo_data %}\n                                <sw-cms-el-product-box :element="demoProductElement"\n                                                       v-for="index in sliderBoxLimit"\n                                                       :key="index">\n                                </sw-cms-el-product-box>\n                            {% endblock %}\n                        </template>\n                    </div>\n                {% endblock %}\n\n                {% block sw_cms_element_recently_viewed_product_slider_arrow_right %}\n                    <div v-if="hasNavigation" class="sw-cms-el-product-slider__navigation">\n                        <sw-icon class="sw-cms-el-product-slider__navigation-button"\n                                 name="default-arrow-head-right"\n                                 size="24">\n                        </sw-icon>\n                    </div>\n                {% endblock %}\n            </div>\n        {% endblock %}\n    </div>\n{% endblock %}\n'},sq1q:function(e,n){e.exports='{% block sw_cms_element_recently_viewed_product_slider_config %}\n    <div class="sw-cms-el-config-recently-viewed-product-slider">\n        {% block sw_cms_element_recently_seen_product_slider_config_settings_loading %}\n            <sw-loader v-if="isLoading"></sw-loader>\n        {% endblock %}\n        {% block sw_cms_element_recently_seen_product_slider_config_settings %}\n            <sw-container v-else class="sw-cms-el-config-product-slider__tab-settings">\n\n                {% block sw_cms_element_recently_seen_product_slider_config_content_title %}\n                    <sw-field type="text"\n                              :label="$tc(\'sw-cms.elements.productSlider.config.label.title\')"\n                              :placeholder="$tc(\'sw-cms.elements.productSlider.config.placeholder.title\')"\n                              v-model="element.config.title.value">\n                    </sw-field>\n                {% endblock %}\n\n                {% block sw_cms_element_recently_seen_product_slider_config_settings_display_mode %}\n                    <sw-select-field :label="$tc(\'sw-cms.elements.general.config.label.displayMode\')"\n                                     v-model="element.config.displayMode.value">\n                        <option value="standard">{{ $tc(\'sw-cms.elements.general.config.label.displayModeStandard\') }}</option>\n                        <option value="cover">{{ $tc(\'sw-cms.elements.general.config.label.displayModeCover\') }}</option>\n                        <option value="contain">{{ $tc(\'sw-cms.elements.general.config.label.displayModeContain\') }}</option>\n                    </sw-select-field>\n                {% endblock %}\n\n                {% block sw_cms_element_recently_seen_product_slider_config_settings_vertical_align %}\n                    <sw-select-field :label="$tc(\'sw-cms.elements.general.config.label.verticalAlign\')"\n                                     v-model="element.config.verticalAlign.value"\n                                     :placeholder="$tc(\'sw-cms.elements.general.config.label.verticalAlign\')">\n                        <option value="flex-start">{{ $tc(\'sw-cms.elements.general.config.label.verticalAlignTop\') }}</option>\n                        <option value="center">{{ $tc(\'sw-cms.elements.general.config.label.verticalAlignCenter\') }}</option>\n                        <option value="flex-end">{{ $tc(\'sw-cms.elements.general.config.label.verticalAlignBottom\') }}</option>\n                    </sw-select-field>\n                {% endblock %}\n\n                {% block sw_cms_element_recently_seen_product_slider_config_settings_navigation %}\n                    <sw-field type="switch"\n                              bordered\n                              :label="$tc(\'sw-cms.elements.productSlider.config.label.navigation\')"\n                              v-model="element.config.navigation.value">\n                    </sw-field>\n                {% endblock %}\n\n                {% block sw_cms_element_recently_seen_product_slider_config_settings_rotate %}\n                    <sw-field type="switch"\n                              bordered\n                              :label="$tc(\'sw-cms.elements.productSlider.config.label.rotate\')"\n                              v-model="element.config.rotate.value">\n                    </sw-field>\n                {% endblock %}\n\n                {% block sw_cms_element_recently_seen_product_slider_config_settings_border %}\n                    <sw-field type="switch"\n                              bordered\n                              :label="$tc(\'sw-cms.elements.productSlider.config.label.border\')"\n                              v-model="element.config.border.value">\n                    </sw-field>\n                {% endblock %}\n\n                {% block sw_cms_element_recently_seen_product_slider_config_settings_min_width %}\n                    <sw-field type="text"\n                              :label="$tc(\'sw-cms.elements.productSlider.config.label.minWidth\')"\n                              :placeholder="$tc(\'sw-cms.elements.productSlider.config.placeholder.minWidth\')"\n                              v-model="element.config.elMinWidth.value">\n                    </sw-field>\n                {% endblock %}\n\n                {% block sw_cms_element_recently_seen_product_slider_config_settings_include_price %}\n                    <sw-field type="switch"\n                              bordered\n                              :label="$tc(\'sw-cms.elements.recentlyViewedProductSlider.config.label.includePrice\')"\n                              v-model="element.config.includePrice.value">\n                    </sw-field>\n                {% endblock %}\n\n                {% block sw_cms_element_recently_seen_product_slider_config_settings_include_action %}\n                    <sw-field type="switch"\n                              bordered\n                              :label="$tc(\'sw-cms.elements.recentlyViewedProductSlider.config.label.includeAction\')"\n                              v-model="element.config.includeAction.value">\n                    </sw-field>\n                {% endblock %}\n\n                {% block sw_cms_element_recently_seen_product_slider_config_settings_include_rating %}\n                <sw-field type="switch"\n                          bordered\n                          :label="$tc(\'sw-cms.elements.recentlyViewedProductSlider.config.label.includeRating\')"\n                          v-model="element.config.includeRating.value">\n                </sw-field>\n                {% endblock %}\n            </sw-container>\n        {% endblock %}\n    </div>\n{% endblock %}\n'},uGW7:function(e,n,t){var i=t("AIUv");"string"==typeof i&&(i=[[e.i,i,""]]),i.locals&&(e.exports=i.locals);(0,t("SZ7m").default)("7b864047",i,!0,{})}},[["05Ai","runtime","vendors-node"]]]);