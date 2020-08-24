<?php

namespace Batik\Models;

use Doctrine\Common\Inflector\Inflector;
use Maksimer\ORM\Eloquent\Model as EloquentModel;

abstract class Model extends EloquentModel {

    /**
     * Set primary key as ID, because WordPress
     *
     * @var string
     */
    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    /**
     * Overide parent method to make sure prefixing is correct.
     *
     * @return string
     */
    public function getTable()
    {
        global $wpdb;

        //In this example, it's set, but this is better in an abstract class
        if( isset( $this->table ) ){
            $prefix = $wpdb->base_prefix;
            $table = $this->table;
            $find = strpos($table, $prefix);
            
            if( $find !== false ) {
                return $table;
            }

            return $prefix . $this->table;
        }

        $table = str_replace( '\\', '', slugify( Inflector::pluralize( class_basename( $this ) ) ) );

        return $this->getConnection()->db->prefix . $table ;
    }

    protected function get_status_text_class_name() {
        if( !empty($this->deleted_at) ) {
            return 'text-status-cancelled';
        } else {
            if( !empty($this->status_id) ) {
                $statusId = $this->status_id;
    
                // Abandoned
                if(
                    in_array($statusId, $this->get_status_collection_abandoned())
                ) {
                    return 'text-status-abandoned';
                }
    
                // Complete
                if(
                    in_array($statusId, $this->get_status_collection_complete())
                ) {
                    return 'text-status-complete';
                }
    
                // Failed
                if(
                    in_array( $statusId, $this->get_status_collection_failed() )
                ) {
                    return 'text-status-failed';
                }

                // Overpaid
                if(
                    in_array( $statusId, $this->get_status_collection_overpaid() )
                ) {
                    return 'text-status-overpaid';
                }
    
                // Incomplete
                if(
                    in_array( $statusId, $this->get_status_collection_transaction_incomplete() ) 
                ) {
                    return 'text-status-incomplete';
                }
    
                /**
                 * Registration
                 */
                // Approved
                if(
                    in_array( $statusId, $this->get_status_collection_approved() )
                ) {
                    return 'text-status-approved';
                }
    
                // Pending Payment
                if(
                    in_array( $statusId, $this->get_status_collection_pending_payment() )
                ) {
                    return 'text-status-pending-payment';
                }
    
                // Wait List
                if(
                    in_array( $statusId, $this->get_status_collection_wait_list() )
                ) {
                    return 'text-status-wait-list';
                }
    
                // Incomplete
                if(
                    in_array( $statusId, $this->get_status_collection_incomplete() )
                ) {
                    return 'text-status-reg-incomplete';
                }
    
                // Not Approved
                if(
                    in_array( $statusId, $this->get_status_collection_not_approved() )
                ) {
                    return 'text-status-not-approved';
                }
    
                // Declined
                if(
                    in_array( $statusId, $this->get_status_collection_declined() )
                ) {
                    return 'text-status-declined';
                }
    
                // Cancelled
                if(
                    in_array( $statusId, $this->get_status_collection_cancelled() )
                ) {
                    return 'text-status-cancelled';
                }
    
            }
        }

        return;
    }

    protected function get_status_badge_class_name() {
        if( !empty($this->status_id) ) {
            $statusId = $this->status_id;

            // Abandoned
            if(
                in_array($statusId, $this->get_status_collection_abandoned())
                || in_array( $statusId, $this->get_status_collection_cancelled() ) 
            ) {
                return 'badge-dark';
            }

            // Complete
            if(
                in_array($statusId, $this->get_status_collection_complete())
                || in_array($statusId, $this->get_status_collection_approved())
            ) {
                return 'badge-success';
            }

            // Failed, Overpaid
            if(
                in_array( $statusId, $this->get_status_collection_failed() )
                || in_array( $statusId, $this->get_status_collection_overpaid() )
            ) {
                return 'badge-danger';
            }

            // Incomplete
            if(
                in_array( $statusId, $this->get_status_collection_incomplete() )
            ) {
                return 'badge-warning';
            }

            if(
                in_array( $statusId, $this->get_status_collection_transaction_incomplete() ) 
            ) {
                return 'badge-info';
            }

        }

        return;
    }

    protected function get_status_border_class_name() {

        if( !empty($this->deleted_at) ) {
            return 'gg-row-strip gg-strip-cancelled';
        } else {
            if( !empty($this->status_id) ) {
                $statusId = $this->status_id;

                /**
                 * REGISTRATION
                 */
    
                // Approved Status
                if( in_array( $statusId, $this->get_status_collection_approved() ) ) {
                    return 'gg-row-strip gg-strip-approved';
                }
    
                // Cancelled Status
                if( in_array( $statusId, $this->get_status_collection_cancelled() ) ) {
                    return 'gg-row-strip gg-strip-cancelled';
                }
    
                // Declined Status
                if( in_array( $statusId, $this->get_status_collection_declined() ) ) {
                    return 'gg-row-strip gg-strip-declined';
                }
    
                // Incomplete Status
                if( in_array( $statusId, $this->get_status_collection_incomplete() ) ) {
                    return 'gg-row-strip gg-strip-incomplete';
                }
    
                // Not Approved Status
                if( in_array( $statusId, $this->get_status_collection_not_approved() ) ) {
                    return 'gg-row-strip gg-strip-not-approved';
                }
    
                // Pending Payment Status
                if( in_array( $statusId, $this->get_status_collection_pending_payment() ) ) {
                    return 'gg-row-strip gg-strip-pending-payment';
                }
    
                // Wait List Status
                if( in_array( $statusId, $this->get_status_collection_wait_list() ) ) {
                    return 'gg-row-strip gg-strip-wait-list';
                }

                /**
                 * TRANSACTION
                 */
                
                // Abandoned
                if( in_array( $statusId, $this->get_status_collection_abandoned() ) ) {
                    return 'gg-row-strip gg-strip-abandoned';
                }

                // Complete
                if( in_array( $statusId, $this->get_status_collection_complete() ) ) {
                    return 'gg-row-strip gg-strip-complete';
                }

                // Failed
                if( in_array( $statusId, $this->get_status_collection_failed() ) ) {
                    return 'gg-row-strip gg-strip-failed';
                }

                // Incomplete
                if( in_array( $statusId, $this->get_status_collection_transaction_incomplete() ) ) {
                    return 'gg-row-strip gg-strip-txn-incomplete';
                }

                // Overpaid
                if( in_array( $statusId, $this->get_status_collection_overpaid() ) ) {
                    return 'gg-row-strip gg-strip-overpaid';
                }
            }
        }

        return;
    
    }

    private function get_status_collection_abandoned() {
        return [
            34, # TAB - Transaction Abandoned
        ];
    }
    
    private function get_status_collection_complete() {
        return [
            20, # PAP - Payment Approved
            35, # TCM - Transaction Complete
        ];
    }

    private function get_status_collection_failed() {
        return [
            22, # PDC - Payment Declined
            36, # TFL - Transaction Failed
        ];
    }

    private function get_status_collection_transaction_incomplete() {
        return [
            37, # TIN - Transaction Incomplete
        ];
    }

    private function get_status_collection_incomplete() {
        return [
            29, # RIC - Registration Incomplete
        ];
    }

    private function get_status_collection_overpaid() {
        return [
            38, // TOP - Transaction Overpaid
        ];
    }

    private function get_status_collection_approved() {
        return [
            26, # RAP - Registration Approved
        ];
    }

    private function get_status_collection_cancelled() {
        return [
            21, # PCN - Payment Cancelled
            27, # RCN - Registration Cancelled
        ];
    }

    private function get_status_collection_declined() {
        return [
            28, # RDC - Registration Declined
        ];
    }

    private function get_status_collection_not_approved() {
        return [
            23, # PFL - Payment Failed
            30, # RNA - Registration Not Approved
        ];
    }

    private function get_status_collection_pending_payment() {
        return [
            25, # PPN - Payment Pending
            31, # RPP - Registration Pending Payment
        ];
    }

    private function get_status_collection_wait_list() {
        return [
            32, # RWL - Registration Wait List
        ];
    }
}