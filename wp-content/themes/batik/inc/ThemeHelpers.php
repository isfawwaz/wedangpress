<?php

use Batik\Models\KaraokeRoomPrice;
use Carbon\Carbon;
use Batik\Traits\Data\TableName;

function get_post_custom_meta( $post, $name, $single = true ) {
    if( empty($post) ) {
        $post = get_the_ID();
    }

    return get_post_meta( $post, $name, $single );
}

/**
 * Get current url
 */
function get_current_uri() {

	$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') 
                === FALSE ? 'http' : 'https';
	$host     = $_SERVER['HTTP_HOST'];
	$script   = $_SERVER['SCRIPT_NAME'];
	$params   = $_SERVER['QUERY_STRING'];
	
	$currentUrl = $protocol . '://' . $host . $script . '?' . $params;
	
	return $currentUrl;
}

/**
 * Get current url query string
 */
function get_current_query_str( $key ) {
	$result = [];
	$params = $_SERVER['QUERY_STRING'];
	$params = explode('&', $params);
	foreach( $params as $item ) {
		$a = explode('=', $item);
		$result[ $a[0] ] = $a[1];
	}

	return $result;
}

/**
 * Get the room gallery list
 */
function get_the_room_gallery( $post = 0 ) {
	$gallery = get_post_custom_meta( $post, '_room_galleries', false );
	$galleries = [];

	foreach( $gallery as $g ) {
		$it = get_post( $g );
		$image = wp_get_attachment_image_src( $g, 'full' );

		$galleries[] = [
			'url' => $image[0]
		];
	}

	return $galleries;
}

/**
 * Print the room gallery
 */
function the_room_gallery( $echo = true ) {
	// 
}

/**
 * Get the room price
 */
function get_the_room_price( $pos = null ) {
	global $post;

	// $price = get_post_custom_meta( $post, '_room_information_price', true ) ?: 0;
	$price = 0;
	$id = empty($pos) ? $post->ID : $pos;

	$price = KaraokeRoomPrice::byRoomId( $id )->byNow()->first();
	if( empty($price) ) {
		$price = KaraokeRoomPrice::byRoomId( $id )->byDefault()->first();
	}

	if( !empty($price) ) {
		$final = $price->price;
	} else {
		$final = 0;
	}

	return $final;
}

/**
 * Print the room price
 */
function the_room_price( $echo = true ) {
    $price = get_the_room_price();
    $price = "Rp " . number_format( $price, 0, ".", ",");
    
    if( $echo ) {
        echo $price;
    } else {
        return $price;
    }
}

/**
 * Get the room minimal guest
 */
function get_the_room_min_guest( $post = null ) {
	$min = get_post_custom_meta( $post, '_room_information_min', true );

	return $min ?: 1;
}

/**
 * Print the room minimal guest
 */
function the_room_min_guest( $echo = true ) {
    $min = get_the_room_min_guest();
    $min = number_format($min);

    if( $echo ) {
        echo $min;
    } else {
        return $min;
    }
}

/**
 * Get the room maximal guest
 */
function get_the_room_max_guest( $post = null ) {
    $max = get_post_custom_meta( $post, '_room_information_max', true );

	return $max ?: 1;
}

/**
 * Print the room maximal guest
 */
function the_room_max_guest( $echo = true ) {
    $max = get_the_room_max_guest();
    $max = number_format( $max );

    if( $echo ) {
        echo $echo;
    } else {
        return $echo;
    }
}

/**
 * Get the room capacity from min and max
 */
function get_the_room_capacity( $post = null ) {
    $min = get_the_room_min_guest( $post );
    $max = get_the_room_max_guest( $post );

    return [ $min, $max ];
}

/**
 * Print the room capacity from min and max
 */
function the_room_capacity( $echo = true ) {
    $capacity = get_the_room_capacity();
    $data = $capacity[0] . ' - ' . $capacity[1] . ' ' . __('Guest', 'gragas');

    if( $echo ) {
        echo $data;
    } else {
        return $data;
    }
}

/**
 * Print Booking Room Form
 */
function the_room_booking_form( $echo = true ) {
	$min = get_the_room_min_guest() ?: 1;
	$max = get_the_room_max_guest() ?: 1;

	$options = [];

	for( $i = $min; $i <= $max; $i++ ) {
		$options[] = '<option value="'. $i .'">'. $i .'</option>';
	}

	$el = '<div class="room-booking-section">
		<form action="'. admin_url('admin-ajax.php').'" method="POST" class="form" name="room-booking">
			<input type="hidden" name="action" value="room-process-booking">
			<input type="hidden" name="room-id" value="'. get_the_ID() .'">
			<table class="event-info" cellpadding="14">
				<tr>
					<td class="align-text-top px-0" width="200"><b>Guest:</b></td>
					<td class="text-right px-0">
						<select name="total-guest" id="field-total-guest">'. implode("\n", $options) .'</select>
					</td>
				</tr>
			</table>
			<div class="text-right">
				<button type="submit" class="btn btn-sm btn-primary">Book Room</button>
			</div>
		</form>
	</div>';

	if( $echo ) {
		echo $el;
	} else {
		return $el;
	}
}

/**
 * Get the lounge price
 */
function get_the_lounge_price( $post = null ) {
	return get_post_custom_meta( $post, '_lounge_information_price', true ) ?: 0;
}

/**
 * Print the price of lounge
 */
function the_lounge_price( $echo = true, $post = null ) {
	$price = get_the_lounge_price( $post );
    $price = "Rp " . number_format( $price, 0, ",", ".");
    
    if( $echo ) {
        echo $price;
    } else {
        return $price;
    }
}

/**
 * Get the lounge capacity
 */
function get_the_lounge_capacity( $post = null ) {
	return get_post_custom_meta( $post, '_lounge_information_max', true ) ?: 0;
}

/**
 * Print lounge capacity
 */
function the_lounge_capacity( $echo = true ) {
	$capacity = get_the_lounge_capacity();
	$capacity = number_format( $capacity, 0, ',', '.');

	if( $echo ) {
		echo $capacity;
	} else {
		return $capacity;
	}
}

/**
 * Get the lounge free entry
 */
function get_the_lounge_free_entry( $post = null ) {
	return get_post_custom_meta( $post, '_lounge_information_free_entry', true ) ?: 0;
}

/**
 * Print lounge entry
 */
function the_lounge_free_entry( $echo = true, $post = null ) {
	$data = get_the_lounge_free_entry( $post );
	if( $data > 0 ) {
		$data = number_format( $data, 0, ',', '.' );
		$data = '(+' . $data . ' Free Entry)';

		if( $echo ) {
			echo $data;
		} else {
			return $data;
		}
	}

	return;
}

/**
 * Get the hotel room price
 */
function get_the_hotel_price( $post = null ) {
	return get_post_custom_meta( $post, '_hotel_information_price', true ) ?: 0;
}

/**
 * Print the price of hotel room
 */
function the_hotel_price( $echo = true, $post = null ) {
	$price = get_the_hotel_price( $post );
	$price = "Rp " . number_format( $price, 0, ',', '.' );

	if( $echo ) {
		echo $price;
	} else {
		return $price;
	}
}

/**
 * Get the hotel room availability
 */
function get_the_hotel_capacity( $post = null ) {
	return get_post_custom_meta( $post, '_hotel_information_availability', true ) ?: 0;
}

/**
 * Print the capacity of hotel room
 */
function the_hotel_capacity( $echo = true, $post = null ) {
	$capacity = get_the_hotel_capacity( $post );
	$capacity = number_format( $capacity, 0, ',', '.' );

	if( $echo ) {
		echo $capacity;
	} else {
		return $capacity;
	}
}

/**
 * Get the event thumbnail
 */
function get_the_event_thumbnail() {
	if( has_post_thumbnail() ) {
		$image = get_the_post_thumbnail_url();
	} else {
		$image = gragas_default_image();
	}

	return $image;
}

/**
 * Print the event thumbnail
 */
function the_event_thumbnail( $echo = true ) {
	$image = get_the_event_thumbnail();

	$el = '<img src="'. $image .'" alt="'. get_the_title() .'" class="img-fluid">';

	if( $echo == true ) {
		echo $el;
	} else {
		return $el;
	}
}

/**
 * Get the event start date
 */
function get_the_event_start_date() {
	$start_date = \EEH_Event_View::the_earliest_event_date( '', '', get_the_ID() );
	$start_date = !empty($start_date) ? Carbon::create($start_date) : Carbon::now();

	return $start_date;
}

/**
 * Print the event start date
 */
function the_event_start_date( $echo = true ) {
	$data = get_the_event_start_date();

	$el = '<div class="event-item__date">
		<span class="day">'. $data->format('d') .'</span>
		<span class="month">'. $data->format('M') .'</span>
		<span class="year">'. $data->format('Y') .'</span>
	</div>';

	if( $echo ) {
		echo $el;
	} else {
		return $el;
	}
}

function get_report_receipt_link( $reg_code, $transaction_id, $type = 'html' ) {
	$link = home_url('/');
	$link = add_query_arg('gg', 'msg-url-trigger-room', $link);
	$link = add_query_arg('snd_msgr', $type, $link);
	$link = add_query_arg('gen_msgr', 'html', $link);
	$link = add_query_arg('message_type', 'receipt', $link);
	$link = add_query_arg('context', 'purchaser', $link);
	$link = add_query_arg('token', $reg_code, $link);
	$link = add_query_arg('id', $transaction_id, $link );

	return $link;
}

function get_report_invoice_link( $reg_code, $transaction_id, $type = 'html' ) {
	$link = home_url('/');
	$link = add_query_arg('gg', 'msg-url-trigger-room', $link);
	$link = add_query_arg('snd_msgr', $type, $link);
	$link = add_query_arg('gen_msgr', 'html', $link);
	$link = add_query_arg('message_type', 'invoice', $link);
	$link = add_query_arg('context', 'purchaser', $link);
	$link = add_query_arg('token', $reg_code, $link);
	$link = add_query_arg('id', $transaction_id, $link );

	return $link;
}

function get_lounge_report_receipt_link( $reg_code, $transaction_id, $type = 'html' ) {
	$link = home_url('/');
	$link = add_query_arg('gg', 'msg-url-trigger-lounge', $link);
	$link = add_query_arg('snd_msgr', $type, $link);
	$link = add_query_arg('gen_msgr', 'html', $link);
	$link = add_query_arg('message_type', 'receipt', $link);
	$link = add_query_arg('context', 'purchaser', $link);
	$link = add_query_arg('token', $reg_code, $link);
	$link = add_query_arg('id', $transaction_id, $link );

	return $link;
}

function get_lounge_report_invoice_link( $reg_code, $transaction_id, $type = 'html' ) {
	$link = home_url('/');
	$link = add_query_arg('gg', 'msg-url-trigger-lounge', $link);
	$link = add_query_arg('snd_msgr', $type, $link);
	$link = add_query_arg('gen_msgr', 'html', $link);
	$link = add_query_arg('message_type', 'invoice', $link);
	$link = add_query_arg('context', 'purchaser', $link);
	$link = add_query_arg('token', $reg_code, $link);
	$link = add_query_arg('id', $transaction_id, $link );

	return $link;
}

function get_hotel_report_receipt_link( $reg_code, $transaction_id, $type = 'html' ) {
	$link = home_url('/');
	$link = add_query_arg('gg', 'msg-url-trigger-hotel', $link);
	$link = add_query_arg('snd_msgr', $type, $link);
	$link = add_query_arg('gen_msgr', 'html', $link);
	$link = add_query_arg('message_type', 'receipt', $link);
	$link = add_query_arg('context', 'purchaser', $link);
	$link = add_query_arg('token', $reg_code, $link);
	$link = add_query_arg('id', $transaction_id, $link );

	return $link;
}

function get_hotel_report_invoice_link( $reg_code, $transaction_id, $type = 'html' ) {
	$link = home_url('/');
	$link = add_query_arg('gg', 'msg-url-trigger-hotel', $link);
	$link = add_query_arg('snd_msgr', $type, $link);
	$link = add_query_arg('gen_msgr', 'html', $link);
	$link = add_query_arg('message_type', 'invoice', $link);
	$link = add_query_arg('context', 'purchaser', $link);
	$link = add_query_arg('token', $reg_code, $link);
	$link = add_query_arg('id', $transaction_id, $link );

	return $link;
}

function get_status_cancelled_list() {
	return [21,27,59,65,36];
}

function get_status_incomplete_list() {
	return [29,37,67,75];
}

function get_status_complete_list() {
	return [35,64,70,73];
}

function get_the_status_name( $statusId, $tableName ) {
	global $wpdb;
	
	$result = $wpdb->get_row(
		"
		SELECT *
		FROM `{$tableName}`
		WHERE `id` = '{$statusId}'
		"
	);

	if( !empty($result) ) {
		$text = ucfirst( strtolower( $result->name ) );

		// Cancelled Status
		if( in_array( $statusId, get_status_cancelled_list() ) ) {
			return '<span class="text-danger">'. $text .'</span>';
		}

		// Incomplete Status
		if( in_array( $statusId, get_status_incomplete_list() ) ) {
			return '<span class="text-warning">'. $text .'</span>';
		}

		// Complete Status
		if( in_array( $statusId, get_status_complete_list() ) ) {
			return '<span class="text-success">'. $text .'</span>';
		}

		return $text;
	}

	return;
}

function floatvalue($val){
	$val = str_replace(",",".",$val);
	$val = preg_replace('/\.(?=.*\.)/', '', $val);
	return floatval($val);
}

function remove_format($text){
    $text = str_replace(",", "", $text);
    return $text;
}

function get_the_event_ticket_selector( $post = 0 ) {
    $post = get_post( $post );

    $id    = isset( $post->ID ) ? $post->ID : 0;
    $data = get_post_meta( $id, '_event_registration_ticket_selector', true );
    $data = $data == 1 ? true : false;

    return $data;
}

function get_the_event_max_ticket( $post = 0 ) {
    $post = get_post( $post );

    $id    = isset( $post->ID ) ? $post->ID : 0;
    $data = get_post_meta( $id, '_event_registration_max_ticket', true );

    return $data;
}

function get_the_event_registration_phone( $post = 0 ) {
    $post = get_post( $post );

    $id    = isset( $post->ID ) ? $post->ID : 0;
    $data = get_post_meta( $id, '_event_registration_phone', true );

    return $data;
}

// function get_the_event_start_date( $post = 0) {
//     $post = get_post( $post );

//     $id    = isset( $post->ID ) ? $post->ID : 0;
//     $start_date = get_post_meta( $id, '_event_datetime_start', true );
//     $date = Carbon::create($start_date);

//     return $date;
// }

function get_the_event_end_date( $post = 0 ) {
    $post = get_post( $post );

    $id    = isset( $post->ID ) ? $post->ID : 0;
    $start_date = get_post_meta( $id, '_event_datetime_end', true );
    $date = Carbon::create($start_date);

    return $date;
}

function get_the_event_registration_limit( $post = 0 ) {
    $post = get_post( $post );

    $id    = isset( $post->ID ) ? $post->ID : 0;
    $data = get_post_meta( $id, '_event_datetime_reg_limit', true );

    return $data;
}

function get_the_event_tickets( $post = 0 ) {
    global $wpdb;

    $post = get_post( $post );

    $id    = isset( $post->ID ) ? $post->ID : 0;

    $table = "{$wpdb->prefix}wahaha_tickets";
    $tickets = $wpdb->get_results(
        "
        SELECT * 
        FROM $table
        WHERE `post_id` = $id
        AND `deleted` = 0
        "
    );

    return $tickets;
}

function get_the_event_price( $post = 0 ) {
    $tickets = get_the_event_tickets( $post );
    
    $data = 0;

    if( count($tickets) > 0 ) {
        $ticket = $tickets[0];
        $data = $ticket->price;
    }

    $data = intval( $data );

    return $data;
}

function get_the_event_venue_default( $post = 0 ) {
    $post = get_post( $post );

    $id    = isset( $post->ID ) ? $post->ID : 0;
    $data = get_post_meta( $id, '_event_venue_default', true );
    
    $data = $data == 1 ? true : false;
    return $data;
}

function get_the_event_venue_name( $post = 0 ) {
    $post = get_post( $post );

    $id    = isset( $post->ID ) ? $post->ID : 0;
    $default = get_the_event_venue_default( $post );
    $data = get_post_meta( $id, '_event_venue_name', true );

    if( $default ) {
        $data = 'Wahaha Club & Karaoke';
    }

    return $data;
}

function get_the_event_venue_phone( $post = 0 ) {
    $post = get_post( $post );

    $id    = isset( $post->ID ) ? $post->ID : 0;
    $default = get_the_event_venue_default( $post );
    $data = get_post_meta( $id, '_event_venue_phone', true );

    if( $default ) {
        $data = get_setting_company_phone();
    }

    return $data;
}

function get_the_event_venue_website( $post = 0 ) {
    $post = get_post( $post );

    $id    = isset( $post->ID ) ? $post->ID : 0;
    $default = get_the_event_venue_default( $post );
    $data = get_post_meta( $id, '_event_venue_website', true );

    if( $default ) {
        $data = 'http://wahahaentertainment.com';
    }

    return $data;
}

function get_the_event_venue_latitude( $post = 0 ) {
    $post = get_post( $post );

    $id    = isset( $post->ID ) ? $post->ID : 0;
    $default = get_the_event_venue_default( $post );
    $data = get_post_meta( $id, '_event_venue_latitude', true );

    if( $default ) {
        $data = -6.717559;
    }

    return $data;
}

function get_the_event_venue_longitude( $post = 0 ) {
    $post = get_post( $post );

    $id    = isset( $post->ID ) ? $post->ID : 0;
    $default = get_the_event_venue_default( $post );
    $data = get_post_meta( $id, '_event_venue_longitude', true );

    if( $default ) {
        $data = 108.548857;
    }

    return $data;
}

function get_the_event_venue_address( $post = 0 ) {
    $post = get_post( $post );

    $id    = isset( $post->ID ) ? $post->ID : 0;
    $default = get_the_event_venue_default( $post );
    $data = get_post_meta( $id, '_event_venue_address', true );

    if( $default ) {
        $data = get_setting_company_address();
    }

    return $data;
}

function get_the_event_organizer_default( $post = 0 ) {
    $post = get_post( $post );

    $id    = isset( $post->ID ) ? $post->ID : 0;
    $data = get_post_meta( $id, '_event_organizer_default', true );
    
    $data = $data == 1 ? true : false;
    return $data;
}

function get_the_event_organizer_name( $post = 0 ) {
    $post = get_post( $post );

    $id    = isset( $post->ID ) ? $post->ID : 0;
    $default = get_the_event_organizer_default( $post );
    $data = get_post_meta( $id, '_event_organizer_name', true );

    if( $default ) {
        $data = 'Wahaha Entertainment';
    }

    return $data;
}

function get_the_event_organizer_phone( $post = 0 ) {
    $post = get_post( $post );

    $id    = isset( $post->ID ) ? $post->ID : 0;
    $default = get_the_event_organizer_default( $post );
    $data = get_post_meta( $id, '_event_organizer_phone', true );

    if( $default ) {
        $data = get_setting_company_phone();
    }

    return $data;
}

function get_the_event_organizer_website( $post = 0 ) {
    $post = get_post( $post );

    $id    = isset( $post->ID ) ? $post->ID : 0;
    $default = get_the_event_organizer_default( $post );
    $data = get_post_meta( $id, '_event_organizer_website', true );

    if( $default ) {
        $data = 'http://wahahaentertainment.com';
    }

    return $data;
}

function the_event_max_ticket( $echo = true ) {
    $data = (int) get_the_event_max_ticket();

    if( empty($data) ) {
        return;
    }

    if( $echo ) {
        echo $data;
    } else {
        return $data;
    }
}

function the_event_registration_phone( $echo = true ) {
    $data = get_the_event_registration_phone();

    if( empty($data) ) {
        return;
    }

    if( $echo ) {
        echo $data;
    } else {
        return $data;
    }
}

function the_event_end_date( $format = '', $echo = true ) {
    $date = get_the_event_end_date();

    if( empty($date) ) {
        return;
    }

    if( empty($format) ) {
        $format = get_option('date_format') . ' ' . get_option('time_format');
    }

    $date = $date->format( $format );

    if( $echo ) {
        echo $date;
    } else {
        return $date;
    }
}

function the_event_date( $dateFormat = '', $timeFormat = '', $echo = true ) {
    $startDate = get_the_event_start_date();
    $endDate = get_the_event_end_date();

    if( empty($dateFormat) ) {
        $dateFormat = get_option('date_format');
    }

    if( empty($timeFormat) ) {
        $timeFormat = get_option( 'time_format' );
    }
    
    $format = $dateFormat . ' ' . $timeFormat;
    $sameDate = $startDate->isSameAs('Y-m-d', $endDate);

    if( $sameDate ) {
        $data = $startDate->format($dateFormat) . ' ' . $startDate->format($timeFormat) . ' - ' . $endDate->format($timeFormat);
    } else {
        $data = $startDate->format( $format ) . ' - ' . $endDate->format($format);
    }

    if( $echo ) {
        echo $data;
    } else {
        return $data;
    }
}

function the_event_tickets( $echo = true ) {
    $post = get_post();
    $id = $post->ID;

    $eventStart = get_the_event_start_date( $post );
    $eventEnd = get_the_event_end_date( $post );
    $now = Carbon::now();
    $isEventNotEnd = $now->lessThan( $eventEnd );

    if( !$isEventNotEnd ) {
        return;
    }

    $tickets = get_the_event_tickets();

    $overallSold = false;
    $max = get_the_event_max_ticket();

    $rowTickets = [];
    $ticketSolds = [];
    $ticketExpired = [];

    foreach( $tickets as $i => $ticket ) {

        $isSold = $ticket->qty == 0 ? true : false;
        $start = Carbon::create($ticket->start_date);
        $end = Carbon::create($ticket->end_date);
        $isStart = Carbon::now()->greaterThan( $start );
        $isNotEnd = Carbon::now()->lessThan( $end );

        $format = get_option('date_format');

        if( $isStart && $isNotEnd && !$isSold ) {

            $tableClass = 'gg-ticket-sale';

            $selectQty = '<select name="tkt-slctr-qty-'. $id .'['. $i .']" id="ticket-selector-tbl-qty-slct-'. $id .'-'. ($i+1) .'" class="form-control gg-tkt-slctr-slct">';
            for( $j = 0; $j <= $max; $j++ ) {
                $selectQty .= '<option value="'. $j .'">'. $j .'</option>';
            }
            $selectQty .= '</select>';

        } else {

            if( $isNotEnd ) {

                if( $isSold ) {

                    $ticketSolds[] = $ticket->id;

                    $tableClass = 'gg-ticket-sold';
                    $selectQty = '<strong class="text-danger">Sold Out</strong>';

                } else {

                    $tableClass = 'gg-ticket-coming';
                    $selectQty = '<p>
                        <strong class="text-warning">Goes on Sale</strong><br />
                        <span>'. $start->format( $format ).'</span>
                    </p>';

                }
            } else {

                $ticketExpired[] = $ticket->id;

                $tableClass = 'gg-ticket-expired';
                $selectQty = '<strong class="text-muted">Expired</strong>';

            }
        }

        $rowTickets[] = '<tr class="gg-ticket-selector-tr '. $tableClass .'">
            <td class="gg-ticket-selector-name" headers="details-'. $id .'">
                <strong>'. $ticket->name .'</strong>
            </td>
            <td class="gg-ticket-selector-pirce text-right" headers="price-'. $id .'">
                Rp '. number_format( $ticket->price, 0 ) .'
            </td>
            <td class="tckt-slctr-tbl-td-qty text-center" headers="quantity-'. $id .'">
                '. $selectQty .'
                <input type="hidden" name="tkt-slctr-ticket-id-'. $id .'['. $i .']" value="'. $ticket->id .'">
            </td>
        </tr>';
    }

    if( count($ticketSolds) < count($rowTickets) || count($ticketExpired) < count($rowTickets) ) {
        $data = '<form action="'. get_the_permalink() .'" method="POST" name="ticket-selector-form-'. $id .'" class="gg-ticket-selector">
            <input type="hidden" name="gg" value="tkt-slctr-tbl-wrap-dv">';
    } else {
        $data = '';
    }

    $data .= '<div id="gg-tkt-slctr-tbl-wrap-dv-'. $id .'">
        <table id="tkt-slctr-tbl-'. $id .'" class="table table-dark">
            <thead>
                <tr>
                    <th id="details-'. $id .'" scope="col" class="gg-ticket-selector-th gg-ticket-selector-th-detail">Details</th>
                    <th id="price-'. $id .'" scope="col" class="gg-ticket-selector-th gg-ticket-selector-th-price text-right">Price</th>
                    <th id="quantity-'. $id .'" scope="col" class="gg-ticket-selector-th gg-ticket-selector-th-qty text-center">Quantity</th>
                </tr>
            </thead>
            <tbody>
                '. implode("\r", $rowTickets) .'
            </tbody>
        </table>
        <div class="clear"></div>
    </div>';

    if( count($ticketSolds) < count($rowTickets) || count($ticketExpired) < count($rowTickets) ) {
        $data .= '<input type="hidden" name="noheader" value="true">
            <input type="hidden" name="tkt-slctr-return-url-'. $id .'" value="'. get_the_permalink() .'#gg-tkt-slctr-tbl-wrap-dv-'. $id .'">
            <input type="hidden" name="tkt-slctr-max-atndz-'. $id .'" value="'. $max .'">
            <input type="hidden" name="tkt-slctr-event-id" value="'. $id .'">
            '. wp_nonce_field('gg-ticket-selector', 'gg_tkt_slctr_field', true, false) .'
            <div class="row">
                <div class="col">
                    <div class="gg-ticket-selector-error"></div>
                </div>
                <div class="col col-auto text-right">
                    <div id="gg-ticket-selector-submit-'. $id .'-btn-wrap" class="gg-ticket-selector-submit-btn-wrap text-right">
                        <button type="submit" class="btn btn-primary gg-ticket-selector-submit-btn gg-ticket-selector-submit-ajax">Register Now</button>
                    </div>
                </div>
            </div>
        </form>';
    }

    if( $echo ) {
        echo $data;
    } else {
        return $data;
    }
}

function the_event_price( $curreny = 'Rp', $echo = true ) {
    $data = get_the_event_price();

    $data = $curreny . ' ' . number_format($data, 0);

    if( $echo ) {
        echo $data;
    } else {
        return $data;
    }
}

function the_event_venue_name( $echo = true ) {
    $data = get_the_event_venue_name();
    
    if( empty($data) ) {
        return;
    }

    if( $echo ) {
        echo $data;
    } else {
        return $data;
    }
}

function the_event_venue_phone( $echo = true ) {
    $data = get_the_event_venue_phone();
    
    if( empty($data) ) {
        return;
    }

    if( $echo ) {
        echo $data;
    } else {
        return $data;
    }
}

function the_event_venue_website( $target = '_blank', $echo = true ) {
    $data = get_the_event_venue_website();
    
    if( empty($data) ) {
        return;
    }

    $data = '<a href="'. $data .'" rel="nofollow" target="'. $target .'">'. $data .'</a>';

    if( $echo ) {
        echo $data;
    } else {
        return $data;
    }
}

function the_event_venue_location( $echo = true ) {
    $latitude = get_the_event_venue_latitude();
    $longitude = get_the_event_venue_longitude();

    $data = '<div class="event-venue-location gg-map" id="venue-location" data-latitude="'. $latitude .'" data-longitude="'. $longitude .'" data-name="'. get_the_title() .'"></div>';

    if( $echo ) {
        echo $data;
    } else {
        return $data;
    }
}

function the_event_venue_address( $echo = true ) {
    $data = get_the_event_venue_address();
    
    if( empty($data) ) {
        return;
    }

    $data = '<p>'. $data .'</p>';

    $latitude = get_the_event_venue_latitude();
    $longitude = get_the_event_venue_longitude();

    if( !empty($latitude) && !empty($longitude) ) {
        $data .= '<p>
            <a href="https://www.google.com/maps/dir/?api=1&destination='. $latitude .','. $longitude .'&zoom=17&basemap=terrain" rel="nofollow" target="_blank">'. __('+ Direction to venue', 'gragas') .'</a>
        </p>';
    }

    if( $echo ) {
        echo $data;
    } else {
        return $data;
    }
}

function the_event_organizer_name( $echo = true ) {
    $data = get_the_event_organizer_name();
    
    if( empty($data) ) {
        return;
    }

    if( $echo ) {
        echo $data;
    } else {
        return $data;
    }
}

function the_event_organizer_phone( $echo = true ) {
    $data = get_the_event_organizer_phone();
    
    if( empty($data) ) {
        return;
    }

    if( $echo ) {
        echo $data;
    } else {
        return $data;
    }
}

function the_event_organizer_website( $target = '_blank', $echo  = true ) {
    $data = get_the_event_organizer_website();
    
    if( empty($data) ) {
        return;
    }

    $data = '<a href="'. $data .'" rel="nofollow" target="'. $target .'">'. $data .'</a>';

    if( $echo ) {
        echo $data;
    } else {
        return $data;
    }
}

// 
// 
// 
// 

function get_data_type_karaoke() {
    return 1;
}

function get_data_type_hotel() {
    return 2;
}

function get_data_type_lounge() {
    return 3;
}