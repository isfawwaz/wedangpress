<?php

namespace Batik\Traits\Columns;

class HotelColumn extends HotelBase {

    public function hotelName( $item ) {
        $attendance = $item->attendance;

        $sup = '';
        if( $item['reg_count'] == 1 ) {
            $sup = '<sup><div class="dashicons dashicons-star-filled lt-blue-icon ee-icon-size-8"></div></sup>';
        }

        $viewLink = $this->registrationDetailLink( $item->id );

        $el = '<a href="'. $viewLink .'" title="View Registration Details">' . $attendance->fullname . '</a>';
        $el .= $sup;
        $el .= ' (' . $item->reg_count . ' / ' . $item->reg_group_size . ')<br/>';
        $el .= 'Reg Code: ' . $item['reg_code'] . '<br />';
        $el .= '<i class="'. $item->statusTextClasses.'">'. ucwords( strtolower( unslugify( $item->statusName ) ) ).'</i>';

        if( empty( $item->deleted_at ) || $item->transaction->paid == $item->transaction->total ) {
            $el .= '<div class="row-actions">
                <span class="trash">
                    <a href="'. $this->registrationTrashLink( $item->id ).'" title="Trash Registration">Trash</a>
                </span>
            </div>';
        } else {
            $el .= '<div class="row-actions">
                <span class="restore">
                    <a href="'. $this->registrationRestoreLink( $item->id ).'" title="Restore Registration">Restore</a>
                </span>
            </div>';
        }

        return $el;
    }

    public function hotelDetail( $item ) {
        $editLink = $this->editLink( $item->hotel_id );
        $filterLink = $this->registrationFilterLink( $item->hotel_id );
        $room = $item->hotel;

        $el = '<a href="'. $editLink .'" class="gg-color-dte">'. $room->post_title .'</a>';
        $el .= '<div class="row-actions">
            <span class="hotel_filter">
                <a href="'. $filterLink .'" title="Filter this list to only show registrations for '. $room->post_title.'">View Registrations</a>
            </span>
        </div>';

        return $el;
    }

    public function hotelPrice( $item ) {
        $transaction = $item->transaction;
        $price = $transaction->total ?: 0;

        return 'Rp ' . number_format( $price );
    }

    public function hotelActions( $item ) {
        $detailLink = $this->registrationDetailLink( $item->id );

        $el = '<ul class="reg-overview-actions-ul actions-ul">';

            // Edit Registration Detail
            $el .= '<li>
                <a href="'. $detailLink .'" title="View Registration Details" class="tiny-text">
                    <div class="dashicons dashicons-clipboard"></div>
                </a>
            </li>';

            // Edit Attendance Detail
            $el .= '<li>
                <a href="'. $this->contactEditLink( $item->attendance->id ).'" class="tiny-text">
                    <div class="ee-icon ee-icon-user-edit ee-icon-size-16"></div>
                </a>
            </li>';

            // Resend Email Registration Details
            $el .= '<li>
                <a href="#" title="Resend Registration Details" class="tiny-text">
                    <div class="dashicons dashicons-email-alt"></div>
                </a>
            </li>';

            // View Transaction Details
            $el .= '<li>
                <a class="tiny-text" href="'. $this->transactionDetailLink( $item->transaction_id ).'" title="View Transaction Details">
                    <div class="dashicons dashicons-cart"></div>
                </a>
            </li>';

            // View Transaction Invoice
            if( $item->transaction->total != $item->transaction->paid || $item->transaction->status_id != 35 ) {
                $el .= '<li>
                    <a title="View Transaction Invoice" target="_blank" href="'. get_report_invoice_link( $item->reg_code, $item->transaction_id ).'" class="tiny-text">
                        <span class="dashicons dashicons-media-spreadsheet ee-icon-size-18"></span>
                    </a>
                </li>';
            }

        $el .= '</ul>';

        return $el;
    }

    public function hotelTransactionDate( $item ) {
        $transaction = $item->transaction;
        $transactionLink = $this->transactionDetailLink( $item->transaction_id );
        $date = $transaction->timestamp;
        $dateFormatted = $date->format( get_option('date_format') . ' ' . get_option('time_format'));

        $el = '<a href="'. $transactionLink .'" title="View Transaction Details">'. $dateFormatted.'</a><br />';

        $el .= '<i>'. $transaction->textStatusColored .'</i>';

        return $el;
    }

    public function transactionPaid( $item ) {
        $transaction = $item->transaction;
        $price = $transaction->paid ?: 0;

        return 'Rp ' . number_format( $price );
    }

    public function transactionDate( $item ) {
        $transaction = $item->transaction;
        $transactionLink = $this->transactionDetailLink( $item->transaction_id );
        $date = $transaction->timestamp;
        $dateFormatted = $date->format( get_option('date_format') . ' ' . get_option('time_format'));

        $el = '<a href="'. $transactionLink .'" title="View Transaction Details">'. $dateFormatted.'</a><br />';

        $el .= '<i>'. $transaction->textStatusColored .'</i>';

        return $el;
    }

    public function transactionRegistrant( $item ) {
        $registration = $item->hotel_registration;
        $attendance = $registration->attendance;

        // View Detail Registrant
        $el = '<a href="'. $this->registrationDetailLink( $registration->id ).'" title="View Registration Details">'. $attendance->fullname .'</a>';

        // Registrant Email
        $el .= '<br/><span>'. $attendance->email .'</span>';

        return $el;
    }

    public function transactionRoom( $item ) {
        $registration = $item->hotel_registration;
        $room = $registration->hotel;

        // View Filter
        $el = '<a href="'. $this->editLink( $room->ID ).'" title="View Registration Details">'. $room->post_title .'</a>';

        if( empty($_REQUEST['hotel_id']) ) {
            $el .= '<div class="row-actions">
                <a href="'. $this->transactionFilterLink( $room->ID ) .'" class="edit" title="View Transactions for this room">View Transactions for this room</a>
            </div>';
        }

        return $el;
    }

    public function transactionActions( $item ) {
        $detailLink = $this->transactionDetailLink( $item->id );

        $el = '<ul class="reg-overview-actions-ul actions-ul">';

            // View Transaction Detail
            $el .= '<li>
                <a href="'. $detailLink .'" title="View Registration Details" class="tiny-text">
                    <div class="dashicons dashicons-cart"></div>
                </a>
            </li>';

            // View Transaction Invoice
            $el .= '<li>
                <a title="View Transaction Invoice" target="_blank" href="'. get_report_invoice_link( $item->hotel_registration->reg_code, $item->id ).'" class="tiny-text">
                    <span class="dashicons dashicons-media-spreadsheet ee-icon-size-18"></span>
                </a>
            </li>';

            // View Transaction Receipt
            $el .= '<li>
                <a title="View Transaction Receipt" target="_blank" href="'. get_report_receipt_link( $item->hotel_registration->reg_code, $item->id ).'" class="tiny-text">
					<span class="dashicons dashicons-media-default ee-icon-size-18"></span>
				</a>
            </li>';

            // View Registration Detail
            $el .= '<li>
                <a href="'. $this->registrationDetailLink( $item->hotel_registration->id ) .'" title="View Registration Details" class="tiny-text">
                    <div class="dashicons dashicons-clipboard"></div>
                </a>
            </li>';

        $el .= '</ul>';

        return $el;
    }

    public function contactFullName( $item ) {
        $editLink = $this->contactEditLink( $item->id );

        $el = '<a href="'. $editLink .'" class="gg-color-dte">'. $item->attendance->post_title .'</a>';

        if( empty($item->deleted_at) ) {
            $el .= '<div class="row-actions">
                <a href="'. $editLink .'" class="edit" title="Edit Attendance">Edit</a>
                &nbsp;|&nbsp;
                <span class="trash">
                    <a href="'. $this->contactTrashLink( $item->id ).'" title="Trash Attendance">Trash</a>
                </span>
            </div>';
        } else {
            $restoreLink = $this->contactRestoreLink( $item->id );

            $el .= '<div class="row-actions">
                <a href="'. $restoreLink .'" class="edit" title="Restore Attendance">Restore</a>
            </div>';
        }

        return $el;
    }

    public function contactRegistrantCount( $item ) {
        $filterLink = $this->contactFilterLink( $item->id );

        return '<a href="'. $filterLink .'" title="Filter registration by this contact">'. $item->hotel_registrations_count.'</a>';
    }
    
}