class SearchPOIFormHandler {

     // This class uses controls as public fields such that we can access their data and use it to search the database.
     // It is responsible for creating the Search POI form interface, and GETing the search data from the database.

     // Public constructor, allow instantiation
     constructor(CSRFToken) {
          // CSRF token generated from php just before the class was instantiated.
          this.CSRF = CSRFToken;
     }

     // Assemble a combobox with all the DB fields in the drop down.
     assembleSearchFieldCombobox() {
          // Create combobox
          var cmbSearchFields = document.createElement("SELECT");

          // Combobox option for ID
          var optionID = document.createElement("option");
          optionID.setAttribute("value", "ID")
          // Add text to option
          var optionTxtID = document.createTextNode("ID");
          optionID.appendChild(optionTxtID);

          // Combobox option for name
          var optionName = document.createElement("option");
          optionName.setAttribute("value", "Name")
          // Add text to option
          var optionTxtName = document.createTextNode("Name");
          optionName.appendChild(optionTxtName);

          // Combobox option for type
          var optionType = document.createElement("option");
          optionType.setAttribute("value", "Type")
          // Add text to option
          var optionTxtType = document.createTextNode("Type");
          optionType.appendChild(optionTxtType);

          // Combobox option for country
          var optionCountry = document.createElement("option");
          optionCountry.setAttribute("value", "Country")
          // Add text to option
          var optionTxtCountry = document.createTextNode("Country");
          optionCountry.appendChild(optionTxtCountry);

          // Combobox option for region
          var optionRegion = document.createElement("option");
          optionRegion.setAttribute("value", "Region")
          // Add text to option
          var optionTxtRegion = document.createTextNode("Region");
          optionRegion.appendChild(optionTxtRegion);

          // Add options to combobox
          cmbSearchFields.appendChild(optionID);
          cmbSearchFields.appendChild(optionName);
          cmbSearchFields.appendChild(optionType);
          cmbSearchFields.appendChild(optionCountry);
          cmbSearchFields.appendChild(optionRegion);

          return cmbSearchFields;
     }

     // Create the form UI to display on screen
     createForm() {
          // Container div for the table and heading
          var container = document.createElement('div');
          container.className = "dynamicform bordered";

          // Form heading
          var heading = document.createElement('h2');
          heading.innerHTML = "Search POIs";

          // Underline heading
          var line = document.createElement('hr');

          // Add heading and heading underline.
          container.appendChild(heading);
          container.appendChild(line);

          // Label for search field
          this.searchFieldLabel = document.createElement('label');
          this.searchFieldLabel.innerHTML = "Field to search on: ";

          // Create search field combobox
          this.searchFieldElement = this.assembleSearchFieldCombobox();
          this.searchFieldElement.id = "searchFieldElement";

          // Label for search value
          this.searchValueLabel = document.createElement('label');
          this.searchValueLabel.innerHTML = "Value to search for:";

          // Input for search value
          this.searchValueElement = document.createElement('input');
          this.searchValueElement.setAttribute("type", "text");
          this.searchValueElement.id = "searchValueElement";

          // Search button
          this.submitElement = document.createElement('button');
          this.submitElement.id = "poiSearch";
          this.submitElement.innerHTML = "Search POIs";
          // Button styling and type
          this.submitElement.setAttribute("class", "button");
          this.submitElement.setAttribute("type", "button");

          // Output message box under button
          this.searchResponseOutput = document.createElement('p');
          this.searchResponseOutput.id = "searchResponseOutput";

          // Create form table and append
          container.appendChild(this.createFormTable());

          // Append a line break to container under the table.
          var linebreak = document.createElement('br');
          container.appendChild(linebreak);

          // Append submit button
          container.appendChild(this.submitElement);

          // Append message box
          container.appendChild(this.searchResponseOutput);

          // Return the div to be displayed in html.
          return container;
     }

     // Create table of fields to align them properly
     createFormTable() {
          // Table root element
          var alignTable = document.createElement('table');

          // Table body element
          var tableBody = document.createElement('tbody');

          // Search field combobox row. Allows user to choose which DB field to search on.
          var trPOISearchField = document.createElement('tr');

               // Search Field label.
               var thLblPOISearchField = document.createElement('th');
               thLblPOISearchField.appendChild(this.searchFieldLabel);
               trPOISearchField.appendChild(thLblPOISearchField);

               // Search field combobox.
               var thInputSearchField = document.createElement('th');
               thInputSearchField.appendChild(this.searchFieldElement);
               trPOISearchField.appendChild(thInputSearchField);

          tableBody.appendChild(trPOISearchField);

          // Search value combobox row. Allows user to enter value to search on.
          var trPOISearchValue = document.createElement('tr');

               // Search Field label.
               var thLblPOISearchValue = document.createElement('th');
               thLblPOISearchValue.appendChild(this.searchValueLabel);
               trPOISearchValue.appendChild(thLblPOISearchValue);

               // Search field combobox.
               var thInputSearchValue = document.createElement('th');
               thInputSearchValue.appendChild(this.searchValueElement);
               trPOISearchValue.appendChild(thInputSearchValue);

          tableBody.appendChild(trPOISearchValue);

          // Append tablebody to table
          alignTable.appendChild(tableBody);

          return alignTable;
     }

     // Event handler for search poi button. Get data and GET search results from Database using field and value.
     submitData(CSRF) {

          // XML HTTP request object.
          var httpRequest = new XMLHttpRequest();

          // Values from form.
          var searchField = document.getElementById("searchFieldElement").value; // Combobox value
          var searchValue = document.getElementById("searchValueElement").value; // Text box value

          // Create query string for get from values
          var queryString = "?" + "searchField=" + searchField + "&" + "searchValue=" + searchValue;

          // Open the request using GET and the query string.
          httpRequest.open('GET', '../../pointsofinterest/script/SearchPOIs.php' + queryString);

          // Callback function, interpret response from SearchPOI.php.
          var responseCallback = function handlePOIResponse(responseData) {
               document.getElementById("searchResponseOutput").innerHTML = responseData.target.responseText;
          };

          // Specify the callback function and send the request.
          httpRequest.addEventListener("load", responseCallback);
          httpRequest.send();

          //document.getElementById("searchResponseOutput").innerHTML = '../../pointsofinterest/script/SearchPOIs.php' + queryString;

     }

}
