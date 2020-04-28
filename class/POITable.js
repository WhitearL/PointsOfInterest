class POITable {

     constructor(JSONText) {

          // Search results table root element
          var rootTable = document.createElement('table');
          // Table body element
          var rootTableBody = document.createElement('tbody');

          var POI = JSON.parse(JSONText);

          this.ID = POI.ID;

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
                    aRecommend.addEventListener("click", function() { classContextThis.recommend(document.getElementById("poiID").textContent.split(": ")[1]); } );
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

}
