<?php
/**
 * DeviceAtlas DeviceApiWeb Basic Usage Example.
 *
 * This example demonstrates using the DeviceApiWeb, and using the configurations
 * available for caching the lookup results with a cache provider.
 *
 * Please see:
 *     - The README.DeviceApi.txt notes about optimizing the DeviceApi usage.
 *
 * @copyright Copyright (c) 2008-2015 by Afilias Technologies Limited (dotMobi). All rights reserved.
 * @author Afilias Technologies Ltd
 */

// to see all errors only when in development environment
error_reporting(E_ALL);
ini_set('display_errors', 1);



/* (1-a) Include the DeviceApiWeb library */
require_once dirname(__FILE__).'/../../../../Api/Device/DeviceApiWeb.php';

/* (1-b) Include a cache provider */
require_once dirname(__FILE__).'/../../../../Api/CacheProvider/MemCacheProvider.php';
//require_once '../../../../Api/CacheProvider/ApcCacheProvider.php';
//require_once '../../../../Api/CacheProvider/FileCacheProvider.php';
//or create your own cache provider and use it

// Place the path to your JSON data here > > >
define('JSON_FILE', '/path/to/the/datafile.json');


/* (2) Create and config a DeviceApiWeb instance */

/* (2-a) You can change the default configs of the API by creating an instance of
   "Mobi_Mtld_DA_Device_Config" and passing it to the DeviceApi constructor */
$config = new Mobi_Mtld_DA_Device_Config();

/* (2-b) Create a cache provider instance and set it in the config */
$cacheItemExpiry   = 172800; // set to two days (default is one day)
$cacheProvider     = new Mobi_Mtld_DA_CacheProvider_MemCacheProvider($cacheItemExpiry);
//$cacheProvider   = new Mobi_Mtld_DA_CacheProvider_ApcCacheProvider();
//$cacheProvider   = new Mobi_Mtld_DA_CacheProvider_FileCacheProvider();
$config->setCacheProvider($cacheProvider);

//for the highest performance and lowest memory foot print use data file optimizer and cache provider together
//$config->setUseTreeOptimizer(true);

/* (2-c) Create a DeviceApiWeb instance */
$deviceApi = new Mobi_Mtld_DA_Device_DeviceApiWeb($config);


$errorMsg = null;
// it is highly recommended to use the API in a try/catch block as several exceptions
// may be thrown, please see the API documentation to know about the exceptions
try {

    /* (3) Load the device atlas JSON data file */
    //
    // if $config->setIgnoreDataFileChanges(false); then:
    //      if cached data exists and JSON_FILE is the same file which the cached where created from or JSON_FILE not exists
    //          then the cached data is used for the lookup
    //      else the JSON_FILE will be optimized and cached and used for this lookup and next lookups
    //
    // if $config->setIgnoreDataFileChanges(true); then:
    //      if cached data exists then it will be loaded and used for the lookup, even if JSON_FILE not exists or is changed
    //      if cached data not exists then JSON_FILE will be optimized and cached and used for this lookup and next lookups
    //
    $deviceApi->loadDataFromFile(JSON_FILE);

    /* (4) Get properties for current request */
    //
    // the API will check if a cached value exists for the current request headers,
    //     if cache exists then the cached value will be returned
    //     if not then the API will do a property lookup and will return and cache the results using the cache provider
    //
    $properties = $deviceApi->getProperties();

} catch (Mobi_Mtld_Da_Exception_DataFileException $ex) {
    $errorMsg = "Could not find Device Data file. Did you download a data file from https://deviceatlas.com/user to be referenced by this example?\n";

} catch (Exception $ex) {
    // all errors must be taken care of
    $errorMsg = $ex->getMessage();
}


/**
 * The returned value from the API is an instance of "Mobi_Mtld_DA_Properties",
 * this object contains the property set and is iterable.
 *
 * Each property value is an instance of "Mobi_Mtld_DA_Property", you can get
 * the value as string or typed from this objects, also you can get the property
 * data type.
 *
 * This function iterates over the properties instance and creates a table from it.
 */
function displayPropertiesAsHtml($properties) {
    if ($properties) {
        print '<table>';
        foreach ($properties as $name => $property) {
            print
              '<tr>
                <td class="prop-name">'.$name.':</td>
                <td class="type">('.$property->getDataType().')</td>
                <td>'.$property->value().'</td>
              </tr>';
        }
        print '</table>';

    } else {
        print '<p>No results returned.</p>';
    }
}

/**
 * Iterating over the properties may not be a good example of real life usage
 * so here we demonstrate usages that are more likely to happen after a detection.
 */
function displayPropertiesUsagesAsHtml($properties) {
    // use Properties.contains() to check if a property has a specific value
    // if the property value is the same as expected, true will be returned
    // if the property value does not match, property does not exist or is invalid, false will be returned
    print '<table id="usage">';

    // check if mobileDevice is true?
    $isMobileDevice = $properties->contains('mobileDevice', true);

    // check is vendor is Samsung (case-sensitive)
    $isSamsung = $properties->contains('vendor', 'Samsung');

    // lets display something based on what we got
    print $isMobileDevice?
        "<tr><td>contains(mobileDevice, true)</td><td>it's a mobile device</td></tr>":
        "<tr><td>contains(mobileDevice, true)</td><td>it's not a mobile device</td></tr>";

    print $isSamsung?
        "<tr><td>contains(vendor, Samsung)</td><td>vendor is Samsung</td></tr>":
        "<tr><td>contains(vendor, Samsung)</td><td>vendor is not Samsung</td></tr>";





    // get a specific property value
    // before getting a property always check if the property exists in the set

    // to get the property value without considering the data type strictly
    $browserName1 = $properties->containsKey('browserName')? $properties->get('browserName')->value(): 'not available';

    // you can get any property value as a string
    $browserName2 = $properties->containsKey('browserName')? $properties->get('browserName')->asString(): 'not available';

    // you can get the property value like this but if property does not exists the value will be null
    $browserName3 = $properties->browserName;

    // if you know the exact data type of a property you can get it as typed
    $yearReleased = $properties->containsKey('yearReleased')? $properties->get('yearReleased')->asInteger(): 'not available';

    $isBrowser    = $properties->containsKey('isBrowser')? $properties->get('isBrowser')->asBoolean(): 'not available';

    // lets display the results
    print "<tr><td>Property.value()    </td><td> browserName  = $browserName1</td></tr>";
    print "<tr><td>Property.asString() </td><td> browserName  = $browserName2</td></tr>";
    print "<tr><td>Properties.__get()  </td><td> browserName  = $browserName3</td></tr>";
    print "<tr><td>Property.asInteger()</td><td> yearReleased = $yearReleased</td></tr>";
    print "<tr><td>Property.asBoolean()</td><td> isBrowser    = ".($isBrowser? 'true': 'false').'</td></tr>';

    // if you try to get the wrong data type from a property then an exception will be thrown
    try {
        if ($properties->containsKey('displayColorDepth')) {
            $yearReleased = $properties->get('displayColorDepth')->asBoolean();
        }
    } catch (Exception $x) {
        print "<tr><td>using Property.asBoolean() on a string data type property caused an exception</td><td>displayColorDepth is not boolean</td></tr>";
    }





    // get the data type of a property
    if ($properties->containsKey('vendor')) {
        $dataType = $properties->get('vendor')->getDataType();
        print "<tr><td>Property.getDataType()</td><td>The data type of 'vendor' is $dataType</td></tr>";
    }

    // check property data types
    if ($properties->containsKey('yearReleased')) {

        $dataTypeId = $properties->get('yearReleased')->getDataTypeId();
        $typeMsg    = '';
        switch ($dataTypeId) {
            case Mobi_Mtld_DA_DataType::INTEGER:
                $typeMsg = "yearReleased is integer";
                break;
            case Mobi_Mtld_DA_DataType::BOOLEAN:
                $typeMsg = "yearReleased is boolean";
                break;
            case Mobi_Mtld_DA_DataType::STRING:
                $typeMsg = "yearReleased is string";
                break;
        }

        print "<tr><td>Property.getDataTypeId()</td><td>$typeMsg</td></tr>";
    }

    print '</table>';
}




/**
 * Displaying properties in various ways as HTML
 * demonstrates the usage of "getProperties()" method and how to use it's output
 */
?>

<!doctype html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>DeviceAtlas DeviceApiWeb Example</title>
    <link type="text/css" rel="stylesheet" href="css/style.css" media="all"/>

    <!-- Adding the DeviceAtlas client side component to get client side properties -->
    <script type="text/javascript" src="js/deviceatlas-1.3.min.js"></script>

  </head>
  <body>
    <h1>DeviceAtlas DeviceApiWeb Example</h1>
    <div id="api">
      <ul>
        <li>
          <label>API Version:</label>
          <span><?php print $deviceApi->getApiVersion()?></span>
        </li>
        <li>
          <label>Data Version:</label>
          <span><?php print $deviceApi->getDataVersion()?></span>
        </li>
        <li>
          <label>Data generation timestamp:</label>
          <span><?php print $deviceApi->getDataCreationTimestamp()?></span>
        </li>
        <li>
          <label>Lookup data source:</label>
          <span><?php print $deviceApi->getLookupSource()?></span>
        </li>
      </ul>
    </div>

<?php

/* check for errors */
if ($errorMsg) {
    print '<h3>Errors:</h3><p id="error">'.$errorMsg.'</p>';

/* if everything is ok then display properties */
} else {
?>

    <div id="results">
      <h2>Results (full set of detected properties):</h2>
      <div>
       <?php displayPropertiesAsHtml($properties); ?>
      </div>
    <div>

    <div id="results">
      <h2>Results (other usages):</h2>
      <div>
       <?php displayPropertiesUsagesAsHtml($properties); ?>
      </div>
    <div>

<?php
}
?>

  </body>
</html>
