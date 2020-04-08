class AddPOIFormHandler {

     // This class uses controls as public fields such that we can access their data and post it to the databse.
     // It is responsible for creating the Add POI form interface, and posting the data from the user.

     // Public constructor, allow instantiation
     constructor(CSRFToken) {
          // CSRF token generated from php just before the class was instantiated.
          CSRF = CSRFToken;
     }

     // Event handler for submit poi button.
     submitData() {

          // XML HTTP request object.
          var httpRequest = new XMLHttpRequest();

          // Callback function
          var responseCallback = function handlePOIResponse(responseData) {
               document.getElementById("responseOutput").innerHTML = responseData.target.responseText;
          };

          // Specify the callback function.
          httpRequest.addEventListener("load", responseCallback);

          // Append data to form object, and send using the HTTP Request.
          let formData = new FormData();

          // Open the request using POST.
          httpRequest.open('POST', '../../pointsofinterest/script/AddPOI.php');

          // Get values from DOM elements.
          formData.append("POIName",    document.getElementById("poiName").value);
          formData.append("POIType",    document.getElementById("poiType").value);
          formData.append("POICountry", document.getElementById("poiCountry").value);
          formData.append("POIRegion",  document.getElementById("poiRegion").value);
          formData.append("POILat",     document.getElementById("poiLat").value);
          formData.append("POILong",    document.getElementById("poiLong").value);
          formData.append("POIDesc",    document.getElementById("poiDescription").value);

          // Append CSRF token from php.
          formData.append("CSRF", CSRF);

          // Send the request.
          httpRequest.send(formData);
     }

     // Create the form UI to display on screen
     createForm() {

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
          this.nameLabel = document.createElement('label');
          this.nameLabel.innerHTML = "POI Name: ";

          // Input for name field
          this.nameElement = document.createElement('input');
          this.nameElement.setAttribute("type", "text");
          this.nameElement.id = "poiName";

          // Label for poi type
          this.typeLabel = document.createElement('label');
          this.typeLabel.innerHTML = "POI Type: ";

          // Input for poi type
          this.typeElement = document.createElement('input');
          this.typeElement.setAttribute("type", "text");
          this.typeElement.id = "poiType";

          // Label for poi country
          this.countryLabel = document.createElement('label');
          this.countryLabel.innerHTML = "Country: ";

          // Input for poi country
          this.countryElement = document.createElement('input');
          this.countryElement.setAttribute("type", "text");
          this.countryElement.id = "poiCountry";

          // Label for poi region
          this.regionLabel = document.createElement('label');
          this.regionLabel.innerHTML = "Region: ";

          // Input for poi region
          this.regionElement = document.createElement('input');
          this.regionElement.setAttribute("type", "text");
          this.regionElement.id = "poiRegion";

          // Label for description field
          this.descLabel = document.createElement('label');
          this.descLabel.innerHTML = "Description: ";

          // Text area for description field
          this.descElement = document.createElement('textarea');
          this.descElement.id = "poiDescription";

          // Latitude label
          this.latLabel = document.createElement('label');
          this.latLabel.innerHTML = "Lat.: ";

          // Latitude element
          this.latElement = document.createElement('input');
          this.latElement.id = "poiLat";

          // Longitude label
          this.longLabel = document.createElement('label');
          this.longLabel.innerHTML = "Long.: ";

          // Longitude element
          this.longElement = document.createElement('input');
          this.longElement.id = "poiLong";

          // Submit button
          this.submitElement = document.createElement('button');
          this.submitElement.innerHTML = "Submit POI";
          // Button styling and type
          this.submitElement.setAttribute("class", "button");
          this.submitElement.setAttribute("type", "button");

          // Output message box under button
          this.responseOutput = document.createElement('p');
          this.responseOutput.id = "responseOutput";

          // Event handler for button click
          this.submitElement.addEventListener("click", this.submitData);

          // Append table to container.
          container.appendChild(this.createFormTable());

          // Append a line break to container under the table.
          var linebreak = document.createElement('br');
          container.appendChild(linebreak);

          // Append submit button
          container.appendChild(this.submitElement);

          // Append message box
          container.appendChild(this.responseOutput);

          // Return the div to be displayed in html.
          return container;
     }

     // Create table of fields to align them properly
     createFormTable() {
          // Table root element
          var alignTable = document.createElement('table');

          // Table body element
          var tableBody = document.createElement('tbody');

          // Name Row
          var trPOIName = document.createElement('tr');

            // Name label.
            var tdLblPOIName = document.createElement('th');
            tdLblPOIName.appendChild(this.nameLabel);
            trPOIName.appendChild(tdLblPOIName);

            // Name input field.
            var thInputPOIName = document.createElement('th');
            thInputPOIName.appendChild(this.nameElement);
            trPOIName.appendChild(thInputPOIName);

          tableBody.appendChild(trPOIName);

          // POI type row
          var trPOIType = document.createElement('tr');

               // Type Label
               var thLblPOIType = document.createElement('th');
               thLblPOIType.appendChild(this.typeLabel);
               trPOIType.appendChild(thLblPOIType);

               // Type input field.
               var thInputPOIType = document.createElement('th');
               thInputPOIType.appendChild(this.typeElement);
               trPOIType.appendChild(thInputPOIType);

          tableBody.appendChild(trPOIType);

          // POI country row
          var trPOICountry = document.createElement('tr');

               // Country Label
               var thLblPOICountry = document.createElement('th');
               thLblPOICountry.appendChild(this.countryLabel);
               trPOICountry.appendChild(thLblPOICountry);

               // Country input field.
               var thInputPOICountry = document.createElement('th');
               thInputPOICountry.appendChild(this.countryElement);
               trPOICountry.appendChild(thInputPOICountry);

          tableBody.appendChild(trPOICountry);

          // POI region row
          var trPOIRegion = document.createElement('tr');

               // Country Label
               var thLblPOIRegion = document.createElement('th');
               thLblPOIRegion.appendChild(this.regionLabel);
               trPOIRegion.appendChild(thLblPOIRegion);

               // Country input field.
               var thInputPOIRegion = document.createElement('th');
               thInputPOIRegion.appendChild(this.regionElement);
               trPOIRegion.appendChild(thInputPOIRegion);

          tableBody.appendChild(trPOIRegion);

          // POI latlon row
          var trPOILatLon = document.createElement('tr');

               // Lat label
               var thLblPOILat = document.createElement('th');
               thLblPOILat.appendChild(this.latLabel);
               trPOILatLon.appendChild(thLblPOILat);

               // Lat field
               var thInputPOILat = document.createElement('th');
               thInputPOILat.appendChild(this.latElement);
               trPOILatLon.appendChild(thInputPOILat);

               // Lon label
               var thLblPOILon = document.createElement('th');
               thLblPOILon.appendChild(this.longLabel);
               trPOILatLon.appendChild(thLblPOILon);

               // Lon field
               var thInputPOILon = document.createElement('th');
               thInputPOILon.appendChild(this.longElement);
               trPOILatLon.appendChild(thInputPOILon);

          tableBody.appendChild(trPOILatLon);

          // POI description row
          var trPOIDesc = document.createElement('tr');

               // Description Label
               var thLblPOIDesc = document.createElement('th');
               thLblPOIDesc.appendChild(this.descLabel);
               trPOIDesc.appendChild(thLblPOIDesc);

               // Description input field.
               var thInputPOIDesc = document.createElement('th');
               thInputPOIDesc.appendChild(this.descElement);
               trPOIDesc.appendChild(thInputPOIDesc);

          tableBody.appendChild(trPOIDesc);

          // Append tablebody to table
          alignTable.appendChild(tableBody);

          return alignTable;
     }

}
