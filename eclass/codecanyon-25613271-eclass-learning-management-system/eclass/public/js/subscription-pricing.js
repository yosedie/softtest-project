/**
 * cbToggleSubscription
 */
$(function () {
    function init() {
        subscribeCheckBoxEvents();
        restoreState();
    }

    function subscribeCheckBoxEvents() {
        /* stripe subscription */
        $("#cbToggleSubscription").change(function () {
            var isSubscriptionEnabled = $(this).is(":checked");
            toggleSubscriptionOption(isSubscriptionEnabled);
        });

        $("#cb111").change(function () {
            toggleBlockSubscriptionIfFree();
        });
    }

    function toggleSubscriptionOption(val) {
        if (val) {
            showSubscriptionOption();
        } else {
            hideSubscriptionOption();
        }
    }

    function showSubscriptionOption() {
        $("#stripeSubscriptionContainer").show("fast");
        updateBundleAsSubscriptionType();
    }

    function hideSubscriptionOption() {
        $("#stripeSubscriptionContainer").hide("fast");
        updateBundleAsNotSubscriptionType();
    }

    function restoreState() {
        toggleSubscriptionOption(isSubscriptionEnabled());
        toggleBlockSubscriptionIfFree();
    }

    function isSubscriptionEnabled() {
        var val = $("#is_subscription_enabled").val();
        return val == 1 || val == true;
    }

    function updateBundleAsNotSubscriptionType() {
        return $("#is_subscription_enabled").val("0");
    }

    function updateBundleAsSubscriptionType() {
        return $("#is_subscription_enabled").val("1");
    }

    function toggleBlockSubscriptionIfFree() {
        if (isFreePlan()) {
            $("#cbToggleSubscription").attr("disabled", true);
        } else {
            $("#cbToggleSubscription").removeAttr("disabled");
        }
    }

    function isFreePlan() {
        return !$("#cb111").is(":checked");
    }

    init();
});
