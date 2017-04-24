var app = (function ($){

    this.toggleCards = function (playerContainer) {
        var playerCards = playerContainer.find('.player-cards'),
            isHidden = playerCards.is('.player-cards-hidden');

        playerContainer.find('.player-hand-score, .player-option-bet').toggleClass('hidden');
        playerCards.toggleClass('player-cards-hidden');

        if (isHidden) {
            var timesViewed = playerContainer.find(".player-option-times-viewed");
            timesViewed.data('value', parseInt(timesViewed.data('value'), 10) + 1);
            timesViewed.text(timesViewed.data('value'));

            playerContainer.find('.player-option-toggle-cards').button('toggle').button('viewing');
            playerContainer.find('.player-option-bet-input').slider('relayout');
        } else {
            playerContainer.find('.player-option-toggle-cards').button('toggle').button('reset');
        }
    };

    return this;
}) (jQuery);