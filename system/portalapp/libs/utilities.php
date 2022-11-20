<?php

/*********************************************************
Time Sharp Scheduling Engine

utilities:: Class - Container for all commonly used methods
to a given week.

Developed by Luthfur Rahman Chowdhury

August 3, 2006
**********************************************************/

abstract class utilities  {

	public static function generateRandomString($length = 10)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

	static public function add_to_array($array, $key, $value) {
	    if(array_key_exists($key, $array)) {
	        if(is_array($array[$key])) {
	            $array[$key][] = $value;
	        }
	        else {
	            $array[$key] = array($array[$key], $value);
	        }
	    }
	    else {
	        $array[$key] = array($value);
	    }

	}

	static public function last_monday($date) {
	    if (!is_numeric($date))
	        $date = strtotime($date);
	    if (date('w', $date) == 1)
	        return $date;
	    else
	        return strtotime(
	            'last monday',
	             $date
	        );
	}

	static public function check_date_is_within_range($start_date, $end_date, $todays_date)
	{
	  	$start_timestamp = strtotime($start_date);
	  	$end_timestamp = strtotime($end_date);
	  	$today_timestamp = strtotime($todays_date);

	  	return (($today_timestamp >= $start_timestamp) && ($today_timestamp <= $end_timestamp));
	}

	/**
     * Creating date collection between two dates
     *
     * <code>
     * <?php
     * # Example 1
     * date_range("2014-01-01", "2014-01-20", "+1 day", "m/d/Y");
     *
     * # Example 2. you can use even time
     * date_range("01:00:00", "23:00:00", "+1 hour", "H:i:s");
     * </code>
     *
     * @author Ali OYGUR <alioygur@gmail.com>
     * @param string since any date, time or datetime format
     * @param string until any date, time or datetime format
     * @param string step
     * @param string date of output format
     * @return array
     */
    static public function date_range($first, $last, $step = '+1 day', $output_format = 'd/m/Y' ) {

        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);

        while( $current <= $last ) {

            $dates[] = date($output_format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }

	/*
	* shift to specified timezone from the current time zone
	*
	* @param Item Date
	* @param shift to time zone
	*
	* @return $Item Date
	*/
	static public function shiftTime($ItemDate, $shift_from, $shift_to) {

		$ItemDateCopy = clone $ItemDate;
		/*
		$shift_by = $shift_to - $shift_from;

		$shift = explode(".", $shift_by);

		$shift_hour = $shift[0];
		$shift_min = ($shift_by - $shift_hour) * 60;

		if($shift_by < 0) {

			$ItemDateCopy->removeHour($shift_hour * -1);
			$ItemDateCopy->removeMinute($shift_min * -1);

		} elseif($shift_by > 0) {

			$ItemDateCopy->addHour($shift_hour);
			$ItemDateCopy->addMinute($shift_min);

		}
		*/
		return $ItemDateCopy;

	}


	/*
	* periodical recurrence check
	*
	* @param the schedule item
	*/
	public function checkPeriodic($ItemStartDate, $thisDate, $current_timezone, $original_timezone) {

		$counter1 = 0;
		$counter2 = 0;

		// DatePointer to Data Start Date and time
		$DatePointer = new sc_datetime($ItemStartDate->getDay(), $ItemStartDate->getMonth(), $ItemStartDate->getYear(), $ItemStartDate->getHour(), $ItemStartDate->getMinute());

		$current_month = $DatePointer->getMonth();

		// get the week number for the start day of the event
		while($DatePointer->getMonth() == $current_month) {
			$DatePointer->removeWeek(1);
			$counter1++;
		}

		// Shift the DatePointer to the current timezone
		$ShiftedPointer = utilities::shiftTime($DatePointer,0,$current_timezone);

		// Shift the selected date to the original timezone
		$DatePointer = utilities::shiftTime(new sc_datetime($thisDate->getDay(), $thisDate->getMonth(), $thisDate->getYear(),$ShiftedPointer->getHour(), $ShiftedPointer->getMinute()), $current_timezone, $original_timezone);

		$current_month = $DatePointer->getMonth();

		// get the week number
		while($DatePointer->getMonth() == $current_month) {
			$DatePointer->removeWeek(1);
			$counter2++;
		}


		// if week numbers are the same add to schedule
		if($counter1  == $counter2) return 1;

		return 0;

	}


	/*
	*
	* Check every other week
	*
	* @param Data start date
	* @param Start Date of the item
	* @return true if every other week, false otherwise
	*
	*/

	public function checkEveryOtherWeek($DataStartDate, $StartTime) {

		$DatePointer = clone $DataStartDate;

		// Skip pointer two weeks forward
		while($DatePointer->compareDate($StartTime) < 0) {
			$DatePointer->addWeek(2);
		}

		// If this date is hit add to schedule
		if($DatePointer->compareDate($StartTime) == 0) return 1;

		return 0;

	}


	/*
	*
	* Create Item
	*
	* @param ItemData
	* @param Start Date of the item
	* @param Time zone to shift the item data
	* @param toNext: 1 for cross day item
	* @return ScheduleItem for this item
	*/
	public function createItem($ItemData, $StartDate, $timezone, $toNext=0) {

		//date_default_timezone_set("GMT");

		// shift to current time zone
		$DataStartDate = $ItemData->getStartDate();
		$DataStopDate = $ItemData->getStopDate();

		// create current day with start time
		$StartTime = new sc_datetime($StartDate->getDay(), $StartDate->getMonth(), $StartDate->getYear(), $DataStartDate->getHour(), $DataStartDate->getMinute());

		// create next day with stop time
		$StopTime = new sc_datetime($StartDate->getDay(), $StartDate->getMonth(), $StartDate->getYear(), $DataStopDate->getHour(), $DataStopDate->getMinute());

		if($toNext) $StopTime->addDay(1);

		//date_default_timezone_set(SYS_TIME_ZONE);

		return new ScheduleItem($StartTime->getTimeStamp(), $StopTime->getTimeStamp(), $ItemData->getTimeSpec(), $ItemData->getDetails());


	}




	/*
	*
	* Get the TueThu week array
	*
	* @param ItemData
	* @param DataStartDate containing shifted time
	*
	*/
	public function getTueThuArray($ItemData, $DataStartDate) {

		// day of week selection array
		$days[1] = array(1, 3);
		$days[2] = array(2, 4);
		$days[3] = array(3, 5);
		$days[4] = array(4, 2);
		$days[5] = array(5, 3);

		// get the start day of week
		$start_day = $DataStartDate->getDayOfWeek();

		// check original day of week and change start day of week if necessary
		if($start_day == 3) {

			$DatePointer = utilities::shiftTime($ItemData->getStartDate(), 0, $ItemData->getOriginalTimeZone());

			if($DatePointer->getDayOfWeek() == 4) $start_day = 1;

		}

		// get the day of week set
		return $days[$start_day];

	}






	/*
	*
	* Get the MonWedFri week array
	*
	* @param ItemData
	* @param DataStartDate containing shifted time
	*
	*/
	public function getMonWedFriArray($ItemData, $DataStartDate) {

		// day of week selection array
		$days[0] = array(0, 2, 4);
		$days[1] = array(1, 3, 5);
		$days[2] = array(2, 6, 4);
		$days[3] = array(1, 3, 5);
		$days[5] = array(1, 3, 5);
		$days[6] = array(2, 6, 4);

		// get the start day of week
		$start_day = $DataStartDate->getDayOfWeek();

		// check original day of week and change start day of week if necessary
		if($ItemData->getTimeSpec()) {

			// shift time to original timezone
			$DatePointer = utilities::shiftTime($ItemData->getStartDate(), 0, $ItemData->getOriginalTimeZone());

			if($start_day == 2) {

				if($DatePointer->getDayOfWeek() == 3) $start_day = 0;

			} else if($start_day == 4) {

				if($DatePointer->getDayOfWeek() == 5)  {

					$start_day = 0;

				} else {

					$start_day = 2;

				}


			}

		}

		// get the day of week set
		return $days[$start_day];

	}



	/*
	*
	* Get the blocked off day in the week
	* used by getWeekdayArray and getWeekendArray methods
	*
	* @param DataStartDate containing shifted time
	* @param DataStopDate containing shifted time
	* @param ItemData
	*
	*/
	private function getWeekBlock($ItemData, $DataStartDate, $weekend) {

		$first_day = $weekend;

		if($ItemData->getTimeSpec()) {

			$DatePointer = utilities::shiftTime($ItemData->getStartDate(), 0, $ItemData->getOriginalTimeZone());

			if($DatePointer->compareDate($DataStartDate) < 0) {

				$first_day = ($weekend + 1) % 7;

			} else if($DatePointer->compareDate($DataStartDate) > 0)  {

				$first_day = ($weekend - 1) % 7;

				// negative integer handle
				if($first_day < 0) $first_day = 7 + $first_day;

			}

		}


		return $first_day;
	}



	/*
	*
	* Get the Weekday week array
	*
	* @param ItemData
	* @param DataStartDate containing shifted time
	*
	*/
	public function getWeekdayArray($ItemData, $DataStartDate, $weekend) {

		// grab the first blocked day
		$first_non_day = utilities::getWeekBlock($ItemData, $DataStartDate, $weekend);

		// get the second day
		$second_non_day = ($first_non_day + 1) % 7;

		$days = array();

		for($i=0; $i<7; $i++) {

			if($i != $first_non_day && $i != $second_non_day) $days[] = $i;

		}

		return $days;
	}



	/*
	*
	* Get the Weekend week array
	*
	* @param ItemData
	* @param DataStartDate containing shifted time
	*
	*/
	public function getWeekendArray($ItemData, $DataStartDate, $weekend) {

		$days = array();

		// grab the first blocked day
		$days[0] = utilities::getWeekBlock($ItemData, $DataStartDate, $weekend);

		// get the second day
		$days[1] = ($days[0] + 1) % 7;

		return $days;

	}


}
