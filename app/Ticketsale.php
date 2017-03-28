<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketSale extends Model
{
    protected $table = 'ticket_sale';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'layout_id', 'ticket_group_id', 'service_group_id', 'date_mandatory'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    /**
     *  Return all tickectgroup belong to ticketsales.
     */
    public function ticketGroups(){
        return $this->hasMany(TicketGroup::class);
    }

    /**
     *  Return default TicketGroup.
     */
    public function defaultTicketGroup(){
        return TicketGroup::find($this->ticket_group_id);
    }

    /**
     *  Return all tickectgroup belong to ticketsales.
     */
    public function serviceGroups(){
        return $this->hasMany(ServiceGroup::class);
    }

    /**
     *  Return default TicketGroup.
     */
    public function defaultServiceGroup(){
        return ServiceGroup::find($this->service_group_id);
    }

    /**
     *  Return all the layouts.
     */
    public function getLayouts(){
        return $this->hasMany(Layout::class);
    }

    /**
     *  Return all the behaviours.
     */
    public function behaviours(){
        return $this->hasMany(Behaviour::class);
    }

    /**
     *  Return the default layout.
     */
    public function getDefaultLayout(){
        return Layout::find($this->layout_id);
    }

    /**
     *  Return the current layout (coupon logic FIXME)
     */
    public function getLayout(){
        $layout = null;
        $c = Cart::getCurrent();
        if($c){
            if($c->coupon_code_id>0){
                $coupon_code = CouponCode::find($c->coupon_code_id);
                if($coupon_code){
                    if($coupon_code->coupon_id>0){
                        $coupon = Coupon::find($coupon_code->coupon_id);
                        if($coupon){
                            if($coupon->layout_id>0){ // layout_switch_by_id
                                if($coupon->ticket_sale_id>0 && $coupon->ticket_sale_id != $this->id){
                                    // Then a coupon exists in the cart, with type layout_switch_by_id - but the ticketsale requested is different than the one specified in the layout configuration: thus we need to reset the coupon in the cart
                                    $c->coupon_code_id = null;
                                    $c->save();
                                }else{
                                    $layout = Layout::find($coupon->layout_id);
                                }
                            }elseif(!empty($coupon->layout_title)){ // layout_switch_by_title
                                if($coupon->ticket_sale_id>0 && $coupon->ticket_sale_id != $this->id){
                                    // Then a coupon exists in the cart, with type layout_switch_by_title - but the ticketsale requested is different than the one specified in the layout configuration: thus we need to reset the coupon in the cart
                                    $c->coupon_code_id = null;
                                    $c->save();
                                }else{
                                    $layout = Layout::where('ticket_sale_id', $this->id)->where('title', $coupon->layout_title)->first();
                                }
                            }
                        }
                    }
                }
            }
        }
        if($layout){ // Then a coupon is active.
            $layout->coupon_code_title = $coupon_code->title;
            $layout->coupon_code_code  = $coupon_code->code;
            $layout->coupon_behaviour  = $coupon->behaviour;
        }else{
            $layout = $this->getDefaultLayout();
        }
        // Adding a TicketSale field
        $layout->date_mandatory = $this->date_mandatory;
        return $layout;
    }

    public function getExpandedLayout(){
        try{
            $default_layout = $this->getDefaultLayout();
            $layout = $this->getLayout();
            $layout->expand();
            if($layout->id != $default_layout->id){
                // A coupon is active. Getting default prices and quantities
                $layout_swap = array('tickets'=>array(), 'services'=>array(), 'links'=>array());
                $default_prices = array('ticket'=>array(), 'service'=>array(), 'link'=>array());
                $default_ids = array('ticket'=>array(), 'service'=>array(), 'link'=>array());
                $default_layout->expand();
                $lss = $default_layout->layout_sections;
                foreach($lss as $ls){
                    $lscs = $ls->layout_section_categories;
                    foreach($lscs as $lsc){
                        $lscis = $lsc->layout_items;
                        foreach($lscis as $lsci){
                            switch($lsci->type){
                                case 'ticket':
                                    $lsci_title = str_replace(' ', '', $lsci->ticket->title);
                                    $default_prices['ticket'][$lsci_title] = $lsci->ticket->price;
                                    $default_ids['ticket'][$lsci_title] = $lsci->ticket->id;
                                    break;
                                case 'service':
                                    $lsci_title = str_replace(' ', '', $lsci->service->title);
                                    $default_prices['service'][$lsci_title] = $lsci->service->price;
                                    $default_ids['service'][$lsci_title] = $lsci->service->id;
                                    break;
                                case 'link':
                                    $lsci_title = str_replace(' ', '', $lsci->link->title);
                                    $default_prices['link'][$lsci_title] = $lsci->link->price;
                                    $default_ids['link'][$lsci_title] = $lsci->link->id;
                                    break;
                            }
                        }
                    }
                }
                // Great. Now checking matching titles in the coupon-activated layout, and adding defaultprice attribute where the new price is different
                $lss = $layout->layout_sections;
                foreach($lss as $ls){
                    $lscs = $ls->layout_section_categories;
                    foreach($lscs as $lsc){
                        $lscis = $lsc->layout_items;
                        foreach($lscis as $lsci){
                            switch($lsci->type){
                                case 'ticket':
                                    if($lsci->ticket){
                                        $lsci_title = str_replace(' ', '', $lsci->ticket->title);
                                        $default_price = (array_key_exists($lsci_title, $default_prices['ticket'])) ? $default_prices['ticket'][$lsci_title] : null;
                                        if($default_price != $lsci->ticket->price){
                                            $lsci->ticket->default_price = $default_price;
                                        }
                                        if(array_key_exists($lsci_title, $default_ids['ticket'])){
                                            $lsci->ticket->default_id = $default_ids['ticket'][$lsci_title];
                                            if($lsci->ticket->id != $lsci->ticket->default_id){
                                                $layout_swap['tickets'][$lsci->ticket->id] = sprintf("%s", $lsci->ticket->default_id);
                                            }
                                        }
                                    }
                                    break;
                                case 'service':
                                    if($lsci->service){
                                        $lsci_title = str_replace(' ', '', $lsci->service->title);
                                        $default_price = (array_key_exists($lsci_title, $default_prices['service'])) ? $default_prices['service'][$lsci_title] : null;
                                        if($default_price != $lsci->service->price){
                                            $lsci->service->default_price = $default_price;
                                        }
                                        if(array_key_exists($lsci_title, $default_ids['service'])){
                                            $lsci->service->default_id = $default_ids['service'][$lsci_title];
                                            if($lsci->service->id != $lsci->service->default_id){
                                                $layout_swap['services'][$lsci->service->id] = sprintf("%s", $lsci->service->default_id);
                                            }
                                        }
                                    }
                                    break;
                                case 'link':
                                    if($lsci->link){
                                        $lsci_title = str_replace(' ', '', $lsci->link->title);
                                        $default_price = (array_key_exists($lsci_title, $default_prices['link'])) ? $default_prices['link'][$lsci_title] : null;
                                        if($default_price != $lsci->link->price){
                                            $lsci->link->default_price = $default_price;
                                        }
                                        if(array_key_exists($lsci_title, $default_ids['link'])){
                                            $lsci->link->default_id = $default_ids['link'][$lsci_title];
                                            if($lsci->link->id != $lsci->link->default_id){
                                                $layout_swap['links'][$lsci->link->id] = sprintf("%s", $lsci->link->default_id);
                                            }
                                        }
                                    }
                                    break;
                            }
                        }
                    }
                }
                $layout->swap = $layout_swap;
            }           
            return $layout;
        }catch(\Exception $e){
            throw $e;
            //return sprintf("Exception: %s (File: %s | Line %s)", $e->getMessage(), $e->getFile(), $e->getLine());
        }
    }

}
