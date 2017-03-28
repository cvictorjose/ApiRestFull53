<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\App;


class SchemaController extends Controller {

    protected $schemas;

    public function __construct(){
        $this->schemas = array(
            'tickets'  =>  array(
                'classname'     =>  'Ticket',
                'parent'        =>  'ticketsales',
                'sgl'           =>  'ticket',
                'label'         =>  'biglietti',
                'label_sgl'     =>  'biglietto',
                'description'   =>  'Tickets',
                'crud'          =>  true,
                'parameters'    =>  array(
                    'title' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Titolo',
                        'required'      =>  true,
                    ),
                    'description' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Descrizione',
                        'required'      =>  false,
                    ),
                    'subscription' =>  array(
                        'type'          =>  'boolean',
                        'description'   =>  'Abbonamento',
                        'required'      =>  false,
                    ),
                    'educational' =>  array(
                        'type'          =>  'boolean',
                        'description'   =>  'Percorso didattico',
                        'required'      =>  false,
                    ),
                    'payback' =>  array(
                        'type'          =>  'boolean',
                        'description'   =>  'Payback',
                        'required'      =>  false,
                    ),
                    'rate_id' =>  array(
                        'type'          =>  'fk',
                        'description'   =>  'Riduzione',
                        'required'      =>  true,
                        'fk'            =>  array(
                            'table'         =>  'rates',
                            'column'        =>  array('rid_description', 'prezzo', 'rid_code'),
                            'format'        =>  '%s (&euro; %s - rid. %s)',
                        ),
                    ),
                    /*'ticket_category_id' =>  array(
                        'type'          =>  'fk',
                        'description'   =>  'Categoria',
                        'required'      =>  false,
                        'fk'            =>  array(
                            'table'         =>  'ticketcategories',
                            'column'        =>  'title'
                        ),
                    ),
                    'ticket_group_id' =>  array(
                        'type'          =>  'fk',
                        'description'   =>  'Gruppo',
                        'required'      =>  false,
                        'fk'            =>  array(
                            'table'         =>  'ticketgroups',
                            'column'        =>  'title'
                        ),
                    ),*/
                    'interactive' =>  array(
                        'type'          =>  'boolean',
                        'description'   =>  'Interattivo',
                        'required'      =>  false,
                    ),
                    'hidden' =>  array(
                        'type'          =>  'boolean',
                        'description'   =>  'Nascosto',
                        'required'      =>  false,
                    ),
                ),
            ),
            'ticketsales'  =>  array(
                'classname'     =>  'TicketSale',
                'parent'        =>  null,
                'sgl'           =>  'ticketsale',
                'label'         =>  'biglietterie',
                'label_sgl'     =>  'biglietteria',
                'description'   =>  'TicketSales',
                'crud'          =>  true,
                'parameters'    =>  array(
                    'title' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Titolo',
                        'required'      =>  true,
                    ),
                    'description' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Descrizione',
                        'required'      =>  true,
                    ),
                    'layout_id' =>  array(
                        'type'          =>  'fk',
                        'description'   =>  'Layout (default)',
                        'required'      =>  false,
                        'fk'            =>  array(
                            'table'         =>  'layouts',
                            'column'        =>  'title'
                        ),
                    ),
                    'date_mandatory' =>  array(
                        'type'          =>  'boolean',
                        'description'   =>  'Data obbligatoria',
                        'required'      =>  false,
                    ),
                    /*'ticket_group_id' =>  array(
                        'type'          =>  'fk',
                        'description'   =>  'Gruppo biglietti (default)',
                        'required'      =>  false,
                        'fk'            =>  array(
                            'table'         =>  'ticketgroups',
                            'column'        =>  'title'
                        ),
                    ),
                    'service_group_id' =>  array(
                        'type'          =>  'fk',
                        'description'   =>  'Gruppo servizi (default)',
                        'required'      =>  false,
                        'fk'            =>  array(
                            'table'         =>  'servicegroups',
                            'column'        =>  'title'
                        ),
                    ),*/
                ),
            ),
            'services'  =>  array(
                'classname'     =>  'Service',
                'parent'        =>  'ticketsales',
                'sgl'           =>  'service',
                'label'         =>  'servizi',
                'label_sgl'     =>  'servizio',
                'description'   =>  'Services',
                'crud'          =>  true,
                'parameters'    =>  array(
                    'title' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Titolo',
                        'required'      =>  true,
                    ),
                    'subtitle' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Sottotitolo',
                        'required'      =>  false,
                    ),
                    'description' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Descrizione',
                        'required'      =>  true,
                    ),
                    'price' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Prezzo',
                        'required'      =>  true,
                    ),
                    'code' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Codice',
                        'required'      =>  false,
                    ),
                    'image' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Sfondo (URL)',
                        'required'      =>  false,
                    ),
                    /*'service_category_id' =>  array(
                        'type'          =>  'fk',
                        'description'   =>  'Categoria',
                        'required'      =>  false,
                        'fk'            =>  array(
                            'table'         =>  'servicecategories',
                            'column'        =>  'title'
                        ),
                    ),
                    'service_group_id' =>  array(
                        'type'          =>  'fk',
                        'description'   =>  'Gruppo',
                        'required'      =>  false,
                        'fk'            =>  array(
                            'table'         =>  'servicegroups',
                            'column'        =>  'title'
                        ),
                    ),*/
                    'interactive' =>  array(
                        'type'          =>  'boolean',
                        'description'   =>  'Interattivo',
                        'required'      =>  false,
                    ),
                ),
            ),
            'servicecategories'  =>  array(
                'classname'     =>  'ServiceCategory',
                'parent'        =>  'ticketsales',
                'sgl'           =>  'servicecategory',
                'label'         =>  'categorie servizi',
                'label_sgl'     =>  'categoria servizio',
                'description'   =>  'Service categories',
                'crud'          =>  true,
                'hidden'        =>  true,
                'parameters'    =>  array(
                    'title' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Titolo',
                        'required'      =>  true,
                    ),
                    'description' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Descrizione',
                        'required'      =>  true,
                    ),
                    'icon' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Icona',
                        'required'      =>  false,
                    ),
                ),
            ),
            'ticketcategories'  =>  array(
                'classname'     =>  'TicketCategory',
                'parent'        =>  'ticketsales',
                'sgl'           =>  'ticketcategory',
                'label'         =>  'categorie biglietti',
                'label_sgl'     =>  'categoria biglietti',
                'description'   =>  'Ticket categories',
                'crud'          =>  true,
                'hidden'        =>  true,
                'parameters'    =>  array(
                    'title' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Titolo',
                        'required'      =>  true,
                    ),
                    'description' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Descrizione',
                        'required'      =>  true,
                    ),
                ),
            ),
            'ticketgroups'  =>  array(
                'classname'     =>  'TicketGroup',
                'parent'        =>  'ticketsales',
                'sgl'           =>  'ticketgroup',
                'label'         =>  'gruppi biglietti',
                'label_sgl'     =>  'gruppo biglietti',
                'description'   =>  'TicketGroups',
                'crud'          =>  true,
                'hidden'        =>  true,
                'parameters'    =>  array(
                    'title' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Titolo',
                        'required'      =>  true,
                    ),
                    'description' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Descrizione',
                        'required'      =>  true,
                    ),
                    'ticket_sale_id' =>  array(
                        'type'          =>  'fk',
                        'description'   =>  'Biglietteria',
                        'required'      =>  true,
                        'fk'            =>  array(
                            'table'         =>  'ticketsales',
                            'column'        =>  'title'
                        ),
                    ),
                ),
            ),
            'servicegroups'  =>  array(
                'classname'     =>  'ServiceGroup',
                'parent'        =>  'ticketsales',
                'sgl'           =>  'servicegroup',
                'label'         =>  'gruppi servizi',
                'label_sgl'     =>  'gruppo servizi',
                'description'   =>  'ServiceGroups',
                'crud'          =>  true,
                'hidden'        =>  true,
                'parameters'    =>  array(
                    'title' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Titolo',
                        'required'      =>  true,
                    ),
                    'description' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Descrizione',
                        'required'      =>  true,
                    ),
                    'ticket_sale_id' =>  array(
                        'type'          =>  'fk',
                        'description'   =>  'Biglietteria',
                        'required'      =>  true,
                        'fk'            =>  array(
                            'table'         =>  'ticketsales',
                            'column'        =>  'title'
                        ),
                    ),
                ),
            ),
            'links'  =>  array(
                'classname'     =>  'Link',
                'parent'        =>  'ticketsales',
                'sgl'           =>  'link',
                'label'         =>  'link',
                'label_sgl'     =>  'link',
                'description'   =>  'Link',
                'crud'          =>  true,
                'parameters'    =>  array(
                    'title' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Titolo',
                        'required'      =>  true,
                    ),
                    'description' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Descrizione',
                        'required'      =>  false,
                    ),
                    'url' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'URL',
                        'required'      =>  true,
                    ),
                    'price' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Prezzo',
                        'required'      =>  false,
                    ),
                ),
            ),
            'layouts'  =>  array(
                'classname'     =>  'Layout',
                'parent'        =>  'ticketsales',
                'sgl'           =>  'layout',
                'label'         =>  'layout',
                'label_sgl'     =>  'layout',
                'description'   =>  'Layout',
                'crud'          =>  true,
                'parameters'    =>  array(
                    'title' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Titolo',
                        'required'      =>  true,
                    ),
                    'ticket_sale_id' =>  array(
                        'type'          =>  'fk',
                        'description'   =>  'Biglietteria',
                        'required'      =>  true,
                        'fk'            =>  array(
                            'table'         =>  'ticketsales',
                            'column'        =>  'title'
                        ),
                    ),
                    'message' =>  array(
                        'type'          =>  'text',
                        'description'   =>  'Messaggio',
                        'required'      =>  false,
                    ),
                ),
            ),
            'layout_sections'  =>  array(
                'classname'     =>  'LayoutSection',
                'parent'        =>  'ticketsales',
                'sgl'           =>  'layout_section',
                'label'         =>  'sezioni layout',
                'label_sgl'     =>  'sezione layout',
                'description'   =>  'Layout / Sezioni',
                'crud'          =>  true,
                'parameters'    =>  array(
                    'title' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Titolo',
                        'required'      =>  true,
                    ),
                    'icon' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Icona',
                        'required'      =>  false,
                    ),
                    'layout_id' =>  array(
                        'type'          =>  'fk',
                        'description'   =>  'Layout',
                        'required'      =>  true,
                        'fk'            =>  array(
                            'table'         =>  'layouts',
                            'column'        =>  'title'
                        ),
                    ),
                ),
            ),
            'layout_categories'  =>  array(
                'classname'     =>  'LayoutCategory',
                'parent'        =>  'ticketsales',
                'sgl'           =>  'layout_category',
                'label'         =>  'categorie layout',
                'label_sgl'     =>  'categoria layout',
                'description'   =>  'Layout / Categorie',
                'crud'          =>  true,
                'parameters'    =>  array(
                    'title' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Titolo',
                        'required'      =>  true,
                    ),
                    'description' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Descrizione',
                        'required'      =>  false,
                    ),
                    'icon' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Icona',
                        'required'      =>  false,
                    ),
                    'type' =>  array(
                        'type'          =>  'enum',
                        'choices'       =>  array(  'ticket'        =>  'Biglietti',
                                                    'ticket_visible'=>  'Biglietti visibili',
                                                    'ticket_hidden' =>  'Biglietti nascosti',
                                                    'service'       =>  'Servizi'   ),
                        'description'   =>  'Tipo',
                        'required'      =>  true,
                    ),
                ),
            ),
            'orders'  =>  array(
                'classname'     =>  'Order',
                'parent'        =>  'ticketsales',
                'sgl'           =>  'order',
                'label'         =>  'ordini',
                'label_sgl'     =>  'ordine',
                'description'   =>  'Orders',
                'orderby'       =>  'id',
                'order'         =>  'DESC',
                'crud'          =>  true,
                'parameters'    =>  array(
                    'id' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'ID',
                        'required'      =>  true,
                    ),
                    'barcode' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Codice',
                        'required'      =>  false,
                    ),
                    'status' =>  array(
                        'type'          =>  'label',
                        'description'   =>  'Status',
                        'required'      =>  true,
                    ),
                    'payment_method' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Pagamento',
                        'required'      =>  true,
                    ),
                    'total' =>  array(
                        'type'          =>  'money',
                        'description'   =>  'Totale',
                        'required'      =>  true,
                    ),
                    'identity_id' =>  array(
                        'type'          =>  'fk',
                        'description'   =>  'Identity',
                        'required'      =>  true,
                        'fk'            =>  array(
                            'table'         =>  'identities',
                            'column'        =>  array('surname', 'name'),
                        ),
                    ),
                    'visit_date' =>  array(
                        'type'          =>  'date',
                        'description'   =>  'Data di visita',
                        'required'      =>  false,
                        'placeholder'   =>  'N/A',
                    ),
                    'code_invoice'=>  array(
                        'type'          =>  'string',
                        'description'   =>  'Codice fattura',
                        'required'      =>  false,
                        'placeholder'   =>  '&mdash;',
                    ),
                    'coupon_code_id' =>  array(
                        'type'          =>  'fk',
                        'description'   =>  'Coupon',
                        'required'      =>  false,
                        'fk'            =>  array(
                            'table'         =>  'coupon_code',
                            'column'        =>  'code'
                        ),
                        'placeholder'   =>  'No',
                    ),
                ),
            ),
            'behaviours'  =>  array(
                'classname'     =>  'Behaviour',
                'parent'        =>  'ticketsales',
                'sgl'           =>  'behaviour',
                'label'         =>  'comportamenti',
                'label_sgl'     =>  'comportamento',
                'description'   =>  'Behaviours',
                'crud'          =>  true,
                'parameters'    =>  array(
                    'title' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Titolo',
                        'required'      =>  true,
                    ),
                    'ticket_sale_id' =>  array(
                        'type'          =>  'fk',
                        'description'   =>  'Biglietteria',
                        'required'      =>  false,
                        'fk'            =>  array(
                            'table'         =>  'ticketsales',
                            'column'        =>  'title'
                        ),
                    ),
                    'type' =>  array(
                        'type'          =>  'enum',
                        'choices'       =>  array(  'sum'        =>  'Somma'    ),
                        'description'   =>  'Tipo',
                        'required'      =>  true,
                    ),
                    'attribute' =>  array(
                        'type'          =>  'enum',
                        'choices'       =>  array(  'default_quantity'   =>  'Quantit&agrave; di default'    ),
                        'description'   =>  'Attributo CSS',
                        'required'      =>  true,
                    ),
                    'ratio' =>  array(
                        'type'          =>  'enum',
                        'choices'       =>  array(  '0.0500'    =>  '1 ogni 20',
                                                    '0.0667'    =>  '1 ogni 15',
                                                    '0.1000'    =>  '1 ogni 10',
                                                    '0.2000'    =>  '1 ogni 5',
                                                    '0.3334'    =>  '1 ogni 3',
                                                    '0.5000'    =>  '1 ogni 2 (ad es. 3X2)',
                                                    '0.6667'    =>  '2 ogni 3',
                                                    '1.0000'    =>  '1 ogni 1 (ad es. 2X1)'  ),
                        'description'   =>  'Rapporto',
                        'required'      =>  true,
                    ),
                ),
            ),
            'behaviour_layout_items'  =>  array(
                'classname'     =>  'BehaviourLayoutItem',
                'parent'        =>  'ticketsales',
                'sgl'           =>  'behaviour_layout_item',
                'label'         =>  'comportamenti elementi del layout',
                'label_sgl'     =>  'comportamento elemento del layout',
                'description'   =>  'BehaviourLayoutItems',
                'crud'          =>  true,
                'parameters'    =>  array(
                    'behaviour_id' =>  array(
                        'type'          =>  'fk',
                        'description'   =>  'Comportamento',
                        'required'      =>  true,
                        'fk'            =>  array(
                            'table'         =>  'behaviours',
                            'column'        =>  'title'
                        ),
                    ),
                    'layout_item_id' =>  array(
                        'type'          =>  'fk',
                        'description'   =>  'Elemento del layout',
                        'required'      =>  true,
                        'fk'            =>  array(
                            'table'         =>  'layout_items',
                            'column'        =>  'title'
                        ),
                    ),
                    'use' =>  array(
                        'type'          =>  'enum',
                        'choices'       =>  array(  'origin'        =>  'Origine',
                                                    'destination'   =>  'Destinazione'  ),
                        'description'   =>  'Utilizzo',
                        'required'      =>  true,
                    ),
                ),
            ),
            'coupons'  =>  array(
                'classname'     =>  'Coupon',
                'parent'        =>  'ticketsales',
                'sgl'           =>  'coupon',
                'label'         =>  'coupon',
                'label_sgl'     =>  'coupon',
                'description'   =>  'Coupon',
                'crud'          =>  true,
                'parameters'    =>  array(
                    'title' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Titolo',
                        'required'      =>  true,
                    ),
                    'description' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Descrizione',
                        'required'      =>  false,
                    ),
                    'type' =>  array(
                        'type'          =>  'enum',
                        'choices'       =>  array(  'layout_switch_by_id'   =>  'Cambio layout con ID',
                                                    'layout_switch_by_title'=>  'Cambio layout con titolo',
                                                    'discount_fixed'        =>  'Sconto con importo fisso',
                                                    'discount_percent'      =>  'Sconto con percentuale'    ),
                        'description'   =>  'Tipo',
                        'required'      =>  true,
                    ),
                    'ticket_sale_id' =>  array(
                        'type'          =>  'fk',
                        'description'   =>  'Biglietteria',
                        'required'      =>  false,
                        'fk'            =>  array(
                            'table'         =>  'ticketsales',
                            'column'        =>  'title'
                        ),
                    ),
                    'layout_id' =>  array(
                        'type'          =>  'fk',
                        'description'   =>  'Layout (ID)',
                        'required'      =>  false,
                        'fk'            =>  array(
                            'table'         =>  'layouts',
                            'column'        =>  'title'
                        ),
                    ),
                    'layout_title' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Layout (Titolo)',
                        'required'      =>  false,
                    ),
                    'behaviour_id' =>  array(
                        'type'          =>  'fk',
                        'description'   =>  'Comportamento',
                        'required'      =>  false,
                        'fk'            =>  array(
                            'table'         =>  'behaviours',
                            'column'        =>  'title'
                        ),
                    ),
                    'discount_fixed' =>  array(
                        'type'          =>  'float',
                        'description'   =>  'Sconto (fisso)',
                        'required'      =>  false,
                    ),
                    'discount_percent' =>  array(
                        'type'          =>  'float',
                        'description'   =>  'Sconto (percentuale)',
                        'required'      =>  false,
                    ),
                ),
            ),
            'coupon_codes'  =>  array(
                'classname'     =>  'CouponCode',
                'parent'        =>  'ticketsales',
                'sgl'           =>  'coupon_code',
                'label'         =>  'codici coupon',
                'label_sgl'     =>  'codice coupon',
                'description'   =>  'CouponCodes',
                'crud'          =>  true,
                'parameters'    =>  array(
                    'title' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Titolo',
                        'required'      =>  true,
                    ),
                    'description' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Descrizione',
                        'required'      =>  false,
                    ),
                    'coupon_id' =>  array(
                        'type'          =>  'fk',
                        'description'   =>  'Coupon',
                        'required'      =>  true,
                        'fk'            =>  array(
                            'table'         =>  'coupons',
                            'column'        =>  'title'
                        ),
                    ),
                    'code' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Codice',
                        'required'      =>  true,
                    ),
                    'expiration_datetime' =>  array(
                        'type'          =>  'datetime',
                        'description'   =>  'Scadenza',
                        'required'      =>  true,
                    ),
                    'remaining_collections' =>  array(
                        'type'          =>  'integer',
                        'description'   =>  'Riscossioni rimanenti',
                        'required'      =>  true,
                    ),
                ),
            ),
            'widgets'  =>  array(
                'classname'     =>  'Widget',
                'parent'        =>  'ticketsales',
                'sgl'           =>  'widget',
                'label'         =>  'widget',
                'label_sgl'     =>  'widget',
                'description'   =>  'Widgets',
                'crud'          =>  true,
                'parameters'    =>  array(
                    'title' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Titolo',
                        'required'      =>  true,
                    ),
                    'description' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Descrizione',
                        'required'      =>  false,
                    ),
                    'coupon_code_id' =>  array(
                        'type'          =>  'fk',
                        'description'   =>  'Codice coupon',
                        'required'      =>  true,
                        'fk'            =>  array(
                            'table'         =>  'coupon_codes',
                            'column'        =>  array('title', 'code'),
                            'format'        =>  '%s (codice: %s)',
                        ),
                    ),
                    'code' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Codice',
                        'required'      =>  true,
                    ),
                    'image' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Logo',
                        'required'      =>  true,
                    ),
                    'document' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'PDF',
                        'required'      =>  false,
                    ),
                    'width' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Larghezza',
                        'required'      =>  false,
                    ),
                    'height' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Altezza',
                        'required'      =>  false,
                    ),
                    'embed_code' =>  array(
                        'type'              =>  'text',
                        'description'       =>  'HTML',
                        'required'          =>  false,
                        'plain_text'        =>  true,
                        'crud_placeholder'  =>  'Autogenerato, se non specificato',
                    ),
                ),
            ),
            'hotels'  =>  array(
                'classname'     =>  'Hotel',
                'parent'        =>  'ticketsales',
                'sgl'           =>  'hotel',
                'label'         =>  'hotel',
                'label_sgl'     =>  'hotel',
                'description'   =>  'Hotels',
                'crud'          =>  true,
                'parameters'    =>  array(
                    'title' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Titolo',
                        'required'      =>  true,
                    ),
                    'description' =>  array(
                        'type'          =>  'text',
                        'description'   =>  'Descrizione',
                        'required'      =>  false,
                    ),
                    'email' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Email',
                        'required'      =>  false,
                    ),
                    'stars' =>  array(
                        'type'          =>  'enum',
                        'description'   =>  'Stelle',
                        'required'      =>  false,
                        'choices'       =>  array(
                                                '1' =>  '1 stella',
                                                '2' =>  '2 stelle',
                                                '3' =>  '3 stelle',
                                                '4' =>  '4 stelle',
                                                '5' =>  '5 stelle',
                                            ),
                    ),
                    'address' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Indirizzo',
                        'required'      =>  false,
                    ),
                    'map' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Mappa (URL)',
                        'required'      =>  false,
                    ),
                    'distance_km' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Distanza in km',
                        'required'      =>  false,
                    ),
                    'distance_label' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Distanza (etichetta)',
                        'required'      =>  false,
                    ),
                    'info' =>  array(
                        'type'          =>  'text',
                        'description'   =>  'Informazioni',
                        'required'      =>  false,
                    ),
                    'pictures' =>  array(
                        'type'          =>  'text',
                        'description'   =>  'Fotografie',
                        'required'      =>  false,
                    ),
                    'ticket_id' =>  array(
                        'type'          =>  'fk',
                        'description'   =>  'Biglietto',
                        'required'      =>  false,
                        'fk'            =>  array(
                            'table'         =>  'tickets',
                            'column'        =>  'title',
                        ),
                    ),
                ),
            ),
            'room_types'  =>  array(
                'classname'     =>  'RoomType',
                'parent'        =>  'ticketsales',
                'sgl'           =>  'room_type',
                'label'         =>  'tipologie stanza',
                'label_sgl'     =>  'tipologia stanza',
                'description'   =>  'RoomTypes',
                'crud'          =>  true,
                'parameters'    =>  array(
                    'title' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Titolo',
                        'required'      =>  true,
                    ),
                    'title_short' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Titolo (breve)',
                        'required'      =>  true,
                    ),
                    'persons' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'N. Persone',
                        'required'      =>  true,
                    ),
                    'rooms_search_default' =>  array(
                        'type'          =>  'string',
                        'description'   =>  'Q.tà default',
                        'required'      =>  false,
                    ),
                ),
            ),
        );
    }

    public function describeEntity($entity){
        return $this->createMetaMessage($this->schemas[$entity], '200');
    }

    public function describeAll(){
        return $this->createMetaMessage($this->schemas, '200');
    }
    
}
