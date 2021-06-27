<?php

namespace RichTestani\ManFox\Models;

use Illuminate\Support\Model;

class StoreModel extends Model
{
    //
    protected $table = 'manfox_stores';

    protected $fillable = [
      'store_version_uri',
      'store_name',
      'store_domain',
      'use_remote_domain',
      'store_url',
      'receipt_continue_url',
      'store_email',
      'from_email',
      'use_email_dns',
      'bcc_on_receipt_email',
      'postal_code',
      'region',
      'country',
      'locale_code',
      'timezone',
      'hide_currency_symbol',
      'hide_decimal_characters',
      'use_international_currency_symbol',
      'language',
      'logo_url',
      'checkout_type',
      'use_webhook',
      'webhook_url',
      'webhook_key',
      'use_cart_validation',
      'use_single_sign_on',
      'single_sign_on_url',
      'customer_password_hash_type',
      'customer_password_hash_config',
      'features_multiship',
      'products_require_expires_property',
      'app_session_time',
      'shipping_address_type',
      'require_signed_shipping_rates',
      'unified_order_entry_password',
      'affiliate_id',
      'is_maintenance_mode',
      'is_active',
      'first_payment_date',
      'date_created',
      'date_modified',
      'store_id',
      'last_cached'
    ];

}
