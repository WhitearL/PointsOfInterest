function createAddPOIForm() {

     // Create new form element
     var createform = document.createElement('form');

     // Action associated with form
     createform.setAttribute("action", "");

     // Set method to post to add data to db
     createform.setAttribute("method", "post");

     // Container div for the table and heading
     var container = document.createElement('div');
     container.className = "dynamicform bordered";

     // Form heading
     var heading = document.createElement('h2');
     heading.innerHTML = "Add a new point of interest";

     // Underline heading
     var line = document.createElement('hr');

     // Add heading and heading underline.
     container.appendChild(heading);
     container.appendChild(line);

     // Label for name field
     var nameLabel = document.createElement('label');
     nameLabel.innerHTML = "POI Name: ";

     // Input for name field
     var nameElement = document.createElement('input');
     nameElement.setAttribute("type", "text");
     nameElement.setAttribute("name", "poiName");

     // Label for poi type
     var typeLabel = document.createElement('label');
     typeLabel.innerHTML = "POI Type: ";

     // Input for poi type
     var typeElement = document.createElement('input');
     typeElement.setAttribute("type", "text");
     typeElement.setAttribute("name", "poiType");

     // Label for poi country
     var countryLabel = document.createElement('label');
     countryLabel.innerHTML = "Country: ";

     // Input for poi country
     var countryElement = document.createElement('input');
     countryElement.setAttribute("type", "text");
     countryElement.setAttribute("name", "poiCountry");

     // Label for poi region
     var regionLabel = document.createElement('label');
     regionLabel.innerHTML = "Region: ";

     // Input for poi region
     var regionElement = document.createElement('input');
     regionElement.setAttribute("type", "text");
     regionElement.setAttribute("name", "poiRegion");

     // Label for description field
     var descLabel = document.createElement('label');
     descLabel.innerHTML = "Description: ";

     // Text area for description field
     var descElement = document.createElement('textarea');
     descElement.setAttribute("name", "poiDescription");

     // Latitude label
     var latLabel = document.createElement('label');
     latLabel.innerHTML = "Lat.: ";

     // Latitude element
     var latElement = document.createElement('input');
     latElement.setAttribute("name", "poiLat");

     // Longitude label
     var longLabel = document.createElement('label');
     longLabel.innerHTML = "Long.: ";

     // Longitude element
     var longElement = document.createElement('input');
     longElement.setAttribute("name", "poiLong");

     // Submit button
     var submitElement = document.createElement('input');
     submitElement.setAttribute("type", "submit");
     submitElement.setAttribute("name", "poiSubmit");
     submitElement.setAttribute("value", "Submit");
     createform.appendChild(submitElement);

     // Table root element
     var alignTable = document.createElement('table');

          // Table body element
          var tableBody = document.createElement('tbody');

               // Name Row
               var trPOIName = document.createElement('tr');

                    // Name label.
                    var tdLblPOIName = document.createElement('th');
                    tdLblPOIName.appendChild(nameLabel);
                    trPOIName.appendChild(tdLblPOIName);

                    // Name input field.
                    var thInputPOIName = document.createElement('th');
                    thInputPOIName.appendChild(nameElement);
                    trPOIName.appendChild(thInputPOIName);

               tableBody.appendChild(trPOIName);

               // POI type row
               var trPOIType = document.createElement('tr');

                    // Type Label
                    var thLblPOIType = document.createElement('th');
                    thLblPOIType.appendChild(typeLabel);
                    trPOIType.appendChild(thLblPOIType);

                    // Type input field.
                    var thInputPOIType = document.createElement('th');
                    thInputPOIType.appendChild(typeElement);
                    trPOIType.appendChild(thInputPOIType);

               tableBody.appendChild(trPOIType);

               // POI country row
               var trPOICountry = document.createElement('tr');

                    // Country Label
                    var thLblPOICountry = document.createElement('th');
                    thLblPOICountry.appendChild(countryLabel);
                    trPOICountry.appendChild(thLblPOICountry);

                    // Country input field.
                    var thInputPOICountry = document.createElement('th');
                    thInputPOICountry.appendChild(countryElement);
                    trPOICountry.appendChild(thInputPOICountry);

               tableBody.appendChild(trPOICountry);

               // POI region row
               var trPOIRegion = document.createElement('tr');

                    // Country Label
                    var thLblPOIRegion = document.createElement('th');
                    thLblPOIRegion.appendChild(regionLabel);
                    trPOIRegion.appendChild(thLblPOIRegion);

                    // Country input field.
                    var thInputPOIRegion = document.createElement('th');
                    thInputPOIRegion.appendChild(regionElement);
                    trPOIRegion.appendChild(thInputPOIRegion);

               tableBody.appendChild(trPOIRegion);

               // POI latlon row
               var trPOILatLon = document.createElement('tr');

                    // Lat label
                    var thLblPOILat = document.createElement('th');
                    thLblPOILat.appendChild(latLabel);
                    trPOILatLon.appendChild(thLblPOILat);

                    // Lat field
                    var thInputPOILat = document.createElement('th');
                    thInputPOILat.appendChild(latElement);
                    trPOILatLon.appendChild(thInputPOILat);

                    // Lon label
                    var thLblPOILon = document.createElement('th');
                    thLblPOILon.appendChild(longLabel);
                    trPOILatLon.appendChild(thLblPOILon);

                    // Lon field
                    var thInputPOILon = document.createElement('th');
                    thInputPOILon.appendChild(longElement);
                    trPOILatLon.appendChild(thInputPOILon);

               tableBody.appendChild(trPOILatLon);

               // POI description row
               var trPOIDesc = document.createElement('tr');

                    // Description Label
                    var thLblPOIDesc = document.createElement('th');
                    thLblPOIDesc.appendChild(descLabel);
                    trPOIDesc.appendChild(thLblPOIDesc);

                    // Description input field.
                    var thInputPOIDesc = document.createElement('th');
                    thInputPOIDesc.appendChild(descElement);
                    trPOIDesc.appendChild(thInputPOIDesc);

               tableBody.appendChild(trPOIDesc);

     // Append tablebody to table
     alignTable.appendChild(tableBody);

     // Append table to container.
     container.appendChild(alignTable);

     // Append a line break to container under the table.
     var linebreak = document.createElement('br');
     container.appendChild(linebreak);

     // Append the submit button to the container.
     container.appendChild(submitElement);

     // Return the div to be displayed in html.
     return container;
}
