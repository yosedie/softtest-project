// Initialize Stripe with your public key
var stripe = Stripe('your-public-key'); // Replace 'your-public-key' with your actual Stripe public key
var elements = stripe.elements();

// Create and mount the card elements
var cardNumber = elements.create('cardNumber');
cardNumber.mount('#card-number-element');

var cardExpiry = elements.create('cardExpiry');
cardExpiry.mount('#card-expiry-element');

var cardCvc = elements.create('cardCvc');
cardCvc.mount('#card-cvc-element');

// Handle real-time validation errors from the card Element
cardNumber.addEventListener('change', function(event) {
    setOutcome(event);
});

cardExpiry.addEventListener('change', function(event) {
    setOutcome(event);
});

cardCvc.addEventListener('change', function(event) {
    setOutcome(event);
});

function setOutcome(result) {
    var errorElement = document.getElementById('card-errors');
    if (result.error) {
        errorElement.textContent = result.error.message;
    } else {
        errorElement.textContent = '';
    }
}

function stripeTokenHandler(token) {
    var form = document.getElementById('stripe-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);

    form.submit();
}

function createToken() {
    stripe.createToken(cardNumber).then(function(result) {
        if (result.error) {
            setOutcome(result);
        } else {
            stripeTokenHandler(result.token);
        }
    });
}

// Handle form submission
var form = document.getElementById('stripe-form');
form.addEventListener('submit', function(event) {
    event.preventDefault();
    createToken();
});
