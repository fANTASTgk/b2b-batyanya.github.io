<?php
$arUrlRewrite=array (
  0 => 
  array (
    'CONDITION' => '#^={SITE_DIR."personal/companies/"}#',
    'RULE' => '',
    'ID' => 'sotbit:auth.company',
    'PATH' => '/personal/companies/index.php',
    'SORT' => 100,
  ),
  5 => 
  array (
    'CONDITION' => '#^={SITE_DIR."orders/offerlist/"}#',
    'RULE' => '',
    'ID' => 'sotbit:offerlist',
    'PATH' => '/orders/offerlist/index.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^={SITE_DIR."/personal/buyer/"}#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.profile',
    'PATH' => '/personal/buyer/index.php',
    'SORT' => 100,
  ),
  11 => 
  array (
    'CONDITION' => '#^/orders/detail/[0-9]+/#',
    'RULE' => '',
    'ID' => 'sotbit:auth.company.order',
    'PATH' => '/orders/index.php',
    'SORT' => 100,
  ),
  6 => 
  array (
    'CONDITION' => '#^={SITE_DIR."orders/"}#',
    'RULE' => '',
    'ID' => 'sotbit:auth.company.order',
    'PATH' => '/orders/index.php',
    'SORT' => 100,
  ),
  15 => 
  array (
    'CONDITION' => '#^/orders/blank_zakaza/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/orders/blank_zakaza/index.php',
    'SORT' => 100,
  ),
  16 => 
  array (
    'CONDITION' => '#^/orders/make/#',
    'RULE' => '',
    'ID' => 'sotbit:basket.upselling',
    'PATH' => '/orders/make/index.php',
    'SORT' => 100,
  ),
  2 => 
  array (
    'CONDITION' => '#^/complaints/#',
    'RULE' => '',
    'ID' => 'sotbit:complaints',
    'PATH' => '/complaints/index.php',
    'SORT' => 100,
  ),
  7 => 
  array (
    'CONDITION' => '#^/documents/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/documents/index.php',
    'SORT' => 100,
  ),
  10 => 
  array (
    'CONDITION' => '#^/catalog/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/catalog/index.php',
    'SORT' => 100,
  ),
);
