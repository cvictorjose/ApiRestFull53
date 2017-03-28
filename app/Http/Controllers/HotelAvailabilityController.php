<?php

namespace App\Http\Controllers;

use App;
use Carbon;
use Exception;
use DatePeriod;
use App\Hotel;
use App\RoomType;
use App\HotelAvailability;
use App\HotelOrder;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use DB;
use Log;

class HotelAvailabilityController extends Controller
{
    /**
     * Compute a range between two dates, and generate
     * a plain array of Carbon objects of each day in it.
     *
     * @param  \Carbon\Carbon  $from
     * @param  \Carbon\Carbon  $to
     * @param  bool  $inclusive
     * @return array|null
     *
     * @author Tristan Jahier
     */
    public static function date_range(Carbon\Carbon $from, Carbon\Carbon $to, $inclusive = true)
    {
        if ($from->gt($to)) {
            return null;
        }

        // Clone the date objects to avoid issues, then reset their time
        $from = $from->copy()->startOfDay();
        $to = $to->copy()->startOfDay();

        // Include the end date in the range
        if ($inclusive) {
            $to->addDay();
        }

        $step = Carbon\CarbonInterval::day();
        $period = new DatePeriod($from, $step, $to);

        // Convert the DatePeriod into a plain array of Carbon objects
        $range = [];

        foreach ($period as $day) {
            $range[] = new Carbon\Carbon($day);
        }

        return ! empty($range) ? $range : null;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', new HotelAvailability);

        //Get All HotelAvailabilitys
        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=HotelAvailability::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        $hotelavailability = DB::table('hotel_availability');
        if (isset($field_order)){
            $hotelavailability->orderBy($field_order);
        }

        $results= $hotelavailability->paginate($pagesize,['*'],'page_n');
        $results= $results->appends(array('sort' => $field_order, 'page_s' => $pagesize ));

        return $results;
    }


    /**
     * Display a filtered listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_By_Year_Hotel(Request $request, $hotel_id, $year, $room_type_id=null)
    {
        try{
            $this->authorize('index', new HotelAvailability);

            if($room_type_id){
                $hotelavailability = HotelAvailability::whereYear('day', '=', $year)->where('hotel_id', $hotel_id)->where('room_type_id', $room_type_id)->get();
                $ha_output = array();
                foreach($hotelavailability as $ha){
                    $ha_output[sprintf('%s', intval(date('z', strtotime($ha->day)))+1)] = $ha->rooms;
                }
            }else{
                $hotelavailability = HotelAvailability::whereYear('day', '=', $year)->where('hotel_id', $hotel_id)->get();
                $ha_output = array();
                foreach($hotelavailability as $ha){
                    if(!array_key_exists($ha->room_type_id, $ha_output))
                        $ha_output[$ha->room_type_id] = array();
                    $ha_output[$ha->room_type_id][sprintf('%s', intval(date('z', strtotime($ha->day)))+1)] = $ha->rooms;
                }
            }
            return $this->createMessage($ha_output, '200');
        } catch (Exception $e) {
            return $this->createMessageError($e->getMessage() . ' | File ' . $e->getFile() . ' | Line ' . $e->getLine(), '400');
        }
    }


    /**
     * Display a filtered listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_By_Year_Hotel_DayKeyed(Request $request, $hotel_id, $year)
    {
        try{
            $this->authorize('index', new HotelAvailability);

            $hotelavailability = HotelAvailability::whereYear('day', '=', $year)->where('hotel_id', $hotel_id)->get();
            $ha_output = array();
            foreach($hotelavailability as $ha){
                $daykey = sprintf('%s', intval(date('z', strtotime($ha->day)))+1);
                if(!array_key_exists($daykey, $ha_output))
                    $ha_output[$daykey] = array();
                $ha_output[$daykey][$ha->room_type_id] = $ha->rooms;
            }

            return $this->createMessage($ha_output, '200');
        } catch (Exception $e) {
            return $this->createMessageError($e->getMessage() . ' | File ' . $e->getFile() . ' | Line ' . $e->getLine(), '400');
        }
    }


    /**
     * Display a filtered listing of the sold rooms (HotelOrder).
     *
     * @return \Illuminate\Http\Response
     */
    public function index_SoldRooms_By_Year_Hotel(Request $request, $hotel_id, $year, $room_type_id=null)
    {
        try{
            $this->authorize('index', new HotelAvailability);

            if($room_type_id){
                $soldrooms = HotelOrder::whereYear('day', '=', $year)->where('hotel_id', $hotel_id)->where('room_type_id', $room_type_id)->get();
                $sr_output = array();
                foreach($soldrooms as $sr){
                    $soldrooms_per_day = $soldrooms->filter(function($soldrooms_line) use ($sr){
                        return $soldrooms_line->day == $sr->day;
                    });
                    $sr_output[sprintf('%s', intval(date('z', strtotime($sr->day)))+1)] = $soldrooms_per_day->sum('rooms');
                }
            }else{
                $soldrooms = HotelOrder::whereYear('day', '=', $year)->where('hotel_id', $hotel_id)->get();
                $sr_output = array();
                foreach($soldrooms as $sr){
                    if($sr->room_type_id){
                        if(!array_key_exists($sr->room_type_id, $sr_output))
                            $sr_output[$sr->room_type_id] = array();
                        $day_key = sprintf('%s', intval(date('z', strtotime($sr->day)))+1);
                        if(array_key_exists($day_key, $sr_output[$sr->room_type_id])){
                            $sr_output[$sr->room_type_id][$day_key] += $sr->rooms;
                        }else{
                            $sr_output[$sr->room_type_id][$day_key] = $sr->rooms;
                        }
                    }
                }
            }
            return $this->createMessage($sr_output, '200');
        } catch (Exception $e) {
            return $this->createMessageError($e->getMessage() . ' | File ' . $e->getFile() . ' | Line ' . $e->getLine(), '400');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_By_Year_Hotel_RoomType(Request $request, $hotel_id, $year, $room_type_id)
    {
        try {

            $this->authorize('create_hotelavailability', new HotelAvailability);

            $c = 0;
            $u = 0;
            if(!$request->has('availability'))
                throw new \Exception('Missing "availability" form input (array)');
            if(!is_array($request->input('availability')))
                throw new \Exception('The form input "availability" is not an array');
            $base_timestamp = mktime(0, 0, 1, 1, 1, $year);
            foreach($request->input('availability') as $nday => $rooms){
                $day = date('Y-m-d', $base_timestamp+(86400*(intval($nday)-1)));
                $existing_hotelavailability = HotelAvailability::where('hotel_id', $hotel_id)->where('room_type_id', $room_type_id)->where('day', $day)->first();
                if(!$existing_hotelavailability){
                    $hotelavailability = HotelAvailability::create([
                                            'hotel_id'      =>  $hotel_id,
                                            'room_type_id'  =>  $room_type_id,
                                            'day'           =>  $day,
                                            'rooms'         =>  $rooms
                                        ]);
                    $c++;
                }else{
                    $existing_hotelavailability->update([
                                            'hotel_id'      =>  $hotel_id,
                                            'room_type_id'  =>  $room_type_id,
                                            'day'           =>  $day,
                                            'rooms'         =>  $rooms
                                        ]);
                    $u++;
                }
            }
            return $this->createMessage(sprintf('Added %s new HotelAvailability items, updated %s existing HotelAvailability items', $c, $u), '200');

        } catch (Exception $e) {
            return $this->createMessageError($e->getMessage() . ' | File ' . $e->getFile() . ' | Line ' . $e->getLine(), '400');
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_By_Hotel_DateRange(Request $request, $hotel_id)
    {
        try{
            $this->authorize('create_hotelavailability', new HotelAvailability);
            $c = 0;
            $u = 0;
            if(!(intval($hotel_id)>0))
                throw new \Exception('Hotel ID not valid');
            $hotel = Hotel::find($hotel_id);
            if(!$hotel)
                throw new \Exception(sprintf('Hotel with ID %s not found', $hotel_id));
            $request_vars = $request->all();
            if(!$request->has('first_date'))
                throw new \Exception('Missing first date');
            $first_date = Carbon\Carbon::parse($request_vars['first_date']);
            if(empty($first_date))
                throw new \Exception('First date not valid');
            if(!$request->has('last_date'))
                throw new \Exception('Missing last date');
            $last_date = Carbon\Carbon::parse($request_vars['last_date']);
            if(empty($last_date))
                throw new \Exception('Last date not valid');
            $date_range = HotelAvailabilityController::date_range($first_date, $last_date);
            if(array_key_exists('roomtypes', $request_vars)){
                foreach($request_vars['roomtypes'] as $room_type_id => $rooms){
                    $room_type = RoomType::find($room_type_id);
                    if(!$room_type)
                        throw new \Exception(sprintf('RoomType with ID %s not found', $room_type_id));
                    if($rooms!='' && intval($rooms)>=0){ // actually apply the changes
                        foreach($date_range as $carbon_day){
                            $day = $carbon_day->format('Y-m-d');
                            $existing_hotelavailability = HotelAvailability::where('hotel_id', $hotel_id)->where('room_type_id', $room_type_id)->where('day', $day)->first();
                            if(!$existing_hotelavailability){
                                $hotelavailability = HotelAvailability::create([
                                                        'hotel_id'      =>  $hotel_id,
                                                        'room_type_id'  =>  $room_type_id,
                                                        'day'           =>  $day,
                                                        'rooms'         =>  $rooms
                                                    ]);
                                $c++;
                            }else{
                                $existing_hotelavailability->update([
                                                        'hotel_id'      =>  $hotel_id,
                                                        'room_type_id'  =>  $room_type_id,
                                                        'day'           =>  $day,
                                                        'rooms'         =>  $rooms
                                                    ]);
                                $u++;
                            }
                        }
                    }
                }
            }
            return $this->createMessage(sprintf('Added %s new HotelAvailability items, updated %s existing HotelAvailability items', $c, $u), '200');
        } catch (\Exception $e) {
            return $this->createMessageError($e->getMessage() . ' | File ' . $e->getFile() . ' | Line ' . $e->getLine(), '400');
        }
    }


    /**
     * Display a Hotel items listing based on availability.
     *
     * @return \Illuminate\Http\Response
     */
    public function availableHotels(Request $request)
    {
        try{
            $this->authorize('index', new Hotel);

            $request_vars = $request->all();
            
            $totalrooms_by_hotels = HotelAvailability::groupBy('hotel_id')
                                                     ->selectRaw('sum(rooms) as rooms_total, hotel_id')
                                                     ->pluck('rooms_total','hotel_id')->toArray();
            // Ordering hotels by total rooms available
            arsort($totalrooms_by_hotels, SORT_NUMERIC);
            $hotels_ids = array_map('intval', array_keys($totalrooms_by_hotels));
            //$hotels_ids = Hotel::all()->pluck('id')->toArray();
            $hotels_avail = array();
            if(array_key_exists('roomtypes', $request_vars) && array_key_exists('visit_date', $request_vars)){
                // Checks START
                $requested_beds = 0;
                foreach($request_vars['roomtypes'] as $room_type_id => $rooms){
                    $room_type = RoomType::find($room_type_id);
                    $requested_beds += $room_type->persons*intval($rooms);
                }
                $requested_tickets = floatval($request_vars['parkhotel_tickets']);
                $beds_tickets_diff = $requested_beds - $requested_tickets;
                if($beds_tickets_diff > 0){
                    throw new Exception("Too beds/rooms requested");
                }elseif($beds_tickets_diff < 0){
                    throw new Exception("Not enough beds/rooms requested");
                }
                if(intval($request_vars['children_free']) > $requested_tickets/2)
                    throw new Exception("Too many free children selected (max 1 every 2 adults)");
                // Checks END
                if(!empty($request_vars['visit_date'])){
                    $visit_date = Carbon\Carbon::parse($request_vars['visit_date'])->format('Y-m-d');
                    if(!empty($visit_date)){
                        foreach($request_vars['roomtypes'] as $room_type_id => $rooms){
                            if(intval($rooms)>0){
                                $hotels_avail[$room_type_id] = HotelAvailability::where('day', $visit_date)->where('room_type_id', $room_type_id)->where('rooms', '>=', $rooms)->pluck('hotel_id')->toArray();
                                $hotels_ids = array_intersect($hotels_ids, $hotels_avail[$room_type_id]);
                            }
                        }
                        $totalrooms_by_hotels = HotelAvailability::where('day', $visit_date)
                                                             ->whereIn('hotel_id', $hotels_ids)
                                                             ->groupBy('hotel_id')
                                                             ->selectRaw('sum(rooms) as rooms_total, hotel_id')
                                                             ->pluck('rooms_total','hotel_id')->toArray();
                        // Ordering hotels by total rooms available in the visit date specified
                        arsort($totalrooms_by_hotels, SORT_NUMERIC);
                        $hotels_ids = array_map('intval', array_keys($totalrooms_by_hotels));
                    }
                }
            }
            if(empty($hotels_ids))
                throw new \Exception('There are no hotels available');
            //throw new \Exception(print_r($hotels_avail, true));
            //throw new \Exception(print_r($hotels_ids, true));
            $hotels_ids_ordered = implode(', ', $hotels_ids);
            $hotels = Hotel::whereIn('id', $hotels_ids)->orderByRaw(DB::raw(sprintf('FIELD(id, %s)', $hotels_ids_ordered)))->get();
            return $this->createMessage($hotels, '200');
        } catch (\Exception $e) {
            return $this->createMessageError($e->getMessage(), '400');
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create_hotelavailability', new HotelAvailability);

        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $rules = [
            'title'          => 'required',
        ];

        try {

            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(), "400");
            }
            $request_vars = $request->all();
            foreach($request_vars as $k=>$v){
                $request_vars[$k] = stripslashes($v);
            }
            $hotelavailability = HotelAvailability::create($request_vars);
            return $this->createMessage("Added New HotelAvailability","200");

        } catch (Exception $e) {
            return $this->createMessageError($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), $e->getStatusCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $result = HotelAvailability::where('id', $id)->firstOrFail();
            $this->authorize('read_hotelavailability', $result);
            return $this->createMessage($result,"200");
            // return response()->json(['data'=>$ticket]);

        } catch (Exception $e) {
            //return ['error'=>'not_found','error_message'=>'Please check the SOAP connection'];
            return $this->createMessageError($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), $e->getStatusCode());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $rules = [
            'title'          => 'required',
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            $hotelavailability = HotelAvailability::find($id);
            $this->authorize('update_hotelavailability', $hotelavailability);
            $request_vars = $request->all();
            foreach($request_vars as $k=>$v){
                $request_vars[$k] = stripslashes($v);
            }
            $hotelavailability->update($request_vars);
            return $this->createMessage("HotelAvailability modified successfully","200");

        } catch (Exception $e) {
            \Log::info('Error updating HotelAvailability: '.$e);
            return $this->createMessageError($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), $e->getStatusCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $result= HotelAvailability::where('id', $id)->firstOrFail();
            $this->authorize('delete_hotelavailability', $result);
            $result->delete();
            return $this->createMessage("HotelAvailability deleted successfully","200");
        } catch (Exception $e) {
            \Log::info('Error deleting HotelAvailability: '.$e);
            return $this->createMessageError($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), $e->getStatusCode());
        }
    }

}
