<?php
if (!isset($TEMPLATE)) {
  include_once 'functions.inc.php';

  try {
    // configuration
    include_once '../conf/service.inc.php';

    // caching headers
    $CACHE_MAXAGE = 900;
    include_once '../lib/cache.inc.php';

    $usage = false;
    $method = param('method');
    if ($method === 'places') {
      $SERVICE->places();
    } else if ($method === 'regions') {
      $SERVICE->regions($_GET);
    } else {
      $usage = true;
    }
  } catch (Exception $e) {
    // trigger error, this will go to logs in production
    trigger_error($e->getMessage());
    // output generic error message.
    $SERVICE->error(500, 'Server Error');
  }

  if (!$usage) {
    return;
  }

  $TITLE = 'Regions API Documentation';
  $NAVIGATION = true;
  $HEAD = '<link rel="stylesheet" href="index.css"/>';

  include 'template.inc.php';
}
?>

<h2>Regions</h2>
<p>
  A Regions Search takes the following form:
</p>
<?php
  echo '<pre><code>',
    $HOST_URL_PREFIX, $MOUNT_PATH, '/regions',
    '?<em>parameters</em>',
    '</code></pre>';
 ?>

 <h3>Request Parameters</h3>
 <p>
   All parameters must be passed in the query string.
   Only listed parameters may be used, others will generate an error.
   Empty values for these parameters are not supported.
 </p>


 <h4>Required Parameters</h4>
 <table class="tabular parameters responsive">
   <thead>
     <tr>
       <th>parameter</th>
       <th>type</th>
       <th>description</th>
     </tr>
   </thead>
   <tbody class="no-header-style">
     <tr id="latitude">
       <th>
         <code>latitude</code>
       </th>
       <td>Decimal</td>
       <td>
         Latitude in decimal degrees. [-90,90] degrees.
       </td>
     </tr>
     <tr id="longitude">
       <th><code>longitude</code></th>
       <td>Decimal</td>
       <td>
         Longitude in decimal degrees. [-180,180] degrees.
       </td>
     </tr>
   </tbody>
 </table>

 <h4>Optional Parameters</h4>
 <table class="tabular parameters responsive">
   <thead>
     <tr>
       <th>parameter</th>
       <th>type</th>
       <th>description</th>
     </tr>
   </thead>
   <tbody class="no-header-style">
     <tr id="limit">
       <th><code>includeGeometry</code></th>
       <td>Boolean</td>
       <td>
         Set to true returns poloygon points of the selected region.
       </td>
     </tr>
     <tr id="limit">
      <th><code>type</code></th>
      <td>String</td>
      <td>
        Region Types (admin, authoritative, fe, neic_catalog, neic_response).
      </td>
     </tr>
   </tbody>
 </table>

 <h3>Response Properties</h3>
 <p>
   <h4>Admin Regions</h4>
 </p>
 <table class="tabular parameters responsive">
   <thead>
     <tr>
       <th>property</th>
       <th>type</th>
       <th>description</th>
     </tr>
   </thead>
   <tbody class="no-header-style">
     <tr id="iso">
       <th><code>iso</code></th>
       <td>String</span></td>
       <td>
         Country Code.
       </td>
     </tr>
     <tr id="country">
       <th><code>Country</code></th>
       <td>String</td>
       <td>
         Name of Country.
       </td>
     </tr>
     <tr id="region">
       <th><code>Region</code></th>
       <td>String</td>
       <td>
         Name of region
       </td>
     </tr>
   </tbody>
 </table>

 <p>
   <h4>Authoritative Regions</h4>
 </p>
 <table class="tabular parameters responsive">
   <thead>
     <tr>
       <th>property</th>
       <th>type</th>
       <th>description</th>
     </tr>
   </thead>
   <tbody class="no-header-style">
     <tr id="name">
       <th><code>Name</code></th>
       <td>String</span></td>
       <td>
         Name of place.
       </td>
     </tr>
     <tr id="network">
       <th><code>Network</code></th>
       <td>String</td>
       <td>
         Name of network.
       </td>
     </tr>
   </tbody>
 </table>

 <p>
   <h4>FE Regions</h4>
 </p>
 <table class="tabular parameters responsive">
   <thead>
     <tr>
       <th>property</th>
       <th>type</th>
       <th>description</th>
     </tr>
   </thead>
   <tbody class="no-header-style">
     <tr id="num">
       <th><code>Num</code></th>
       <td>Integer</span></td>
       <td>
         FE region identification number.
       </td>
     </tr>
     <tr id="name">
       <th><code>Name</code></th>
       <td>String</td>
       <td>
         Name of FE region.
       </td>
     </tr>
   </tbody>
 </table>

<p>
  <h4>NEIC Catalog Regions</h4>
</p>
<table class="tabular parameters responsive">
  <thead>
    <tr>
      <th>property</th>
      <th>type</th>
      <th>description</th>
    </tr>
  </thead>
  <tbody class="no-header-style">
    <tr id="name">
      <th><code>name</code></th>
      <td>String</span></td>
      <td>
        NEIC catalog name.
      </td>
    </tr>
    <tr id="magnitude">
      <th><code>Magnitude</code></th>
      <td>Decimal</td>
      <td>
        Magnitude associated with the place.
      </td>
    </tr>
  </tbody>
</table>

<p>
  <h4>NEIC Response Regions</h4>
</p>
<table class="tabular parameters responsive">
  <thead>
    <tr>
      <th>property</th>
      <th>type</th>
      <th>description</th>
    </tr>
  </thead>
  <tbody class="no-header-style">
    <tr id="name">
      <th><code>name</code></th>
      <td>String</span></td>
      <td>
        NEIC response name.
      </td>
    </tr>
    <tr id="magnitude">
      <th><code>Magnitude</code></th>
      <td>Decimal</td>
      <td>
        Magnitude associated with the place.
      </td>
    </tr>
  </tbody>
</table>
 <h3>Example Requests</h3>

 <h4>Region search at latitude 39.5, longitude -105</h4>
 <?php
   $url = $HOST_URL_PREFIX . $MOUNT_PATH .
       '/regions?latitude=39.5&longitude=-105';
   echo '<pre><code><a href="', $url, '">', $url, '</a></code></pre>';
 ?>

 <h4>
   Region search at latitude 39.5, longitude -105, includeGeometry set to true.
</h4>
 <?php
   $url = $HOST_URL_PREFIX . $MOUNT_PATH .
       '/regions?latitude=39.5&longitude=-105&includeGeometry=true';
   echo '<pre><code><a href="', $url, '">', $url, '</a></code></pre>';
 ?>

<h4>
  Region search at latitude 39.5, longitude -105, type set to fe.
</h4>
<?php
  $url = $HOST_URL_PREFIX . $MOUNT_PATH .
      '/regions?latitude=39.5&longitude=-105&type=fe';
  echo '<pre><code><a href="', $url, '">', $url, '</a></code></pre>';
?>
