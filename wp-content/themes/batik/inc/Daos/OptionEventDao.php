<?php

namespace Batik\Daos;

class OptionEventDao {

    protected $optKey = 'wahaha_event_settings';

    protected $optCriticalPage = 'wahaha_event_critical_page_settings';

    public function getSetting(): array {
        $option = get_option( $this->optKey );
        if( !empty($option) ) {
            $option = unserialize( $option );
        } else {
            $option = [];
        }

        return $option;
    }

    public function getCriticalPages(): array {
        $option = get_option( $this->optCriticalPage );
        $result = [];

        if( !empty($option) ) {
            $result = unserialize( $option );
        }

        return $result;
    }

    public function getMaximumWaitPayment(): int {
        $setting = $this->getSetting();

        if( isset($setting['maximum_wait_for_payment']) ) {
            return $setting['maximum_wait_for_payment'];
        }

        return 30;
    }

    public function getMaximumWaitRegistration(): int {
        $setting = $this->getSetting();

        if( isset($setting['maximum_wait_registration']) ) {
            return $setting['maximum_wait_registration'];
        }

        return 30;
    }

    public function getPaymentShowPending(): int {
        $setting = $this->getSetting();

        if( isset($setting['payment']) ) {
            if( isset($setting['payment']['show_pending']) ) {
                return $setting['payment']['show_pending'];
            }
        }

        return 1;
    }

    public function getPaymentGatewayLogs(): int {
        $setting = $this->getSetting();

        if( isset($setting['payment']) ) {
            if( isset($setting['payment']['show_pending']) ) {
                return $setting['payment']['show_pending'];
            }
        }

        return ( 60 * 60 * 24 * 7 );
    }

    public function getCartPaymentMethods(): array {
        return [];
    }

    public function getPageCheckoutId(): int {
        $setting = $this->getCriticalPages();

        return $setting['checkout_page_id'];
    }

    public function getPageTransactionId(): int {
        $setting = $this->getCriticalPages();

        return $setting['transaction_page_id'];
    }

    public function getPageThankYouId(): int {
        $setting = $this->getCriticalPages();

        return $setting['thank_you_page_id'];
    }

    public function getPageCancelId(): int {
        $setting = $this->getCriticalPages();

        return $setting['cancelled_page_id'];
    }
}