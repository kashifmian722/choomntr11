(this.webpackJsonp=this.webpackJsonp||[]).push([["solid-product-videos"],{"3X5c":function(e,d){e.exports='{% block sw_product_image %}\n  {% block pv_product_image %}\n    <div class="sw-product-image" :class="productImageClasses">\n      <template v-if="!isPlaceholder">\n        {% block sw_product_image_preview %}\n          <sw-media-preview-v2 class="sw-product-image__image"\n            :source="mediaId"\n            :hideTooltip="false">\n          </sw-media-preview-v2>\n          <sw-label\n            v-if="isCover"\n            class="sw-product-image__cover-label"\n            variant="primary"\n            size="medium"\n            appearance="pill">\n            {{ $tc(\'sw-product.mediaForm.coverSubline\') }}\n          </sw-label>\n        {% endblock %}\n\n        {% block pv_embedded_video_icon %}\n        <div\n          class="embedded-video-icon"\n          v-if="isEmbeddedVideo">\n          <sw-icon name="multicolor-action-play" color="#479ef8"></sw-icon>\n        </div>\n        {% endblock %}\n\n        <sw-context-button class="sw-product-image__context-button">\n          {% block sw_product_image_context %}\n            {% block sw_product_image_context_cover_action %}\n              {% block pv_cover_option %}\n                <sw-context-menu-item\n                  v-if="!isEmbeddedVideo && !isCover && mimeTypeGroup === \'image\'"\n                  @click="$emit(\'sw-product-image-cover\')">\n                  {{ $tc(\'global.sw-product-image.context.buttonAsCover\') }}\n                </sw-context-menu-item>\n              {% endblock %}\n            {% endblock %}\n\n            {% block sw_product_image_context_delete_action %}\n              <sw-context-menu-item\n              variant="danger"\n              @click="$emit(\'sw-product-image-delete\')">\n                {{ $tc(\'global.sw-product-image.context.buttonRemove\') }}\n              </sw-context-menu-item>\n            {% endblock %}\n          {% endblock %}\n        </sw-context-button>\n      </template>\n      <template v-else class="is--invalid-drag">\n        {% block sw_product_image_placeholder %}\n          <sw-icon\n          class="sw-product-image__placeholder-icon"\n          :name="\'default-object-image\'"\n          :small="true">\n          </sw-icon>\n        {% endblock %}\n      </template>\n    </div>\n  {% endblock %}\n{% endblock %}'},"7H/2":function(e,d){e.exports='{% block sw_media_index_smart_bar_media_upload %}\n  {% block pv_media_upload %}\n    <pv-media-upload\n      variant="compact"\n      fileAccept="image/*, video/*"\n      :targetFolderId="routeFolderId"\n      :uploadTag="uploadTag">\n    </pv-media-upload>\n  {% endblock %}\n{% endblock %}'},C1uG:function(e,d){e.exports='{% block sw_product_media_form_upload %}\n  <sw-upload-listener\n    v-if="!isLoading"\n    :uploadTag="product.id"\n    autoUpload\n    @media-upload-finish="successfulUpload"\n    @media-upload-fail="onUploadFailed">\n  </sw-upload-listener>\n  {% block pv_media_upload %}\n    <pv-media-upload\n      v-if="!isLoading && acl.can(\'product.editor\')"\n      :uploadTag="product.id"\n      variant="regular"\n      :scrollTarget="$parent.$el"\n      :defaultFolder="product.getEntityName()"\n      fileAccept="image/*, video/*"\n      @media-drop="$emit(\'media-drop\', $event)"\n      @media-upload-sidebar-open="onMediaUploadButtonOpenSidebar">\n    </pv-media-upload>\n  {% endblock %}\n{% endblock %}\n\n{% block sw_product_media_form_grid_items %}\n  <pv-product-image\n    v-for="mediaItem in mediaItems"\n    :key="mediaItem.id"\n    :isCover="isCover(mediaItem)"\n    :isPlaceholder="mediaItem.isPlaceholder"\n    :mediaId="mediaItem.mediaId"\n    :isEmbeddedVideo="isEmbeddedVideo(mediaItem)"\n    v-draggable="{ dragGroup: \'product-media\', data: mediaItem, onDragEnter: onMediaItemDragSort }"\n    v-droppable="{ dragGroup: \'product-media\', data: mediaItem }"\n    @sw-product-image-delete="removeFile(mediaItem)"\n    @sw-product-image-cover="markMediaAsCover(mediaItem)">\n  </pv-product-image>\n{% endblock %}'},"FT/F":function(e,d,i){"use strict";i.r(d);var t=i("JWjJ"),o=i("g5XT"),a=i("stjl"),n=i.n(a);i("jAxr");Shopware.Locale.extend("en-GB",t),Shopware.Locale.extend("de-DE",o);const{Context:s}=Shopware;Shopware.Component.extend("pv-media-upload","sw-media-upload-v2",{template:n.a,data:()=>({embeddedVideo:{url:"",source:"youtube",thumbnailId:""},embeddedVideoAddDisabled:!0}),watch:{"embeddedVideo.thumbnailId":{handler(e){this.onChangeEmbeddedVideoThumbnailId(e)}}},methods:{onChangeEmbeddedVideoUrl(e){e&&this.embeddedVideo.thumbnailId?this.embeddedVideoAddDisabled=!1:this.embeddedVideoAddDisabled=!0},onChangeEmbeddedVideoThumbnailId(e){e&&this.embeddedVideo.url?this.embeddedVideoAddDisabled=!1:this.embeddedVideoAddDisabled=!0},onClickEmbeddedVideoAdd(){this.mediaRepository.get(this.embeddedVideo.thumbnailId,s.api).then(e=>{e.customFields={pv_is_embedded_video:!0,pv_url:this.embeddedVideo.url,pv_source:this.embeddedVideo.source},this.embeddedVideo.url="",this.embeddedVideo.thumbnailId="",this.$emit("media-drop",e)})}}});var r=i("3X5c"),m=i.n(r);i("qQjW");const{Context:l}=Shopware;Shopware.Component.extend("pv-product-image","sw-product-image",{template:m.a,inject:["repositoryFactory"],props:{isEmbeddedVideo:{type:Boolean,required:!1}},data:()=>({trueSource:null}),computed:{mediaRepository(){return this.repositoryFactory.create("media")},mimeType(){return this.trueSource?this.trueSource instanceof File?this.trueSource.type:this.trueSource instanceof URL?"application/octet-stream":this.trueSource.mimeType:""},mimeTypeGroup(){return this.mimeType?this.mimeType.split("/")[0]:""}},watch:{mediaId(){this.fetchSourceIfNecessary()}},created(){this.createdComponent()},methods:{createdComponent(){this.fetchSourceIfNecessary()},fetchSourceIfNecessary(){this.mediaId&&("string"!=typeof this.mediaId||32!==this.mediaId.length?this.trueSource=this.mediaId:this.mediaRepository.get(this.mediaId,l.api).then(e=>{this.trueSource=e}))}}});var c=i("C1uG"),p=i.n(c);Shopware.Component.extend("pv-product-media-form","sw-product-media-form",{template:p.a,computed:{mediaRepository(){return this.repositoryFactory.create("media")}},methods:{createMediaAssociation(e){const d=this.productMediaRepository.create(Shopware.Context.api);return d.productId=this.product.id,d.mediaId=e,this.product.media.length<=0?(d.position=0,this.mediaRepository.get(d.mediaId,Shopware.Context.api).then(e=>{"image"===e.mimeType.split("/")[0]&&(this.product.coverId=d.id)})):d.position=this.product.media.length,d},isEmbeddedVideo:e=>!(!e.customFields||!e.customFields.pv_is_embedded_video)}});i("Z3u4");var u=i("ahAX"),b=i.n(u);Shopware.Component.override("sw-product-detail-base",{template:b.a});var v=i("7H/2"),h=i.n(v);Shopware.Component.override("sw-media-index",{template:h.a})},JWjJ:function(e){e.exports=JSON.parse('{"studiosolid-pv":{"pv-media-upload":{"tab-upload":{"title":"Upload"},"tab-embed":{"title":"Embed video","url":"Video url","url-help-text":"Please make sure to only use urls which just contain the video id and no other properties (e.g. https://www.youtube.com/watch?v=aBc123xYz)","source":"Video source","thumbnail":"Thumbnail","add":"Add to list"}}}}')},NTU9:function(e,d,i){},Z3u4:function(e,d){Shopware.Component.override("sw-product-detail",{methods:{addMedia(e){if(Shopware.State.commit("swProductDetail/setLoading",["media",!0]),this.product.media.has(e.id))return Shopware.State.commit("swProductDetail/setLoading",["media",!1]),Promise.reject("A media item with this id exists");const d=this.mediaRepository.create(Shopware.Context.api);return d.mediaId=e.id,e.customFields&&(d.customFields=e.customFields),new Promise(i=>{let t=!1,o=!1;return"video"===e.mimeType.split("/")[0]&&(t=!0),e.customFields&&e.customFields.pv_is_embedded_video&&(o=!0),0!==this.product.media.length||t||o||(d.position=0,this.product.coverId=d.id),this.product.media.add(d),Shopware.State.commit("swProductDetail/setLoading",["media",!1]),i(d.mediaId),!0})}}})},ahAX:function(e,d){e.exports='{% block sw_product_detail_base_media_card_form %}\n  <pv-product-media-form\n  v-if="mediaFormVisible"\n  :productId="isInherited ? parentProduct.id : product.id"\n  :key="isInherited"\n  :isInherited="isInherited"\n  :disabled="isInherited"\n  @media-drop="$emit(\'media-drop\', $event)"\n  @cover-change="$emit(\'cover-change\', $event)">\n  </pv-product-media-form>\n{% endblock %}'},g5XT:function(e){e.exports=JSON.parse('{"studiosolid-pv":{"pv-media-upload":{"tab-upload":{"title":"Upload"},"tab-embed":{"title":"Video einbetten","url":"Video Url","url-help-text":"Bitte verwenden Sie nur Urls, in denen lediglich die Video-ID und keine anderen Eigenschaften vorkommen (z.B. https://www.youtube.com/watch?v=aBc123xYz)","source":"Video Quelle","thumbnail":"Vorschaubild","add":"Zur Liste hinzufügen"}}}}')},jAxr:function(e,d,i){var t=i("sTKY");"string"==typeof t&&(t=[[e.i,t,""]]),t.locals&&(e.exports=t.locals);(0,i("SZ7m").default)("912b2e4c",t,!0,{})},qQjW:function(e,d,i){var t=i("NTU9");"string"==typeof t&&(t=[[e.i,t,""]]),t.locals&&(e.exports=t.locals);(0,i("SZ7m").default)("5024c38c",t,!0,{})},sTKY:function(e,d,i){},stjl:function(e,d){e.exports='{% block sw_media_upload_v2_regular %}\n  {% block pv_media_upload_regular %}\n    <div v-if="variant == \'regular\'" class="sw-media-upload-v2__content">\n      <sw-tabs variant="minimal" defaultItem="upload-media">\n        <template v-slot="{ active }">\n          <sw-tabs-item\n            variant="minimal"\n            name="upload-media"\n            :activeTab="active">\n              {{ $t(\'studiosolid-pv.pv-media-upload.tab-upload.title\') }}\n          </sw-tabs-item>\n          <sw-tabs-item\n            variant="minimal"\n            name="embed-video"\n            :activeTab="active">\n              {{ $t(\'studiosolid-pv.pv-media-upload.tab-embed.title\') }}\n          </sw-tabs-item>\n        </template>\n        <template v-slot:content="{ active }">\n          <div v-show="active === \'upload-media\'">\n            {% parent %}\n          </div>\n          <div v-show="active === \'embed-video\'">\n            <sw-container\n              columns="1fr 1fr"\n              gap="30px">\n              <sw-container>\n                <div>\n                  <sw-help-text\n                  class="video-url-help-text"\n                  :text="$t(\'studiosolid-pv.pv-media-upload.tab-embed.url-help-text\')"\n                  :width="450">\n                  </sw-help-text>\n                  <sw-text-field\n                    :label="$t(\'studiosolid-pv.pv-media-upload.tab-embed.url\')"\n                    v-model="embeddedVideo.url"\n                    @input="onChangeEmbeddedVideoUrl">\n                  </sw-text-field>\n                </div>\n                <sw-media-field\n                  :label="$t(\'studiosolid-pv.pv-media-upload.tab-embed.thumbnail\')"\n                  v-model="embeddedVideo.thumbnailId">\n                </sw-media-field>\n              </sw-container>\n              <sw-radio-field\n                :label="$t(\'studiosolid-pv.pv-media-upload.tab-embed.source\')"\n                :options="[\n                  {\'value\': \'youtube\', \'name\': \'YouTube\'},\n                  {\'value\': \'vimeo\', \'name\': \'Vimeo\'},\n                ]"\n                v-model="embeddedVideo.source">\n              </sw-radio-field>\n            </sw-container>\n            <sw-container\n              justify="end">\n              <sw-button\n                variant="primary"\n                :disabled="embeddedVideoAddDisabled"\n                @click="onClickEmbeddedVideoAdd">\n                  {{ $t(\'studiosolid-pv.pv-media-upload.tab-embed.add\') }}\n              </sw-button>\n            </sw-container>\n          </div>\n        </template>\n      </sw-tabs>\n    </div>\n  {% endblock %}\n{% endblock %}'}},[["FT/F","runtime","vendors-node"]]]);