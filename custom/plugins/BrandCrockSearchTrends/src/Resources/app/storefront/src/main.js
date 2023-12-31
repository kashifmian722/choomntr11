/*eslint no-undef: "error"*/
/*use jQuery*/
(function($){
    const brandCrockSearchTrends = {
        idName  : '#bc-search-trends',
        linkName: '.bc-search-trends-link',
        process : function () {
            //Decide to show the trends
            $('.header-search-input').on('click keyup',function () {
                ( $(this).val().length < 3 ) ?  $(brandCrockSearchTrends.idName).show() : $(brandCrockSearchTrends.idName).hide();
            }).on('blur',function () {
                if( $(brandCrockSearchTrends.idName+':hover').length == 0 ) {
                    $(brandCrockSearchTrends.idName).hide();
                }
            });
            //Submit the search form if there is no url
            $('.bc-search-trends-list').on('click',function () {
                const href = $(this).children(brandCrockSearchTrends.linkName).attr('href');
                if( href == '#' ) {
                    $('.header-search-input').val($(this).children(brandCrockSearchTrends.linkName).attr('title'));
                    $('.header-search-form').submit();
                }
            });
        }
    };
    $(document).ready(function () {
        //Activate the process only if the block exists
        if( $(brandCrockSearchTrends.idName).length > 0 ) {
            brandCrockSearchTrends.process();
        }
    });
})(jQuery);