$(function () {
    $('.loading').remove();

    if (FIRST_SIGHT) {
        $('.the-content').fadeIn(1000);
    }

    /**
     * wechat icon click event
     *
     */
    $(document).on('click', '.fa-wechat', function () {
        edsUI.html('wechat', $('#wechat-modal').html());
    })

})