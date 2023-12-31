(this.webpackJsonp=this.webpackJsonp||[]).push([["webkul-g-p-a"],{CkOj:function(e,t,n){"use strict";n.d(t,"a",(function(){return l}));var i=n("lSNA"),r=n.n(i),a=n("lO2t"),o=n("lYO9");function s(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var i=Object.getOwnPropertySymbols(e);t&&(i=i.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,i)}return n}function c(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?s(Object(n),!0).forEach((function(t){r()(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):s(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}function l(e){var t=function(e){var t;if(a.a.isString(e))try{t=JSON.parse(e)}catch(e){return!1}else{if(!a.a.isObject(e)||a.a.isArray(e))return!1;t=e}return t}(e);if(!t)return null;if(!0===t.parsed||!function(e){return void 0!==e.data||void 0!==e.errors||void 0!==e.links||void 0!==e.meta}(t))return t;var n=function(e){var t={links:null,errors:null,data:null,associations:null,aggregations:null};if(e.errors)return t.errors=e.errors,t;var n=function(e){var t=new Map;if(!e||!e.length)return t;return e.forEach((function(e){var n="".concat(e.type,"-").concat(e.id);t.set(n,e)})),t}(e.included);if(a.a.isArray(e.data))t.data=e.data.map((function(e){var i=u(e,n);return Object(o.f)(i,"associationLinks")&&(t.associations=c({},t.associations,{},i.associationLinks),delete i.associationLinks),i}));else if(a.a.isObject(e.data)){var i=u(e.data,n);Object.prototype.hasOwnProperty.call(i,"associationLinks")&&(t.associations=c({},t.associations,{},i.associationLinks),delete i.associationLinks),t.data=i}else t.data=null;e.meta&&Object.keys(e.meta).length&&(t.meta=g(e.meta));e.links&&Object.keys(e.links).length&&(t.links=e.links);e.aggregations&&Object.keys(e.aggregations).length&&(t.aggregations=e.aggregations);return t}(t);return n.parsed=!0,n}function u(e,t){var n={id:e.id,type:e.type,links:e.links||{},meta:e.meta||{}};e.attributes&&Object.keys(e.attributes).length>0&&(n=c({},n,{},g(e.attributes)));if(e.relationships){var i=function(e,t){var n={},i={};return Object.keys(e).forEach((function(r){var o=e[r];if(o.links&&Object.keys(o.links).length&&(i[r]=o.links.related),o.data){var s=o.data;a.a.isArray(s)?n[r]=s.map((function(e){return p(e,t)})):a.a.isObject(s)?n[r]=p(s,t):n[r]=null}})),{mappedRelations:n,associationLinks:i}}(e.relationships,t);n=c({},n,{},i.mappedRelations,{},{associationLinks:i.associationLinks})}return n}function g(e){var t={};return Object.keys(e).forEach((function(n){var i=e[n],r=n.replace(/-([a-z])/g,(function(e,t){return t.toUpperCase()}));t[r]=i})),t}function p(e,t){var n="".concat(e.type,"-").concat(e.id);return t.has(n)?u(t.get(n),t):e}},G7eP:function(e,t,n){"use strict";n.r(t);var i=n("pJEQ"),r=n("JDZS"),a=n("sHFX"),o=n.n(a);n("W7T4");const{Component:s,Mixin:c}=Shopware,{Criteria:l}=Shopware.Data;s.register("gpa-config",{template:o.a,inject:["repositoryFactory","GpaApiService"],mixins:[c.getByName("notification")],metaInfo(){return{title:this.$createTitle()}},data:()=>({config:{googleApiKey:null},isLoading:!1,processSuccess:!1}),created(){this.getConfig()},computed:{systemConfigRepository(){return this.repositoryFactory.create("system_config")}},methods:{getConfig(){const e=new l;e.setTerm("WebkulGpa.config."),this.systemConfigRepository.search(e,Shopware.Context.api).then(e=>{for(var t in e)"WebkulGpa.config.googleApiKey"==e[t].configurationKey&&(this.config.googleApiKey=e[t].configurationValue)})},onSaveConfig(){if(this.isLoading=!0,this.processSuccess=!0,""==this.config.googleApiKey)return this.isLoading=!1,this.processSuccess=!1,void this.createNotificationError({title:this.$t("gpa.config.errorTitle"),message:this.$t("gpa.config.errorGoogleApiKey")});this.GpaApiService.saveConfig(this.config).then(e=>{this.createNotificationSuccess({title:this.$t("gpa.config.successTitle"),message:this.$t("gpa.config.successMessage")}),this.isLoading=!1,this.processSuccess=!1})}}});var u=n("KtKu"),g=n.n(u);const{Component:p}=Shopware;p.override("sw-plugin-list",{template:g.a});const{Module:d}=Shopware;d.register("gpa-config",{type:"plugin",name:"Google Pin Address Configuration",title:"gpa.general.mainMenuItemGeneral",description:"sw-property.general.descriptionTextModule",icon:"default-documentation-pushpin",snippets:{"de-DE":i,"en-GB":r},routes:{index:{component:"gpa-config",path:"index",meta:{parentPath:"sw.settings.index"}}},settingsItem:{name:"wkgpa",to:"gpa.config.index",label:"gpa.general.mainMenuItemGeneral",group:"plugins",icon:"default-documentation-pushpin"}});var h=n("SwLI");class f extends h.default{constructor(e,t,n="gpa"){super(e,t,n)}saveConfig(e){const t=`${this.getApiBasePath()}/save/config`;return this.httpClient.post(t,{config:e},{headers:this.getBasicHeaders()}).then(e=>h.default.handleResponse(e))}}var v=f;const y=Shopware.Application;y.addServiceProvider("GpaApiService",e=>{const t=y.getContainer("init");return new v(t.httpClient,e.loginService)})},JDZS:function(e){e.exports=JSON.parse('{"gpa":{"general":{"subMenuItemGeneral":"Configuration","mainMenuItemGeneral":"Google Pin Address"},"config":{"errorTitle":"Error","errorGoogleApiKey":"Enter the Google Api Key","errorLatitude":"Enter your latitude","errorLongitude":"Enter Your Longitude","successTitle":"Success","successMessage":"Configuration is saved","saveButtonText":"Save","cardTitleGeneral":"General Setting","labelGoogleApiKey":"Google Api Key","placeholderGoogleApiKey":"Enter the google api key","labelLatitude":"Enter your latitude","placeholderLatitude":"Enter your latitude","labelLongitude":"Enter your Longitude","placeholderLongitude":"Enter your longitude","helpTextLongitude":"Longitude is used for default address to display on google map","helpTextLatitude":"Latitude is used for default address to display on google map","labelGoogleApiKeyLink":"For Google Api Key","googleApiKeyLink":"https://developers.google.com/maps/documentation/javascript/get-api-key","labelLatitudeLongitudeLink":"For Latitude and Longitude","latitudeLongitudeLink":"https://www.latlong.net/"}}}')},KtKu:function(e,t){e.exports="{% block sw_plugin_list_grid_columns_actions_settings %}\n    <template v-if=\"item.composerName === 'webkul/google-pin-address'\">\n        <sw-context-menu-item :routerLink=\"{ name: 'gpa.config.index' }\">\n            {{ $tc('sw-plugin.list.config') }}\n        </sw-context-menu-item>\n    </template>\n\n    <template v-else>\n        {% parent %}\n    </template>\n{% endblock %}\n"},SwLI:function(e,t,n){"use strict";n.r(t);var i=n("lwsE"),r=n.n(i),a=n("W8MJ"),o=n.n(a),s=n("CkOj"),c=function(){function e(t,n,i){var a=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"application/vnd.api+json";r()(this,e),this.httpClient=t,this.loginService=n,this.apiEndpoint=i,this.contentType=a}return o()(e,[{key:"getList",value:function(t){var n=t.page,i=void 0===n?1:n,r=t.limit,a=void 0===r?25:r,o=t.sortBy,s=t.sortDirection,c=void 0===s?"asc":s,l=t.sortings,u=t.queries,g=t.term,p=t.criteria,d=t.aggregations,h=t.associations,f=t.headers,v=t.versionId,y=t.ids,m=t["total-count-mode"],b=void 0===m?0:m;this.showDeprecationWarning("getList");var k=this.getBasicHeaders(f),w={page:i,limit:a};return l?w.sort=l:o&&o.length&&(w.sort=("asc"===c.toLowerCase()?"":"-")+o),y&&(w.ids=y.join("|")),g&&(w.term=g),p&&(w.filter=[p.getQuery()]),d&&(w.aggregations=d),h&&(w.associations=h),v&&(k=Object.assign(k,e.getVersionHeader(v))),u&&(w.query=u),b&&(w["total-count-mode"]=b),w.term&&w.term.length||w.filter&&w.filter.length||w.aggregations||w.sort||w.queries||w.associations?this.httpClient.post("".concat(this.getApiBasePath(null,"search")),w,{headers:k}).then((function(t){return e.handleResponse(t)})):this.httpClient.get(this.getApiBasePath(),{params:w,headers:k}).then((function(t){return e.handleResponse(t)}))}},{key:"getById",value:function(t){var n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},i=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};if(this.showDeprecationWarning("getById"),!t)return Promise.reject(new Error("Missing required argument: id"));var r=n,a=this.getBasicHeaders(i);return this.httpClient.get(this.getApiBasePath(t),{params:r,headers:a}).then((function(t){return e.handleResponse(t)}))}},{key:"updateById",value:function(t,n){var i=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{},r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:{};if(this.showDeprecationWarning("updateById"),!t)return Promise.reject(new Error("Missing required argument: id"));var a=i,o=this.getBasicHeaders(r);return this.httpClient.patch(this.getApiBasePath(t),n,{params:a,headers:o}).then((function(t){return e.handleResponse(t)}))}},{key:"deleteAssociation",value:function(e,t,n,i){if(this.showDeprecationWarning("deleteAssociation"),!e||!n||!n)return Promise.reject(new Error("Missing required arguments."));var r=this.getBasicHeaders(i);return this.httpClient.delete("".concat(this.getApiBasePath(e),"/").concat(t,"/").concat(n),{headers:r}).then((function(e){return e.status>=200&&e.status<300?Promise.resolve(e):Promise.reject(e)}))}},{key:"create",value:function(t){var n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},i=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};this.showDeprecationWarning("create");var r=n,a=this.getBasicHeaders(i);return this.httpClient.post(this.getApiBasePath(),t,{params:r,headers:a}).then((function(t){return e.handleResponse(t)}))}},{key:"delete",value:function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};if(this.showDeprecationWarning("delete"),!e)return Promise.reject(new Error("Missing required argument: id"));var i=Object.assign({},t),r=this.getBasicHeaders(n);return this.httpClient.delete(this.getApiBasePath(e),{params:i,headers:r})}},{key:"clone",value:function(t){return this.showDeprecationWarning("clone"),t?this.httpClient.post("/_action/clone/".concat(this.apiEndpoint,"/").concat(t),null,{headers:this.getBasicHeaders()}).then((function(t){return e.handleResponse(t)})):Promise.reject(new Error("Missing required argument: id"))}},{key:"versionize",value:function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};this.showDeprecationWarning("versionize");var i="/_action/version/".concat(this.apiEndpoint,"/").concat(e),r=Object.assign({},t),a=this.getBasicHeaders(n);return this.httpClient.post(i,{},{params:r,headers:a})}},{key:"mergeVersion",value:function(t,n,i,r){if(this.showDeprecationWarning("mergeVersion"),!t)return Promise.reject(new Error("Missing required argument: id"));if(!n)return Promise.reject(new Error("Missing required argument: versionId"));var a=Object.assign({},i),o=Object.assign(e.getVersionHeader(n),this.getBasicHeaders(r)),s="_action/version/merge/".concat(this.apiEndpoint,"/").concat(n);return this.httpClient.post(s,{},{params:a,headers:o})}},{key:"getApiBasePath",value:function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"",n="";return t&&t.length&&(n+="".concat(t,"/")),e&&e.length>0?"".concat(n).concat(this.apiEndpoint,"/").concat(e):"".concat(n).concat(this.apiEndpoint)}},{key:"getBasicHeaders",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},t={Accept:this.contentType,Authorization:"Bearer ".concat(this.loginService.getToken()),"Content-Type":"application/json"};return Object.assign({},t,e)}},{key:"showDeprecationWarning",value:function(e){Shopware.Utils.debug.warn("".concat(this.apiEndpoint," - Api Service"),"The ".concat(e," function is deprecated. Please use the 'repository.data.js' class for data handling of entities."))}},{key:"getApiVersion",value:function(){return Shopware.Context.api.apiVersion-1}},{key:"apiEndpoint",get:function(){return this.endpoint},set:function(e){this.endpoint=e}},{key:"httpClient",get:function(){return this.client},set:function(e){this.client=e}},{key:"contentType",get:function(){return this.type},set:function(e){this.type=e}}],[{key:"handleResponse",value:function(t){if(null===t.data||void 0===t.data)return t;var n=t.data,i=t.headers;return i&&i["content-type"]&&"application/vnd.api+json"===i["content-type"]&&(n=e.parseJsonApiData(n)),n}},{key:"parseJsonApiData",value:function(e){return Object(s.a)(e)}},{key:"getVersionHeader",value:function(e){return{"sw-version-id":e}}}]),e}();t.default=c},W7T4:function(e,t,n){var i=n("YnzL");"string"==typeof i&&(i=[[e.i,i,""]]),i.locals&&(e.exports=i.locals);(0,n("SZ7m").default)("04e1e4e6",i,!0,{})},YnzL:function(e,t,n){},lO2t:function(e,t,n){"use strict";n.d(t,"b",(function(){return L}));var i=n("GoyQ"),r=n.n(i),a=n("YO3V"),o=n.n(a),s=n("E+oP"),c=n.n(s),l=n("wAXd"),u=n.n(l),g=n("Z0cm"),p=n.n(g),d=n("lSCD"),h=n.n(d),f=n("YiAA"),v=n.n(f),y=n("4qC0"),m=n.n(y),b=n("Znm+"),k=n.n(b),w=n("Y+p1"),O=n.n(w),j=n("UB5X"),A=n.n(j);function L(e){return void 0===e}t.a={isObject:r.a,isPlainObject:o.a,isEmpty:c.a,isRegExp:u.a,isArray:p.a,isFunction:h.a,isDate:v.a,isString:m.a,isBoolean:k.a,isEqual:O.a,isNumber:A.a,isUndefined:L}},lYO9:function(e,t,n){"use strict";n.d(t,"g",(function(){return m})),n.d(t,"a",(function(){return b})),n.d(t,"c",(function(){return k})),n.d(t,"i",(function(){return w})),n.d(t,"h",(function(){return O})),n.d(t,"f",(function(){return j})),n.d(t,"b",(function(){return A})),n.d(t,"e",(function(){return L})),n.d(t,"d",(function(){return S}));var i=n("lSNA"),r=n.n(i),a=n("QkVN"),o=n.n(a),s=n("BkRI"),c=n.n(s),l=n("mwIZ"),u=n.n(l),g=n("D1y2"),p=n.n(g),d=n("JZM8"),h=n.n(d),f=n("lO2t");function v(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var i=Object.getOwnPropertySymbols(e);t&&(i=i.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,i)}return n}function y(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?v(Object(n),!0).forEach((function(t){r()(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):v(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}o.a,c.a,u.a,p.a,h.a;var m=o.a,b=c.a,k=u.a,w=p.a,O=h.a;function j(e,t){return Object.prototype.hasOwnProperty.call(e,t)}function A(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};return JSON.parse(JSON.stringify(e))}function L(e,t){return e===t?{}:f.a.isObject(e)&&f.a.isObject(t)?f.a.isDate(e)||f.a.isDate(t)?e.valueOf()===t.valueOf()?{}:t:Object.keys(t).reduce((function(n,i){if(!j(e,i))return y({},n,r()({},i,t[i]));if(f.a.isArray(t[i])){var a=S(e[i],t[i]);return Object.keys(a).length>0?y({},n,r()({},i,t[i])):n}if(f.a.isObject(t[i])){var o=L(e[i],t[i]);return!f.a.isObject(o)||Object.keys(o).length>0?y({},n,r()({},i,o)):n}return e[i]!==t[i]?y({},n,r()({},i,t[i])):n}),{}):t}function S(e,t){if(e===t)return[];if(!f.a.isArray(e)||!f.a.isArray(t))return t;if(e.length<=0&&t.length<=0)return[];if(e.length!==t.length)return t;if(!f.a.isObject(t[0]))return t.filter((function(t){return!e.includes(t)}));var n=[];return t.forEach((function(i,r){var a=L(e[r],t[r]);Object.keys(a).length>0&&n.push(t[r])})),n}},pJEQ:function(e){e.exports=JSON.parse('{"gpa":{"general":{"subMenuItemGeneral":"Aufbau","mainMenuItemGeneral":"Google Pin-Adresse"},"config":{"errorTitle":"Error","errorGoogleApiKey":"Geben Sie den Google Api-Schlüssel ein","errorLatitude":"Geben Sie Ihren Breitengrad ein","errorLongitude":"Geben Sie Ihre Länge ein","successTitle":"Erfolg","successMessage":"Konfiguration wird gespeichert","saveButtonText":"speichern","cardTitleGeneral":"Allgemeine Einstellung","labelGoogleApiKey":"Google API-Schlüssel","placeholderGoogleApiKey":"Geben Sie den Google API-Schlüssel ein","labelLatitude":"Geben Sie Ihren Breitengrad ein","placeholderLatitude":"Geben Sie Ihren Breitengrad ein","labelLongitude":"Geben Sie Ihre Länge ein","placeholderLongitude":"Geben Sie Ihre Länge ein","helpTextLongitude":"Der Längengrad wird als Standardadresse für die Anzeige auf Google Maps verwendet","helpTextLatitude":"Latitude wird als Standardadresse für die Anzeige auf Google Maps verwendet","labelGoogleApiKeyLink":"Für Google Api Schlüssel","googleApiKeyLink":"https://developers.google.com/maps/documentation/javascript/get-api-key","labelLatitudeLongitudeLink":"Für Breite und Länge","latitudeLongitudeLink":"https://www.latlong.net/"}}}')},sHFX:function(e,t){e.exports='{% block  gpa_config %}\n    <sw-page class="gpa-config-card">\n        {% block gpa_config_smart_bar_action %}\n            <template slot="smart-bar-actions">\n                <sw-button-process\n                    :disabled = "isLoading"\n                    variant = "primary"\n                    :processSuccess = "processSuccess"\n                    @click = "onSaveConfig">\n                    {{ $tc(\'gpa.config.saveButtonText\')}}\n                </sw-button-process>\n            </template>\n        {% endblock %}\n\n        {% block gpa_config_smart_bar_header %}\n            <template slot="smart-bar-header">\n                {% block gpa_config_smart_bar_header_title %}\n                    <h2>\n                        {% block gpa_config_smart_bar_header_title_text %}\n                        {{ $tc(\'sw-settings.index.title\') }} <sw-icon name="small-arrow-medium-right" small></sw-icon> \n                        {{ $tc(\'gpa.general.mainMenuItemGeneral\') }}\n                        {% endblock %}\n                    </h2>\n                {% endblock %}\n            </template>\n        {% endblock %}\n\n        {% block gpa_config_content %}\n            <template #content>\n                <sw-card-view>\n                    <sw-card :title="$tc(\'gpa.config.cardTitleGeneral\')">\n                        {% block gpa_config_google_api_key %}\n                            <sw-password-field \n                            :label="$tc(\'gpa.config.labelGoogleApiKey\')" \n                            :placeholder ="$tc(\'gpa.config.placeholderGoogleApiKey\')" \n                            validation="required" \n                            required  \n                            v-model="config.googleApiKey">\n                            </sw-password-field>\n                        {% endblock %}\n\n                        {% block gpa_config_get_google_lable %}\n                            <div class="gpa-config-card-google-link">\n                                <a :href="$tc(\'gpa.config.googleApiKeyLink\')" target="_blank" :title="$tc(\'gpa.config.labelGoogleApiKeyLink\')">\n                                    {{ $tc(\'gpa.config.labelGoogleApiKeyLink\')}}\n                                </a>\n                            </div>\n                        {% endblock %}\n                    </sw-card>\n                </sw-card-view>\n            </template>\n        {% endblock %}\n    </sw-page>\n{% endblock %}'}},[["G7eP","runtime","vendors-node"]]]);