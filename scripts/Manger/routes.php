<?php

// Route File

return array(

    'routes'        => array(

        'home'    => array(

        'controller'    => 'Main\\Home',

        'methods'       => array(

            'post'      =>  array(array('edit', 2)),

            'get'       => array(array('view' , 1) , 'all'),

        ),

        'call-before'   => array(),

       'call-after'    => array(),

      ),

    ),

   'not-found'      => 'Error\\NotFound',

   'call-before'    => array(),

   'call-after'     => array(),

);