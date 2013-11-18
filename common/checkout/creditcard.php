<?php
    $calls = array(
        'get_payment_methods' => NULL,
        'get_months' => NULL,
        'get_years' => NULL
    );

    $data = api_request('payment', $calls, true);

    if (!empty($data['errors']) || !empty($data['data']['get_payment_methods']['errors'])) {
        $_SESSION['errors'] = api_errors_to_array($data, 'get_payment_methods');
    }
    else {
        $_data['payment_methods'] = $data['data']['get_payment_methods']['data'];
        // Set default payment method id
        if (empty($_SESSION['checkout_payment_method_id']) && !empty($_data['payment_methods'])) {
            $_SESSION['checkout_payment_method_id'] = $_data['payment_methods'][0]['payment_method_id'];
        }
    }

    $_data['months'] = $data['data']['get_months']['data'];

    $_data['years'] = $data['data']['get_years']['data'];


    $cc_payment = false;
    $paypal_payment = false;
?>
<form action="/action/shop/place_order.php" id="place_order_form" class="Form StaticForm payment" method="post">
<input id="gTotes" type="hidden" name="amount" value="<?= $_data['cart']['cart']['totals']['grand_total'] ?>" />
<fieldset>
    <h3>Payment Method</h3>
    <? if(!empty($_data['payment_methods'])): ?>
        <ul class="radios">
            <?
            foreach ($_data['payment_methods'] as $i => $payment_method) {
                $checked = (!empty($_SESSION['checkout_payment_method_id']) && $_SESSION['checkout_payment_method_id'] == $payment_method['payment_method_id'])? ' checked="checked"' : '';
                $selecto = (!empty($_SESSION['checkout_payment_method_id']) && $_SESSION['checkout_payment_method_id'] == $payment_method['payment_method_id'])? ' selectoBismol' : '';
                $cc_fields = ($payment_method['name'] == 'Credit Card') ? '1' : '0';
                $set_paypal = ($payment_method['name'] == 'PayPal') ? '1' : '0';
                if (!empty($checked) && $payment_method['name'] == 'Credit Card') {
                    $cc_payment = true;
                }
                else if (!empty($checked) && $payment_method['name'] == 'PayPal') {
                    $paypal_payment = true;
                }
                ?>
                <li class="pMets <?= $selecto ?>">
                    <input type="radio" id="payment_method_id-<?= $i ?>" name="payment_method_id" value="<?= $payment_method['payment_method_id'] ?>"<?= $checked.' '.$selecto ?> data-show_cc_fields="<?= $cc_fields ?>" data-show_set_paypal="<?= $set_paypal ?>" />
                </li><label for="payment_method_id-<?= $i ?>"><?= $payment_method['name'] ?></label>
            <?
            }
            ?>
        </ul>
    <? endif?>
</fieldset>

<? if (empty($_data['cart']['cart']['paypal_token'])): ?>
    <div style="<?= $paypal_payment ? '' : 'display:none;' ?>" id="set_paypal">
        <p>In order to use PayPal, we must direct you to their website to log in. Once logged in, you will be returned to confirm your order.</p>
        <p style="padding-bottom: 400px;"><a href="/common/checkout/paypal-express-checkout/set">Continue</a></p>
    </div>
<?php endif ?>

<fieldset id="credit_card_fields" style="<?= empty($_SESSION['checkout_payment_method_id']) || $cc_payment ? '' : 'display:none;' ?>">
    <ul class="fields">
        <li>
            <input type="text" id="cc_name" name="cc_name" placeholder="Name on card" />
        </li>
        <li>
            <input type="text" id="cc_number" name="cc_number" placeholder="Card Number" />
        </li>
        <li>
            <select id="cc_exp_month" name="cc_exp_month">
                <option value="">Exp Month</option>
                <?
                foreach ($_data['months'] as $month) {
                    ?>
                    <option value="<?= $month ?>"><?= $month ?></option>
                <?
                }
                ?>
            </select>
        </li>
        <li>
            <select id="cc_exp_year" name="cc_exp_year">
                <option value="">Exp Year</option>
                <?
                foreach ($_data['years'] as $year) {
                    ?>
                    <option value="<?= $year ?>"><?= $year ?></option>
                <?
                }
                ?>
            </select>
        </li>
        <li>
            <input type="text" id="cc_cvv" name="cc_cvv" placeholder="CVV" />
        </li>
    </ul>
</fieldset>

<p class="button checkout" style="<?= $paypal_payment && empty($_data['cart']['cart']['paypal_token']) ? 'display: none;' : '' ?>"><a onclick="$('#place_order_form').submit()">Place Order</a></p>
</form>