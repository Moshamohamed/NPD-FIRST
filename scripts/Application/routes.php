<?php


// Route::set('get','Main\Home\loadData','POST');

// Route::set('get','Main\Home\loadData','GET');


return array(

    'routes'        => array(

        'home'    => array(

        'controller'    => 'Main\Home',

        'only-args'     => 2,

        'methods'       => array(

            'post'      =>  array(array('edit', 2)),

            'get'       => array(array('view' , 1) , 'all', 'load'),

        ),

        'call-before'   => array(),

       'call-after'    => array(),

      ), 
    ),  
    

   'not-found'      => 'Error\\NotFound',

   'call-before'    => array(),

   'call-after'     => array(),

);