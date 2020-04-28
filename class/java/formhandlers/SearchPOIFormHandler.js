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

          // Root. Holds container and the search results box
          var rootpane = document.createElement('div')
          rootpane.className = "dynamicform";

          // Container div for the table and heading
          var container = document.createElement('div');
          container.id = "searchFormContainer";

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

          // Div to hold search results table. Underneath search response text area
          this.searchResultsContainer = document.createElement('div');
          this.searchResultsContainer.id = "searchResultsContainer";
          this.searchResultsContainer.className = "dynamicform bordered filled";

          // Create form table and append
          container.appendChild(this.createFormTable());

          // Append a line break to container under the table.
          container.appendChild(document.createElement('br'));

          // Append submit button
          container.appendChild(this.submitElement);

          // Append message box
          container.appendChild(this.searchResponseOutput);

          // Append the form container, then a line break, then the search results box.
          rootpane.appendChild(container);
          rootpane.appendChild(this.searchResultsContainer);

          // Return the div to be displayed in html.
          return rootpane;
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

     // Open leave review form for a specific POI.
     leaveReview(poiID) {
          console.log(poiID);
          console.log("leave review test");
     }

     viewReviews(poiID) {
          console.log(poiID);
          console.log("view review test" + poiID);
     }

     recommend(poiID) {
          console.log(poiID);
          console.log("recommend test" + poiID);
     }

     // Event handler for search poi button. Get data and GET search results from Database using field and value.
     submitData(CSRF) {

          // 'this' will change when the callback function is called.
          // Aliasing the global context of 'this' allows us to access class methods from the callback.
          var classContextThis = this;

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
               //document.getElementById("searchResponseOutput").innerHTML = responseData.target.responseText;
               var POIJSONArr = responseData.target.responseText.split("BREAK");

               // Search results table root element
               var rootTable = document.createElement('table');
               // Table body element
               var rootTableBody = document.createElement('tbody');

                    // Parse POI JSON into dynamic object.
                    for (let i = 0; i < 4; i++) {
                         var POI = JSON.parse(POIJSONArr[i]);

                         // Row to display all details of a POI. Inside is another table with the rows showing the details.
                         var rootTableRow = document.createElement('tr');

                         // Format of search result item (One per table row):
                         //        <Name> : <Region>
                         //        <Type> in <Country>
                         //        Coords: <Lat>, <Lon>
                         //        <Description>
                         //        This has been recommended <Recs> times.
                         //        <RECOMMEND BUTTON> <LEAVE REVIEW BUTTON> <VIEW REVIEWS BUTTON>

                         var rowTable = document.createElement('table');
                         rowTable.className = "nospace";
                         rowTable.setAttribute('cellspacing', '0');
                         var rowTableBody = document.createElement('tbody');

                              // Name heading
                              var trHeading = document.createElement("tr");
                                   var thHeading = document.createElement("th");
                                   var nameHeader = document.createElement("h2");
                                   nameHeader.innerHTML = POI.name + ", " + POI.region + " (ID: " + POI.ID + ")";
                                   thHeading.appendChild(nameHeader);
                                   trHeading.appendChild(thHeading);
                              rowTableBody.appendChild(trHeading);
                              rowTableBody.appendChild(document.createElement('br')); // Break

                              // ID Label
                              var trID = document.createElement("tr");
                                   var thID = document.createElement("th");
                                   var pID = document.createElement("h3");
                                   pID.innerHTML = "ID: " + POI.ID;
                                   pID.id = "poiID" + POI.ID;
                                   thID.appendChild(pID);
                                   trID.appendChild(thID);
                              rowTableBody.appendChild(trID);
                              rowTableBody.appendChild(document.createElement('br')); // Break

                              // Type Label
                              var trType = document.createElement('tr');
                                   var thType = document.createElement("th");
                                   var pType = document.createElement("h3");
                                   // Capitalise the type.
                                   pType.innerHTML = (POI.type.charAt(0).toUpperCase() + POI.type.slice(1)) + " in " + POI.country;
                                   thType.appendChild(pType);
                                   trType.appendChild(thType);
                              rowTableBody.appendChild(trType);
                              rowTableBody.appendChild(document.createElement('br')); // Break

                              // Coords Label
                              var trCoords = document.createElement('tr');
                                   var thCoords = document.createElement("th");
                                   var pCoords = document.createElement("h3");
                                   pCoords.innerHTML = "Coords: " + POI.latitude + ", " + POI.longitude;
                                   thCoords.appendChild(pCoords);
                                   trCoords.appendChild(thCoords);
                              rowTableBody.appendChild(trCoords);
                              rowTableBody.appendChild(document.createElement('br')); // Break

                              // Description Label
                              var trDesc = document.createElement('tr');
                                   var thDesc = document.createElement('th');
                                   var pDesc = document.createElement('h3');
                                   pDesc.innerHTML = POI.description;
                                   thDesc.appendChild(pDesc);
                                   trDesc.appendChild(thDesc);
                              rowTableBody.appendChild(trDesc);
                              rowTableBody.appendChild(document.createElement('br')); // Break

                              // Links line
                              var trLinks = document.createElement('tr');
                                   // Recommend link.
                                   var thRecommend = document.createElement('th');
                                   var aRecommend = document.createElement('a');
                                   aRecommend.className = "poiLink";
                                   aRecommend.innerHTML = "Recommend";
                                   aRecommend.addEventListener("click", function() { classContextThis.recommend(pID.textContent.split(": ")[1]); } );
                                   thRecommend.appendChild(aRecommend);
                                   trLinks.appendChild(thRecommend);

                                   // Leave review link
                                   var thLeaveReview = document.createElement('th');
                                   var aLeaveReview = document.createElement('a');
                                   aLeaveReview.className = "poiLink";
                                   aLeaveReview.innerHTML = "Leave Review";
                                   aLeaveReview.addEventListener("click", function() { classContextThis.leaveReview(pID.textContent.split(": ")[1]); });
                                   thRecommend.appendChild(aLeaveReview);
                                   trLinks.appendChild(thLeaveReview);

                                   // View reviews link
                                   var thViewReviews = document.createElement('th');
                                   var aViewReviews = document.createElement('a');
                                   aViewReviews.className = "poiLink";
                                   aViewReviews.innerHTML = "View Reviews";
                                   aViewReviews.addEventListener("click", function() { classContextThis.viewReviews(pID.textContent.split(": ")[1]); });
                                   thRecommend.appendChild(aViewReviews);
                                   trLinks.appendChild(thViewReviews);

                              rowTableBody.appendChild(trLinks);
                              rowTableBody.appendChild(document.createElement('br')); // Break

                         rowTable.appendChild(rowTableBody);
                         rootTableRow.appendChild(rowTable);

                         rootTableBody.appendChild(rootTableRow);
                    }

               rootTable.appendChild(rootTableBody);

               searchResultsContainer.appendChild(rootTable);

          };

          // Specify the callback function and send the request.
          httpRequest.addEventListener("load", responseCallback);
          httpRequest.send();

     }
}
